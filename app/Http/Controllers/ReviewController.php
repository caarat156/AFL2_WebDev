<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua review
        $reviews = Review::latest()->get();
        
        // Kirim ke view review.blade.php
        return view('/user/review', compact('reviews')); 
    }
}
