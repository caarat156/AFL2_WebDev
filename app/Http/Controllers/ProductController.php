<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk halaman product (semua produk + fitur search)
    public function index(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('collection_name', 'LIKE', "%{$search}%")
                ->orWhere('product_type', 'LIKE', "%{$search}%");
            });
        }
    
        $products = $query->paginate(12);
    
        return view('product', compact('products'));
    }
    

}
