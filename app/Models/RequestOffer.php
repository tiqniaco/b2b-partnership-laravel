<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOffer extends Model
{
    use HasFactory;

    public function requestService()
    {
        return $this->belongsTo(RequestService::class);
    }
}
