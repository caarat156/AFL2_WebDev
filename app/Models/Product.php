<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_name',
        'name',
        'product_type',
        'price_2024',
        'price_2025',
        'net_price',
        'notes',
    ];
}
