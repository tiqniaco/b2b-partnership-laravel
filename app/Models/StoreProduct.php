<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'file',
        'price',
        'discount',
        'image',
        'category_id'
    ];

    public function bagContents()
    {
        return $this->belongsToMany(BagContentStoreProduct::class);
    }
}
