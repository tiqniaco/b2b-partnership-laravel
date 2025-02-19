<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);

            $userId = $request->user_id ?? Auth::user()->id;
            $complaints = Complaint::where('user_id', $userId)
                ->paginate(20);

            return response()->json($complaints, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $request->validate([
                'content' => 'required|string',
                'content_type' => 'required|in:text,image,voice',
            ]);
            switch ($request->content_type) {
                case 'text':
                    $request->validate([
                        'content' => 'required|string',
                    ]);
                    $content = $request->content;
                    break;
                case 'image':
                    $request->validate([
                        'content' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                    ]);
                    $content = 'complaints/images/' . time() . '.' . $request->content->extension();
                    $request->content->move(public_path('complaints/images/'), $content);
                    break;
                case 'voice':

                    $request->validate([
                        'content' => 'required|file|mimes:mp3,wav,ogg|max:50000',
                    ]);
                    $content = 'complaints/images/' . time() . '.' . $request->content->extension();
                    $request->content->move(public_path('complaints/images/'), $content);
                    break;
            }

            $complaint = new Complaint();
            $complaint->user_id = $userId;
            $complaint->content = $content;
            $complaint->content_type = $request->content_type;
            $complaint->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint sended successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $complaint = Complaint::findOrFail($id);
            if (file_exists(public_path($complaint->content))) {
                unlink(public_path($complaint->content));
            }
            $complaint->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint removed successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getComplaintsUsers()
    {
        //SELECT * FROM users WHERE id IN (SELECT DISTINCT user_id FROM complaints);
        try {
            $users = DB::select("SELECT id, name, email, image, country_code, phone, role FROM users WHERE id IN (SELECT DISTINCT user_id FROM complaints);");
            // $users = DB::table("users")->where("id", "in", "(SELECT DISTINCT user_id FROM complaints);")->get();
            return  response()->json([
                "status" => "success",
                "message" => "data fetched successfully",
                "data" => $users,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
