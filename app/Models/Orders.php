<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'midtrans_order_id',
        'user_id',
        'total_price',
        'order_date' => 'datetime',
        'payment_method',
        'payment_amount',
        'payment_status',
        'payment_date' => 'datetime',
        'status',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Order_Items::class, 'order_id', 'order_id');
    }
}
