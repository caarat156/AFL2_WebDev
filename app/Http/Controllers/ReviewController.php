<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua review dari database
        //Review terhubung sama tabel review, trs latest() urutin berdasarkan klom created_at dari yg terbaru. get() ambil semua hasil sebagai collection
        $reviews = Review::latest()->get();
        //beda sama stroe dan product yg all() krn klo all itu ambil semua dan diurutn sesuai id, sedangkan review ini diurutin berdasarkan yg terbaru

        // Kirim ke view review.blade.php
        return view('review', compact('reviews')); // ✅ pakai plural, bukan 'review'
    }
}
