<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'total_price',
        'order_date',
        'payment_method',
        'payment_amount',
        'payment_status',
        'payment_date',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
