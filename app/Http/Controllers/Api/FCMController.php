<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FCMService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FCMController extends Controller
{
    private FCMService $fcmService;

    public function __construct(FCMService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    /**
     * Register user's FCM token
     * POST /api/fcm/register-token
     */
    public function registerToken(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'fcm_token' => 'required|string|max:500',
                'device_type' => 'nullable|string|in:android,ios,web'
            ]);

            $user = User::find(Auth::id());
            $user->fcm_token = $request->fcm_token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token registered successfully',
                'data' => [
                    'user_id' => $user->id,
                    'token_registered' => true
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register FCM token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user's FCM token
     * POST /api/fcm/update-token
     */
    public function updateToken(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'fcm_token' => 'required|string|max:500',
                'device_type' => 'nullable|string|in:android,ios,web'
            ]);

            $user = User::find(Auth::id());
            $user->fcm_token = $request->fcm_token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token updated successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update FCM token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove user's FCM token
     * DELETE /api/fcm/remove-token
     */
    public function removeToken(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::id());
            $user->fcm_token = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove FCM token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test notification to user
     * POST /api/fcm/test-notification
     */
    public function testNotification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:200',
                'body' => 'required|string|max:500'
            ]);

            $user = User::find(Auth::id());

            if (!$user->fcm_token) {
                return response()->json([
                    'success' => false,
                    'message' => 'No FCM token found for user'
                ], 400);
            }

            $result = $this->fcmService->sendNotificationToToken(
                $user->fcm_token,
                $request->title,
                $request->body
            );

            return response()->json([
                'success' => true,
                'message' => 'Test notification sent successfully',
                'firebase_response' => $result
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save user's FCM token
     * POST /api/user/fcm-token
     */
    public function saveFCMToken(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'fcm_token' => 'required|string|max:500'
            ]);

            $user = User::find(Auth::id());
            $user->fcm_token = $request->fcm_token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token saved successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save FCM token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove user's FCM token
     * DELETE /api/user/fcm-token
     */
    public function removeFCMToken(): JsonResponse
    {
        try {
            $user = User::find(Auth::id());
            $user->fcm_token = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove FCM token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test notification to user
     * POST /api/user/test-notification
     */
    public function sendTestNotification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:500'
            ]);

            $user = User::find(Auth::id());

            if (!$user->fcm_token) {
                return response()->json([
                    'success' => false,
                    'message' => 'No FCM token found for this user'
                ], 400);
            }

            $success = $this->fcmService->sendToUser(
                $user,
                $request->title,
                $request->body,
                ['type' => 'test']
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test notification sent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send notification'
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Send notification to specific user
     * POST /api/admin/send-notification
     */
    public function sendAdminNotification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:500',
                'data' => 'nullable|array'
            ]);

            $user = User::findOrFail($request->user_id);

            if (!$user->fcm_token) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has no FCM token'
                ], 400);
            }

            $success = $this->fcmService->sendToUser(
                $user,
                $request->title,
                $request->body,
                array_merge($request->data ?? [], ['type' => 'admin'])
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification sent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send notification'
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Send notification to multiple users
     * POST /api/admin/send-bulk-notification
     */
    public function sendBulkNotification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_ids' => 'required|array|min:1',
                'user_ids.*' => 'integer|exists:users,id',
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:500',
                'data' => 'nullable|array'
            ]);

            $users = User::whereIn('id', $request->user_ids)
                ->whereNotNull('fcm_token')
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users with FCM tokens found'
                ], 400);
            }

            $results = $this->fcmService->sendToMultipleUsers(
                $users->toArray(),
                $request->title,
                $request->body,
                array_merge($request->data ?? [], ['type' => 'admin_bulk'])
            );

            $successCount = count(array_filter($results));
            $totalCount = count($results);

            return response()->json([
                'success' => true,
                'message' => "Notifications sent to {$successCount} out of {$totalCount} users",
                'details' => [
                    'success_count' => $successCount,
                    'total_count' => $totalCount,
                    'results' => $results
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send bulk notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
