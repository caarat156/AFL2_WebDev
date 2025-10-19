<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk halaman product (semua produk)
    public function index()
    {
        $products = Product::all(); // ambil semua data produk
        return view('product', compact('products'));
    }

    // Method untuk halaman home (produk tertentu)
    public function home()
    {
        // Panggil product dengan ID tertentu untuk homepage
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get();
        
        return view('home', compact('bestSellers'));
    }
}