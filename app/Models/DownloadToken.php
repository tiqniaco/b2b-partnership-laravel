<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DownloadToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'token',
        'max_downloads',
        'downloads_count',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(StoreProduct::class, 'product_id');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isLimitReached()
    {
        return $this->downloads_count >= $this->max_downloads;
    }

    public function canDownload()
    {
        return !$this->isExpired() && !$this->isLimitReached();
    }

    public function incrementDownload()
    {
        $this->increment('downloads_count');
    }

    public static function generateToken()
    {
        return Str::random(64);
    }
}
