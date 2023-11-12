<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'eshop_id',
        'name',
        'ean',
        'product_price_id',
    ];

    public function eshop()
    {
        return $this->belongsTo(Eshop::class);
    }

    public function price()
    {
        return $this->belongsTo(ProductPrice::class, 'product_price_id');
    }

}
