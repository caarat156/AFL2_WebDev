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
    
        return view('user.product', compact('products'));
    }

    public function userIndex(Request $request)
{
    $query = Product::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('collection_name', 'like', "%{$search}%")
                ->orWhere('product_type', 'like', "%{$search}%");
    }

    $products = $query->paginate(12); // paginate supaya halaman tidak panjang

    return view('user.product', compact('products'));
}



    public function adminIndex()
{
    $products = Product::all();
    return view('admin.adminproduct', compact('products'));
}
    
    // ✏️ Edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.updateproduct', compact('product'));
    }

    // 💾 Update produk
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'collection_name' => 'required|string|max:255',
        'product_type' => 'required|string|max:255',
        'price_2025' => 'nullable|numeric',
        'variants' => 'nullable|string|max:255',
        'net_price' => 'nullable|numeric',
        'notes' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update data dasar
    $product->collection_name = $request->collection_name;
    $product->product_type = $request->product_type;
    $product->price_2025 = $request->price_2025;
    $product->variants = $request->variants;
    $product->net_price = $request->net_price;
    $product->notes = $request->notes;

    // 📸 Update gambar jika admin upload baru
    if ($request->hasFile('image')) {
        // Hapus gambar lama (jika ada)
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Simpan gambar baru
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = 'storage/' . $imagePath;
    }

    $product->save();

    return redirect()->route('admin.products')
    ->with('success', 'Product updated successfully!');

}

    // ❌ Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    //create
    public function create()
{
    return view('admin.createproduct');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'collection_name' => 'required|string|max:255',
        'product_type' => 'required|string|max:255',
        'price_2025' => 'nullable|numeric',
        'variants' => 'nullable|string|max:255',
        'net_price' => 'nullable|numeric',
        'notes' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = 'storage/' . $path;
    }

    Product::create($validated);

    return redirect()->route('admin.products')->with('success', 'Product added successfully!');
}

}


