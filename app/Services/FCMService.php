<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FCMService
{
    private string $projectId;
    private string $fcmUrl;
    private array $serviceAccount;

    public function __construct()
    {
        $this->loadServiceAccount();
        $this->projectId = $this->serviceAccount['project_id'] ?? '';
        $this->fcmUrl = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
    }

    /**
     * Load Firebase service account from JSON file
     */
    private function loadServiceAccount(): void
    {
        $path = storage_path('firebase-service-account.json');

        if (!file_exists($path)) {
            throw new \Exception('Firebase service account file not found');
        }

        $content = file_get_contents($path);
        $this->serviceAccount = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid Firebase service account JSON');
        }
    }

    /**
     * Base64 URL-safe encoding
     */
    private function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Get OAuth 2.0 access token for Firebase
     */
    private function getAccessToken(): string
    {
        $jwt = $this->createJWT();

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to get Firebase access token');
        }

        $data = $response->json();
        return $data['access_token'] ?? '';
    }

    /**
     * Create JWT for Firebase authentication
     */
    private function createJWT(): string
    {
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $now = time();
        $payload = [
            'iss' => $this->serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $headerEncoded = $this->base64url_encode(json_encode($header));
        $payloadEncoded = $this->base64url_encode(json_encode($payload));

        $signature = '';
        openssl_sign(
            $headerEncoded . '.' . $payloadEncoded,
            $signature,
            $this->serviceAccount['private_key'],
            OPENSSL_ALGO_SHA256
        );

        $signatureEncoded = $this->base64url_encode($signature);

        return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
    }
    /**
     * Send notification to a specific user
     */
    public function sendToUser(User $user, string $title, string $body, array $data = []): bool
    {
        if (!$user->fcm_token) {
            Log::warning("User {$user->id} has no FCM token");
            return false;
        }

        return $this->sendToToken($user->fcm_token, $title, $body, $data);
    }

    /**
     * Send notification to a specific token
     */
    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        if (!$this->projectId) {
            Log::error('Firebase project ID is not configured');
            return false;
        }

        try {
            $accessToken = $this->getAccessToken();

            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => array_map('strval', $data), // FCM v1 requires string values
                    'android' => [
                        'notification' => [
                            'sound' => 'default'
                        ]
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'sound' => 'default'
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->fcmUrl, $payload);

            if ($response->successful()) {
                Log::info('FCM notification sent successfully', ['token' => substr($token, 0, 10) . '...']);
                return true;
            } else {
                Log::error('FCM notification failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('FCM notification exception', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send notification to multiple tokens
     */
    public function sendToMultipleTokens(array $tokens, string $title, string $body, array $data = []): array
    {
        $results = [];

        foreach ($tokens as $token) {
            $results[$token] = $this->sendToToken($token, $title, $body, $data);
        }

        return $results;
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMultipleUsers(array $users, string $title, string $body, array $data = []): array
    {
        $results = [];

        foreach ($users as $user) {
            if ($user->fcm_token) {
                $results[$user->id] = $this->sendToUser($user, $title, $body, $data);
            } else {
                $results[$user->id] = false;
                Log::warning("User {$user->id} has no FCM token");
            }
        }

        return $results;
    }

    /**
     * Send order status notification
     */
    public function sendOrderStatusNotification(User $user, string $status, array $orderData = []): bool
    {
        $statusMessages = [
            'paid' => 'Payment confirmed! Your order is being processed.',
            'processing' => 'Your order is being processed.',
            'shipped' => 'Your order has been shipped.',
            'delivered' => 'Your order has been delivered! Download links sent to your email.',
            'cancelled' => 'Your order has been cancelled.',
        ];

        $title = 'Order Update';
        $body = $statusMessages[$status] ?? "Your order status has been updated to: {$status}";

        $data = array_merge([
            'type' => 'order_status',
            'status' => $status,
        ], $orderData);

        return $this->sendToUser($user, $title, $body, $data);
    }

    /**
     * Send notification to specific FCM token
     */
    public function sendNotificationToToken(string $token, string $title, string $body, array $data = []): array
    {
        try {
            $accessToken = $this->getAccessToken();
            $projectId = $this->serviceAccount['project_id'];

            $message = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body
                    ],
                    'data' => array_map('strval', $data) // FCM requires all data values to be strings
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $message);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info("FCM notification sent successfully to token: " . substr($token, 0, 20) . "...", [
                    'response' => $responseData
                ]);
                return [
                    'success' => true,
                    'response' => $responseData
                ];
            } else {
                $error = $response->json();
                Log::error("Failed to send FCM notification to token: " . substr($token, 0, 20) . "...", [
                    'error' => $error,
                    'status' => $response->status()
                ]);
                return [
                    'success' => false,
                    'error' => $error,
                    'status' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error("Exception sending FCM notification to token: " . substr($token, 0, 20) . "...", [
                'exception' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send service status notification
     */
    public function sendServiceStatusNotification(User $user, string $status, array $serviceData = []): bool
    {
        $statusMessages = [
            'accepted' => 'Your service request has been accepted.',
            'in_progress' => 'Your service is in progress.',
            'completed' => 'Your service has been completed.',
            'cancelled' => 'Your service request has been cancelled.',
        ];

        $title = 'Service Update';
        $body = $statusMessages[$status] ?? "Your service status has been updated to: {$status}";

        $data = array_merge([
            'type' => 'service_status',
            'status' => $status,
        ], $serviceData);

        return $this->sendToUser($user, $title, $body, $data);
    }
}
