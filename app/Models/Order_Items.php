<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'sub_total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
