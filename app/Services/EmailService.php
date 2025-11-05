<?php

namespace App\Services;

use App\Models\User;
use App\Models\StoreProduct;
use App\Models\StoreOrder;
use App\Models\DownloadToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send download links email after successful order
     */
    public function sendDownloadLinksEmail(User $user, StoreOrder $order, array $downloadTokens): bool
    {
        try {
            $emailData = [
                'user' => $user,
                'order' => $order,
                'downloadTokens' => $downloadTokens,
                'expires_at' => $downloadTokens[0]->expires_at ?? null,
                'app_name' => config('app.name', 'B2B Partnership'),
            ];

            Mail::send('emails.download-links', $emailData, function ($message) use ($user, $order) {
                $message->to($user->email, $user->name)
                    ->subject('تم تأكيد طلبك - روابط التحميل - B2B Partnership')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Download links email sent to user {$user->id} for order {$order->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send download links email to user {$user->id}", [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
            return false;
        }
    }

    /**
     * Send download link email for individual product
     */
    public function sendIndividualDownloadEmail(User $user, StoreProduct $product, DownloadToken $downloadToken): bool
    {
        try {
            $emailData = [
                'user' => $user,
                'product' => $product,
                'downloadToken' => $downloadToken,
                'download_url' => url("/download/{$downloadToken->token}"),
                'expires_at' => $downloadToken->expires_at,
                'max_downloads' => $downloadToken->max_downloads,
                'app_name' => config('app.name', 'B2B Partnership'),
            ];

            Mail::send('emails.individual-download', $emailData, function ($message) use ($user, $product) {
                $message->to($user->email, $user->name)
                    ->subject("رابط التحميل: {$product->name} - B2B Partnership")
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Individual download email sent to user {$user->id} for product {$product->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send individual download email to user {$user->id}", [
                'error' => $e->getMessage(),
                'product_id' => $product->id
            ]);
            return false;
        }
    }

    /**
     * Send order status update email
     */
    public function sendOrderStatusEmail(User $user, StoreOrder $order, string $status): bool
    {
        try {
            $statusMessages = [
                'paid' => 'تم تأكيد الدفع',
                'processing' => 'قيد المعالجة',
                'shipped' => 'تم الشحن',
                'delivered' => 'تم التسليم',
                'cancelled' => 'تم الإلغاء',
            ];

            $emailData = [
                'user' => $user,
                'order' => $order,
                'status' => $status,
                'status_message' => $statusMessages[$status] ?? $status,
                'app_name' => config('app.name', 'B2B Partnership'),
            ];

            Mail::send('emails.order-status', $emailData, function ($message) use ($user, $order, $status) {
                $statusMessages = [
                    'paid' => 'تم تأكيد الدفع',
                    'processing' => 'قيد المعالجة',
                    'shipped' => 'تم الشحن',
                    'delivered' => 'تم التسليم',
                    'cancelled' => 'تم الإلغاء',
                ];

                $statusMessage = $statusMessages[$status] ?? $status;
                $message->to($user->email, $user->name)
                    ->subject("تحديث الطلب #{$order->id} - {$statusMessage} - B2B Partnership")
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Order status email sent to user {$user->id} for order {$order->id}, status: {$status}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send order status email to user {$user->id}", [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'status' => $status
            ]);
            return false;
        }
    }

    /**
     * Send welcome email with account details
     */
    public function sendWelcomeEmail(User $user, string $temporaryPassword = null): bool
    {
        try {
            $emailData = [
                'user' => $user,
                'temporaryPassword' => $temporaryPassword,
                'app_name' => config('app.name', 'B2B Partnership'),
                'login_url' => config('app.url') . '/login',
            ];

            Mail::send('emails.welcome', $emailData, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('مرحباً بك في B2B Partnership - تم تفعيل حسابك')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Welcome email sent to user {$user->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send welcome email to user {$user->id}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail(User $user, string $resetUrl): bool
    {
        try {
            $emailData = [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'app_name' => config('app.name', 'B2B Partnership'),
                'expires_in' => config('auth.passwords.users.expire', 60), // minutes
            ];

            Mail::send('emails.password-reset', $emailData, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('إعادة تعيين كلمة المرور - B2B Partnership')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Password reset email sent to user {$user->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send password reset email to user {$user->id}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
