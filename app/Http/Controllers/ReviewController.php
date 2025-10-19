<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function home()
    {
        $reviews = Review::latest()->take(6)->get();
        return view('home', compact('reviews'));
    }
}
