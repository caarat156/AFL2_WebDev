<?php

namespace App\Http\Controllers;

use  App\Models\Review;
use App\Models\Product;
use App\Http\Controllers\ReviewController;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk best sellers
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get();

        // Ambil review lewat ReviewController (bisa juga langsung query)
        $reviews = Review::latest()->take(6)->get();

        return view('home', compact('bestSellers', 'reviews'));
    }
}
