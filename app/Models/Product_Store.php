<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Store extends Model
{
    protected $table = 'product_store';
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'store_id',
        'stock_quantity',
    ];
}
