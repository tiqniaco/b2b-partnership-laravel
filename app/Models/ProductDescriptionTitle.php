<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescriptionTitle extends Model
{
    use HasFactory;

    protected $fillable = ['title_en', 'title_ar', 'product_id'];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StoreProduct::class);
    }

    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductDescriptionContent::class, 'title_id');
    }
}
