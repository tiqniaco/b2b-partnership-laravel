<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagContentStoreProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'bag_content_id',
        'store_product_id',
    ];

    public function bagContent()
    {
        return $this->belongsTo(BagContent::class);
    }

    public function storeProduct()
    {
        return $this->belongsTo(StoreProduct::class);
    }
}
