<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasFactory;

    protected $fillable = [ // semua hrs diisi sesuai apa aja yg ada di migrations
        'collection_name',
        'name',
        'product_type',
        'price_2024',
        'price_2025',
        'net_price',
        'notes',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class); // satu produk bisa punya banyak review, laravel otomatis cari dari tabel review yg ada product_idnya
    }
}
