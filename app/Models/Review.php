<?php

namespace App\Models;
// laravel secara otomatis akan menganggap model ini mewakili tabel 'reviews' di database

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    use HasFactory; //bawaan laravel agar model bisa generate data dummy lewat factory (reviewfactory)

    public function product()
    {
        return $this->belongsTo(Product::class); //1 review hanya milik 1 product, laravel otomatis cari dari tabel review yg ada product_idnya
    }
}
