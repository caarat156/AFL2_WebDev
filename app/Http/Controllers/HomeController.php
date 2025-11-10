<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // 🔹 Halaman utama untuk guest (belum login)
    public function index()
    {
        return view('homeumum');
    }

    // 🔹 Halaman home untuk user biasa
    public function userHome()
    {
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get(); // Ambil produk best sellers berdasarkan ID
        $reviews = Review::latest()->paginate(6); // Ambil review terbaru dengan pagination cm 6

        return view('user.home', compact('bestSellers', 'reviews')); // Kirim data best sellers dan reviews ke view
    }

    // 🔹 Halaman home untuk admin
    public function adminHome()
    {
        // Kalau admin butuh data tambahan (misalnya statistik, dsb)
        return view('admin.home', [
            'user' => Auth::user()
        ]);
    }
}
