<?php

namespace App\Http\Controllers;

use  App\Models\Review;
use App\Models\Product;
use App\Http\Controllers\ReviewController;

class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get();

        // Ambil review lewat ReviewController (bisa juga langsung query)
        $reviews = Review::latest()->paginate(6);

        return view('home', compact('bestSellers', 'reviews'));
        // compact itu buat ngirim data ke view, misal 'bestSellers' nanti di view bisa dipanggil pake $bestSellers
    }
}
