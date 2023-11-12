<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'feed_url'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'eshop_id');
    }
}
