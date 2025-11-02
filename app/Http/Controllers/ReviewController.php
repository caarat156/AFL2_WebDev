<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua review dari database
        $reviews = Review::latest()->get();
        //beda sama stroe dan product yg all() krn klo all itu ambil semua dan diurutn sesuai id, sedangkan review ini diurutin berdasarkan yg terbaru

        // Kirim ke view review.blade.php
        return view('review', compact('reviews')); 
    }
}
