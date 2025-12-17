<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasFactory;
    protected $table = 'products'; 

    protected $fillable = [ 
        'collection_name',
        'product_type',
        'variants',
        'price_2024',
        'price_2025',
        'net_price',
        'notes',
        'image',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class); 
    }
}
