<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescriptionContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'content_en',
        'content_ar',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StoreProduct::class);
    }

    public function title(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductDescriptionTitle::class);
    }

    public function scopeTitle($query, $title)
    {
        return $query->whereHas('title', function ($query) use ($title) {
            $query->where('title', $title);
        });
    }
}
