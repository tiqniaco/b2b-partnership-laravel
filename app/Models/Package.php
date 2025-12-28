<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'is_active' => 'boolean',
        'is_trial' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function monthsPlan()
    {
        return $this->belongsTo(MonthsPlan::class, 'months_plan_id');
    }
}
