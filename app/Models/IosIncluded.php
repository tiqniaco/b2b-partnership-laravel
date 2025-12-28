<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IosIncluded extends Model
{
    use HasFactory;

    public function ios()
    {
        return $this->belongsTo(Ios::class, 'ios_id');
    }

}