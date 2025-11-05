<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Artisan;

class DownloadSettingsController extends Controller
{
    /**
     * Get all download settings
     */
    public function index()
    {
        try {
            $settings = DownloadSetting::where('is_active', true)->get();

            // If no settings exist, create default ones
            if ($settings->isEmpty()) {
                $this->createDefaultSettings();
                $settings = DownloadSetting::where('is_active', true)->get();
            }

            $formattedSettings = $settings->map(function ($setting) {
                return [
                    'id' => $setting->id,
                    'key' => $setting->key,
                    'value' => $setting->typed_value,
                    'type' => $setting->type,
                    'description' => $setting->description,
                    'updated_at' => $setting->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedSettings,
                'message' => 'Download settings retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve download settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update download settings
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'settings' => 'required|array',
                'settings.*.key' => 'required|string',
                'settings.*.value' => 'required',
            ]);

            $updatedSettings = [];

            foreach ($request->settings as $settingData) {
                $key = $settingData['key'];
                $value = $settingData['value'];

                // Validate specific settings
                $this->validateSpecificSetting($key, $value);

                $setting = DownloadSetting::setSetting(
                    $key,
                    $value,
                    $this->getSettingDescription($key)
                );

                $updatedSettings[] = [
                    'key' => $setting->key,
                    'value' => $setting->typed_value,
                    'type' => $setting->type,
                ];
            }

            // Clear Laravel config cache to reflect changes
            Artisan::call('config:clear');

            return response()->json([
                'success' => true,
                'data' => $updatedSettings,
                'message' => 'Download settings updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update download settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific setting
     */
    public function show($key)
    {
        try {
            $setting = DownloadSetting::where('key', $key)->where('is_active', true)->first();

            if (!$setting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'key' => $setting->key,
                    'value' => $setting->typed_value,
                    'type' => $setting->type,
                    'description' => $setting->description,
                    'updated_at' => $setting->updated_at->format('Y-m-d H:i:s'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve setting: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset settings to default values
     */
    public function reset()
    {
        try {
            // Deactivate all current settings
            DownloadSetting::query()->update(['is_active' => false]);

            // Create default settings
            $this->createDefaultSettings();

            // Clear config cache
            Artisan::call('config:clear');

            return response()->json([
                'success' => true,
                'message' => 'Download settings reset to default values'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create default settings
     */
    private function createDefaultSettings()
    {
        $defaultSettings = [
            'default_max_downloads' => [
                'value' => 3,
                'description' => 'Default number of downloads per token'
            ],
            'max_downloads' => [
                'value' => 10,
                'description' => 'Maximum allowed downloads per token'
            ],
            'min_downloads' => [
                'value' => 1,
                'description' => 'Minimum allowed downloads per token'
            ],
            'default_expiry_hours' => [
                'value' => 24,
                'description' => 'Default token expiry time in hours'
            ],
            'max_expiry_hours' => [
                'value' => 168,
                'description' => 'Maximum token expiry time in hours (7 days)'
            ],
            'min_expiry_hours' => [
                'value' => 1,
                'description' => 'Minimum token expiry time in hours'
            ],
            'allow_unlimited' => [
                'value' => false,
                'description' => 'Allow unlimited downloads (not recommended for production)'
            ],
            'cleanup_expired_after_days' => [
                'value' => 30,
                'description' => 'Auto-cleanup expired tokens after this many days'
            ],
            'send_download_email' => [
                'value' => true,
                'description' => 'Send email notifications for downloads'
            ],
            'send_expiry_warning' => [
                'value' => true,
                'description' => 'Send expiry warning emails'
            ],
            'warning_hours_before_expiry' => [
                'value' => 2,
                'description' => 'Hours before expiry to send warning'
            ],
            'enable_ip_restriction' => [
                'value' => false,
                'description' => 'Enable IP address restrictions'
            ],
            'enable_user_agent_check' => [
                'value' => false,
                'description' => 'Enable user agent validation'
            ],
        ];

        foreach ($defaultSettings as $key => $data) {
            DownloadSetting::setSetting($key, $data['value'], $data['description']);
        }
    }

    /**
     * Validate specific setting values
     */
    private function validateSpecificSetting($key, $value)
    {
        switch ($key) {
            case 'default_max_downloads':
            case 'max_downloads':
            case 'min_downloads':
                if (!is_numeric($value) || $value < 1 || $value > 100) {
                    throw new \InvalidArgumentException("$key must be between 1 and 100");
                }
                break;

            case 'default_expiry_hours':
            case 'max_expiry_hours':
            case 'min_expiry_hours':
                if (!is_numeric($value) || $value < 1 || $value > 8760) { // Max 1 year
                    throw new \InvalidArgumentException("$key must be between 1 and 8760 hours");
                }
                break;

            case 'cleanup_expired_after_days':
                if (!is_numeric($value) || $value < 1 || $value > 365) {
                    throw new \InvalidArgumentException("$key must be between 1 and 365 days");
                }
                break;

            case 'warning_hours_before_expiry':
                if (!is_numeric($value) || $value < 1 || $value > 72) {
                    throw new \InvalidArgumentException("$key must be between 1 and 72 hours");
                }
                break;
        }
    }

    /**
     * Get setting description
     */
    private function getSettingDescription($key)
    {
        $descriptions = [
            'default_max_downloads' => 'Default number of downloads per token',
            'max_downloads' => 'Maximum allowed downloads per token',
            'min_downloads' => 'Minimum allowed downloads per token',
            'default_expiry_hours' => 'Default token expiry time in hours',
            'max_expiry_hours' => 'Maximum token expiry time in hours',
            'min_expiry_hours' => 'Minimum token expiry time in hours',
            'allow_unlimited' => 'Allow unlimited downloads',
            'cleanup_expired_after_days' => 'Auto-cleanup expired tokens after days',
            'send_download_email' => 'Send email notifications for downloads',
            'send_expiry_warning' => 'Send expiry warning emails',
            'warning_hours_before_expiry' => 'Hours before expiry to send warning',
            'enable_ip_restriction' => 'Enable IP address restrictions',
            'enable_user_agent_check' => 'Enable user agent validation',
        ];

        return $descriptions[$key] ?? '';
    }
}
