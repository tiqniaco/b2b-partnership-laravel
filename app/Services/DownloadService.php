<?php

namespace App\Services;

use App\Models\DownloadToken;
use App\Models\StoreProduct;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Carbon\Carbon;

class DownloadService
{
    /**
     * Create a download token for a user and product
     */
    public function createDownloadToken(User $user, StoreProduct $product, ?int $maxDownloads = null, ?int $expiryDays = null, ?int $orderId = null): DownloadToken
    {
        // Use DownloadConfigService for better validation and configuration
        $maxDownloads = DownloadConfigService::validateMaxDownloads($maxDownloads);
        $expiryHours = $expiryDays ? ($expiryDays * 24) : null;
        $validatedExpiryHours = DownloadConfigService::validateExpiryHours($expiryHours);
        $expiryDays = ceil($validatedExpiryHours / 24);

        return DownloadToken::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $orderId,
            'token' => DownloadToken::generateToken(),
            'max_downloads' => $maxDownloads,
            'downloads_count' => 0,
            'expires_at' => Carbon::now()->addDays($expiryDays),
        ]);
    }

    /**
     * Download file by token
     */
    public function downloadByToken(string $token): BinaryFileResponse
    {
        $downloadToken = DownloadToken::where('token', $token)->first();

        if (!$downloadToken) {
            abort(404, 'Download link not found');
        }

        if ($downloadToken->isExpired()) {
            abort(410, 'Link expired');
        }

        if ($downloadToken->isLimitReached()) {
            abort(410, 'Download limit reached');
        }

        $product = $downloadToken->product;
        $filePath = $product->file;

        // Check if file exists
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found');
        }

        // Increment download count
        $downloadToken->incrementDownload();

        // Get file info
        $fileName = basename($filePath);
        $fileSize = Storage::disk('public')->size($filePath);
        $fullPath = storage_path('app/public/' . $filePath);

        return response()->download($fullPath, $fileName, [
            'Content-Length' => $fileSize,
        ]);
    }

    /**
     * Download demo file for a product
     */
    public function downloadDemo(StoreProduct $product): BinaryFileResponse
    {
        if (!$product->demo_file) {
            abort(404, 'Demo file not available');
        }

        $filePath = $product->demo_file;

        // Check if file exists
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'Demo file not found');
        }

        // Get file info
        $fileName = 'demo_' . basename($filePath);
        $fileSize = Storage::disk('public')->size($filePath);
        $fullPath = storage_path('app/public/' . $filePath);

        return response()->download($fullPath, $fileName, [
            'Content-Length' => $fileSize,
        ]);
    }

    /**
     * Get download statistics for a product
     */
    public function getDownloadStats(StoreProduct $product): array
    {
        $tokens = $product->downloadTokens();

        return [
            'total_tokens_created' => $tokens->count(),
            'total_downloads' => $tokens->sum('downloads_count'),
            'active_tokens' => $tokens->where('expires_at', '>', Carbon::now())
                ->where('downloads_count', '<', 'max_downloads')
                ->count(),
            'expired_tokens' => $tokens->where('expires_at', '<=', Carbon::now())->count(),
            'exhausted_tokens' => $tokens->whereRaw('downloads_count >= max_downloads')->count(),
        ];
    }
}
