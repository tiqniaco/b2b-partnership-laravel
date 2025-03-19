<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Notification;
use App\Models\Patient;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    function sendNotificationV1($topic, $title, $body, $data = [])
    {
        // مسار ملف JSON الخاص بـ Service Account
        $serviceAccountFile = storage_path('firebase-service-account.json');

        // قراءة البيانات من ملف JSON
        $serviceAccount = json_decode(file_get_contents($serviceAccountFile), true);

        // إعداد توكين JWT
        $nowSeconds = time();
        $payload = [
            'iss' => $serviceAccount['client_email'],
            'sub' => $serviceAccount['client_email'],
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $nowSeconds,
            'exp' => $nowSeconds + 3600,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        ];

        $jwt = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

        // الحصول على توكين OAuth 2.0
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        $accessToken = $response->json()['access_token'];

        // إعداد هيكل الطلب
        $message = [
            'message' => [
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => (object) $data,
            ],
        ];

        // إرسال الطلب إلى FCM
        $projectId = $serviceAccount['project_id'];
        $fcmUrl = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

        $response = Http::withToken($accessToken)
            ->post($fcmUrl, $message);

        // إرجاع الاستجابة
        return $response->json();
    }

    function sendNotification($topic, $title, $body, $data = [])
    {
        try {

            // مسار ملف JSON الخاص بـ Service Account
            $serviceAccountFile = storage_path('firebase-service-account.json');

            // قراءة البيانات من ملف JSON
            $serviceAccount = json_decode(file_get_contents($serviceAccountFile), true);

            // إعداد توكين JWT
            $nowSeconds = time();
            $payload = [
                'iss' => $serviceAccount['client_email'],
                'sub' => $serviceAccount['client_email'],
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $nowSeconds,
                'exp' => $nowSeconds + 3600,
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            ];

            $jwt = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

            // الحصول على توكين OAuth 2.0
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            $accessToken = $response->json()['access_token'];

            // إعداد هيكل الطلب
            $message = [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => (object) $data,
                ],
            ];

            // إرسال الطلب إلى FCM
            $projectId = $serviceAccount['project_id'];
            $fcmUrl = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

            $response = Http::withToken($accessToken)
                ->post($fcmUrl, $message);
            // إرجاع الاستجابة
            // $response->json();

            $notification = new Notification();

            $notification->title = $title;
            $notification->topic = $topic;
            $notification->message = $body;
            $notification->payload = json_encode($data);

            $notification->save();

            return response()->json([
                'status' => "success",
                'message' => 'Notification created successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function send(Request $request)
    {
        try {
            $result = $this->sendNotificationV1($request->fcmToken, $request->title, $request->message);
            // $result = $this->sendFCM($request->title, $request->message, $request->topic, $request->accessToken, $request->fcmToken);
            return response()->json([
                'status' => "success",
                'message' => $result,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'topic' => 'required',
                'message' => 'required',
                'payload' => 'nullable',
            ]);

            $result = $this->sendNotificationV1(topic: $request->topic, title: $request->title, body: $request->message, data: $request->payload);
            if ($result['name'] != null) {
                $notification = new Notification();

                $notification->title = $request->title;
                $notification->topic = $request->topic;
                $notification->message = $request->message;
                $notification->payload = $request->payload;

                $notification->save();

                return response()->json([
                    'status' => "success",
                    'message' => 'Notification created successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => 'Something went wrong',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {

            $request->validate([
                'role' => 'nullable',
                'id' => 'nullable',
            ]);

            if ($request->role == 'admin') {
                $notifications = DB::select("SELECT * FROM notifications WHERE topic = \"admins\" ORDER BY created_at DESC");

                return response()->json([
                    'status' => "success",
                    'data' => $notifications,
                ], 200);
            }

            if ($request->role == 'client') {
                $notifications = DB::select("SELECT * FROM notifications WHERE topic = \"user{$request->id}\" OR topic = \"clients\" OR topic = \"all\" ORDER BY created_at DESC");


                return response()->json([
                    'status' => "success",
                    'data' => $notifications,
                ], 200);
            }

            if ($request->role == 'provider') {
                $notifications = DB::select("SELECT * FROM notifications WHERE topic = \"user{$request->id}\" OR topic = \"providers\" OR topic = \"all\" ORDER BY created_at DESC");

                return response()->json([
                    'status' => "success",
                    'data' => $notifications,
                ], 200);
            }

            $notifications = DB::select('SELECT * FROM notifications WHERE topic = "clients" OR topic = "all" ORDER BY created_at DESC');
            return response()->json([
                'status' => "success",
                'data' => $notifications,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
