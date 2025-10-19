<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk halaman product (semua produk)
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    // Method untuk halaman home (produk tertentu)
    public function home()
    {
        // Ambil 4 produk best sellers berdasarkan ID
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get();
        
        // Ambil reviews untuk ditampilkan di home
        $reviews = Review::latest()->take(6)->get();
        
        return view('home', compact('bestSellers', 'reviews'));
    }
}