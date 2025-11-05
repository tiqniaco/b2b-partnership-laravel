<?php

namespace App\Services;

use App\Models\DownloadSetting;

class DownloadConfigService
{
    /**
     * Get default max downloads from database or config
     */
    public static function getDefaultMaxDownloads(): int
    {
        return DownloadSetting::getSetting('default_max_downloads') ?? config('downloads.default_max_downloads', 3);
    }

    /**
     * Get max downloads limit from database or config
     */
    public static function getMaxDownloadsLimit(): int
    {
        return DownloadSetting::getSetting('max_downloads') ?? config('downloads.max_downloads', 10);
    }

    /**
     * Get min downloads from database or config
     */
    public static function getMinDownloads(): int
    {
        return DownloadSetting::getSetting('min_downloads') ?? config('downloads.min_downloads', 1);
    }

    /**
     * Get default expiry hours from database or config
     */
    public static function getDefaultExpiryHours(): int
    {
        return DownloadSetting::getSetting('default_expiry_hours') ?? config('downloads.default_expiry_hours', 24);
    }

    /**
     * Get max expiry hours from database or config
     */
    public static function getMaxExpiryHours(): int
    {
        return DownloadSetting::getSetting('max_expiry_hours') ?? config('downloads.max_expiry_hours', 168);
    }

    /**
     * Get min expiry hours from database or config
     */
    public static function getMinExpiryHours(): int
    {
        return DownloadSetting::getSetting('min_expiry_hours') ?? config('downloads.min_expiry_hours', 1);
    }

    /**
     * Check if unlimited downloads are allowed
     */
    public static function isUnlimitedAllowed(): bool
    {
        return DownloadSetting::getSetting('allow_unlimited') ?? config('downloads.allow_unlimited', false);
    }

    /**
     * Get cleanup days for expired tokens
     */
    public static function getCleanupDays(): int
    {
        return DownloadSetting::getSetting('cleanup_expired_after_days') ?? config('downloads.cleanup_expired_after_days', 30);
    }

    /**
     * Check if download email notifications are enabled
     */
    public static function isSendEmailEnabled(): bool
    {
        return DownloadSetting::getSetting('send_download_email') ?? config('downloads.notifications.send_download_email', true);
    }

    /**
     * Check if expiry warning emails are enabled
     */
    public static function isExpiryWarningEnabled(): bool
    {
        return DownloadSetting::getSetting('send_expiry_warning') ?? config('downloads.notifications.send_expiry_warning', true);
    }

    /**
     * Get warning hours before expiry
     */
    public static function getWarningHoursBeforeExpiry(): int
    {
        return DownloadSetting::getSetting('warning_hours_before_expiry') ?? config('downloads.notifications.warning_hours_before_expiry', 2);
    }

    /**
     * Check if IP restriction is enabled
     */
    public static function isIpRestrictionEnabled(): bool
    {
        return DownloadSetting::getSetting('enable_ip_restriction') ?? config('downloads.security.enable_ip_restriction', false);
    }

    /**
     * Check if user agent check is enabled
     */
    public static function isUserAgentCheckEnabled(): bool
    {
        return DownloadSetting::getSetting('enable_user_agent_check') ?? config('downloads.security.enable_user_agent_check', false);
    }

    /**
     * Validate max downloads and apply limits
     */
    public static function validateMaxDownloads($maxDownloads): int
    {
        if ($maxDownloads === null) {
            return self::getDefaultMaxDownloads();
        }

        $maxDownloads = (int) $maxDownloads;
        $minDownloads = self::getMinDownloads();
        $maxLimit = self::getMaxDownloadsLimit();

        // Check if unlimited is allowed and requested
        if (self::isUnlimitedAllowed() && $maxDownloads <= 0) {
            return -1; // -1 represents unlimited
        }

        // Apply limits
        if ($maxDownloads < $minDownloads) {
            return $minDownloads;
        }

        if ($maxDownloads > $maxLimit) {
            return $maxLimit;
        }

        return $maxDownloads;
    }

    /**
     * Validate expiry hours and apply limits
     */
    public static function validateExpiryHours($expiryHours): int
    {
        if ($expiryHours === null) {
            return self::getDefaultExpiryHours();
        }

        $expiryHours = (int) $expiryHours;
        $minHours = self::getMinExpiryHours();
        $maxHours = self::getMaxExpiryHours();

        // Apply limits
        if ($expiryHours < $minHours) {
            return $minHours;
        }

        if ($expiryHours > $maxHours) {
            return $maxHours;
        }

        return $expiryHours;
    }

    /**
     * Get all settings for API response
     */
    public static function getAllSettings(): array
    {
        return [
            'default_max_downloads' => self::getDefaultMaxDownloads(),
            'max_downloads' => self::getMaxDownloadsLimit(),
            'min_downloads' => self::getMinDownloads(),
            'default_expiry_hours' => self::getDefaultExpiryHours(),
            'max_expiry_hours' => self::getMaxExpiryHours(),
            'min_expiry_hours' => self::getMinExpiryHours(),
            'allow_unlimited' => self::isUnlimitedAllowed(),
            'cleanup_expired_after_days' => self::getCleanupDays(),
            'send_download_email' => self::isSendEmailEnabled(),
            'send_expiry_warning' => self::isExpiryWarningEnabled(),
            'warning_hours_before_expiry' => self::getWarningHoursBeforeExpiry(),
            'enable_ip_restriction' => self::isIpRestrictionEnabled(),
            'enable_user_agent_check' => self::isUserAgentCheckEnabled(),
        ];
    }

    /**
     * Check if database settings exist
     */
    public static function hasDatabaseSettings(): bool
    {
        return DownloadSetting::where('is_active', true)->exists();
    }

    /**
     * Initialize default settings in database if they don't exist
     */
    public static function initializeDefaultSettings(): void
    {
        if (!self::hasDatabaseSettings()) {
            $defaultSettings = [
                'default_max_downloads' => config('downloads.default_max_downloads', 3),
                'max_downloads' => config('downloads.max_downloads', 10),
                'min_downloads' => config('downloads.min_downloads', 1),
                'default_expiry_hours' => config('downloads.default_expiry_hours', 24),
                'max_expiry_hours' => config('downloads.max_expiry_hours', 168),
                'min_expiry_hours' => config('downloads.min_expiry_hours', 1),
                'allow_unlimited' => config('downloads.allow_unlimited', false),
                'cleanup_expired_after_days' => config('downloads.cleanup_expired_after_days', 30),
                'send_download_email' => config('downloads.notifications.send_download_email', true),
                'send_expiry_warning' => config('downloads.notifications.send_expiry_warning', true),
                'warning_hours_before_expiry' => config('downloads.notifications.warning_hours_before_expiry', 2),
                'enable_ip_restriction' => config('downloads.security.enable_ip_restriction', false),
                'enable_user_agent_check' => config('downloads.security.enable_user_agent_check', false),
            ];

            foreach ($defaultSettings as $key => $value) {
                DownloadSetting::setSetting($key, $value);
            }
        }
    }
}
