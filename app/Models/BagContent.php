<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'image'
    ];

    public function storeProducts()
    {
        return $this->belongsToMany(StoreProduct::class);
    }
}
