<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'skills',
        'experience',
        'contract_type',
        'expiry_date',
        'salary',
        'employer_id',
        'government_id',
        'sub_specializations_id',
    ];

    public function employer()
    {
        return $this->belongsTo(Provider::class, 'employer_id');
    }

    public function government()
    {
        return $this->belongsTo(Government::class, 'government_id');
    }

    public function sub_specialization()
    {
        return $this->belongsTo(SubSpecialization::class, 'sub_specializations_id');
    }
}