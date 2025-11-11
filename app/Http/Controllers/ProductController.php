<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

    $products = $query->paginate(12); 

    return view('user.product', compact('products'));
}



    public function adminIndex()
{
    $products = Product::all();
    return view('admin.adminproduct', compact('products'));
}
    
    public function edit(Product $product)
    {
    
        return view('admin.updateproduct', compact('product'));
    }

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

    $product->collection_name = $request->collection_name;
    $product->product_type = $request->product_type;
    $product->price_2025 = $request->price_2025;
    $product->variants = $request->variants;
    $product->net_price = $request->net_price;
    $product->notes = $request->notes;

    if ($request->hasFile('image')) {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = 'storage/' . $imagePath;
    }

    $product->save();

    return redirect()->route('admin.products')
    ->with('success', 'Product updated successfully!');

}

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

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