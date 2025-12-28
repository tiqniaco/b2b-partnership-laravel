<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthsPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'duration_months',
    ];
}
