<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Download Token Settings
    |--------------------------------------------------------------------------
    |
    | These settings control the behavior of download tokens for purchased products.
    | You can modify these values to adjust download limits and expiration times.
    |
    */

    // Default maximum number of downloads per token
    'default_max_downloads' => env('DOWNLOAD_MAX_DOWNLOADS', 3),

    // Minimum allowed downloads per token
    'min_downloads' => 1,

    // Maximum allowed downloads per token
    'max_downloads' => env('DOWNLOAD_MAX_LIMIT', 10),

    // Default expiration time in hours
    'default_expiry_hours' => env('DOWNLOAD_EXPIRY_HOURS', 24),

    // Minimum expiration time in hours
    'min_expiry_hours' => 1,

    // Maximum expiration time in hours (1 week)
    'max_expiry_hours' => env('DOWNLOAD_MAX_EXPIRY_HOURS', 168),

    /*
    |--------------------------------------------------------------------------
    | Advanced Settings
    |--------------------------------------------------------------------------
    */

    // Allow unlimited downloads (set to false for production)
    'allow_unlimited' => env('DOWNLOAD_ALLOW_UNLIMITED', false),

    // Auto-cleanup expired tokens (in days)
    'cleanup_expired_after_days' => env('DOWNLOAD_CLEANUP_DAYS', 30),

    // Email notifications settings
    'notifications' => [
        'send_download_email' => env('DOWNLOAD_SEND_EMAIL', true),
        'send_expiry_warning' => env('DOWNLOAD_EXPIRY_WARNING', true),
        'warning_hours_before_expiry' => env('DOWNLOAD_WARNING_HOURS', 2),
    ],

    // File security settings
    'security' => [
        'enable_ip_restriction' => env('DOWNLOAD_IP_RESTRICTION', false),
        'enable_user_agent_check' => env('DOWNLOAD_USER_AGENT_CHECK', false),
        'token_length' => 64,
    ],
];
