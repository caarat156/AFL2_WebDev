<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua review dari database
        $reviews = Review::latest()->get();

        // Kirim ke view review.blade.php
        return view('review', compact('reviews')); // ✅ pakai plural, bukan 'review'
    }
}
