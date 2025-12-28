<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackages extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Automatically create transaction_id when creating a new record
     */
    protected static function booted()
    {
        static::creating(function ($userPackage) {
            if (empty($userPackage->transaction_id)) {
                $userPackage->transaction_id = 'TXN-' . strtoupper(uniqid());
            }
        });
    }
}
