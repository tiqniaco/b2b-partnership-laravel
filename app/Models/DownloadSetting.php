<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the value cast to the appropriate type
     */
    public function getTypedValueAttribute()
    {
        switch ($this->type) {
            case 'boolean':
                return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $this->value;
            case 'json':
                return json_decode($this->value, true);
            default:
                return $this->value;
        }
    }

    /**
     * Set value with automatic type detection
     */
    public function setTypedValue($value)
    {
        if (is_bool($value)) {
            $this->type = 'boolean';
            $this->value = $value ? '1' : '0';
        } elseif (is_int($value)) {
            $this->type = 'integer';
            $this->value = (string) $value;
        } elseif (is_array($value) || is_object($value)) {
            $this->type = 'json';
            $this->value = json_encode($value);
        } else {
            $this->type = 'string';
            $this->value = (string) $value;
        }
    }

    /**
     * Get setting by key
     */
    public static function getSetting($key, $default = null)
    {
        $setting = self::where('key', $key)->where('is_active', true)->first();
        return $setting ? $setting->typed_value : $default;
    }

    /**
     * Set setting by key
     */
    public static function setSetting($key, $value, $description = null)
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->setTypedValue($value);
        $setting->description = $description;
        $setting->is_active = true;
        $setting->save();
        return $setting;
    }
}
