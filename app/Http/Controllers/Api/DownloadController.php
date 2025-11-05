<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\DownloadToken;
use App\Services\DownloadService;
use App\Services\DownloadConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class DownloadController extends Controller
{
    private DownloadService $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    /**
     * Download demo file for a product
     * GET /api/store/products/{id}/demo
     */
    public function downloadDemo(int $productId)
    {
        try {
            $product = StoreProduct::findOrFail($productId);

            return $this->downloadService->downloadDemo($product);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Demo file not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Generate download token for purchased product
     * POST /api/store/generate-download-token
     */
    public function generateDownloadToken(Request $request): JsonResponse
    {
        try {
            // Get validation rules from DownloadConfigService
            $minDownloads = DownloadConfigService::getMinDownloads();
            $maxDownloads = DownloadConfigService::getMaxDownloadsLimit();
            $minHours = DownloadConfigService::getMinExpiryHours();
            $maxHours = DownloadConfigService::getMaxExpiryHours();

            $request->validate([
                'product_id' => 'required|integer|exists:store_products,id',
                'user_id' => 'required|integer|exists:users,id',
                'order_id' => 'required|integer|exists:store_orders,id',
                'expires_in_hours' => "nullable|integer|min:{$minHours}|max:{$maxHours}",
                'max_downloads' => "nullable|integer|min:{$minDownloads}|max:{$maxDownloads}"
            ]);

            $product = StoreProduct::findOrFail($request->product_id);
            $user = User::findOrFail($request->user_id);

            $token = $this->downloadService->createDownloadToken(
                $user,
                $product,
                $request->max_downloads, // Will use config default if null
                $request->expires_in_hours ? ceil($request->expires_in_hours / 24) : null, // Convert hours to days
                $request->order_id
            );
            return response()->json([
                'success' => true,
                'message' => 'Download token generated successfully',
                'data' => [
                    'token' => $token->token,
                    'download_url' => url("/download/{$token->token}"),
                    'expires_at' => $token->expires_at,
                    'max_downloads' => $token->max_downloads,
                    'downloads_count' => $token->downloads_count
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
                'message' => 'Failed to generate download token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download file using token
     * GET /download/{token}
     */
    public function downloadByToken(string $token)
    {
        try {
            return $this->downloadService->downloadByToken($token);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Download failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get download token status
     * GET /api/store/download-token/{token}/status
     */
    public function getTokenStatus(string $token): JsonResponse
    {
        try {
            $downloadToken = DownloadToken::where('token', $token)->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $downloadToken->token,
                    'product_id' => $downloadToken->product_id,
                    'user_id' => $downloadToken->user_id,
                    'order_id' => $downloadToken->order_id,
                    'expires_at' => $downloadToken->expires_at,
                    'max_downloads' => $downloadToken->max_downloads,
                    'downloads_count' => $downloadToken->downloads_count,
                    'is_expired' => $downloadToken->expires_at < now(),
                    'remaining_downloads' => $downloadToken->max_downloads - $downloadToken->downloads_count,
                    'can_download' => $downloadToken->expires_at >= now() &&
                        $downloadToken->downloads_count < $downloadToken->max_downloads,
                    'created_at' => $downloadToken->created_at,
                    'last_downloaded_at' => $downloadToken->last_downloaded_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * List user's download tokens
     * GET /api/store/my-download-tokens
     */
    public function myDownloadTokens(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $tokens = DownloadToken::with(['product:id,name,file_path', 'order:id,total'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $tokens->items(),
                'pagination' => [
                    'current_page' => $tokens->currentPage(),
                    'last_page' => $tokens->lastPage(),
                    'per_page' => $tokens->perPage(),
                    'total' => $tokens->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve download tokens',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get download configuration settings
     * GET /api/store/download-config
     */
    public function getDownloadConfig(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => DownloadConfigService::getAllSettings()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve download configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
