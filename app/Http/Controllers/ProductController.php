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

}