<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'old_price',
        'new_price',
        'percentage_diff',
        'changed_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope
     */
    public function scopeLowestPriceChanged($query)
    {
        return $query->where('changed_price', true)->orderBy('new_price', 'ASC')->take(1);
    }

    public function scopeLowestPrice($query)
    {
        return $query->orderBy('new_price', 'ASC')->take(1);
    }
}
