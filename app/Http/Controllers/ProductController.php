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
    
        return view('/user/product', compact('products'));
    }

    public function adminIndex()
    {
    return view('admin.adminproduct');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'collection_name' => 'required',
            'product_type' => 'required',
            'image' => 'image|max:2048'
        ]);

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create data
        Product::create([
            'collection_name' => $request->collection_name,
            'product_type' => $request->product_type,
            'variants' => $request->variants,
            'price_2024' => $request->price_2024,
            'price_2025' => $request->price_2025,
            'net_price' => $request->net_price,
            'notes' => $request->notes,
            'image' => $imagePath
        ]);

        return back()->with('success', 'Product created!');
    }
    

}
