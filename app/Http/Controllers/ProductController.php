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
    
        $products = $query->latest()->paginate(12); // ✅ Sudah benar
    
        return view('user.product', compact('products'));
    }

    public function userIndex(Request $request) // halaman product user
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('collection_name', 'like', "%{$search}%")
                    ->orWhere('product_type', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(12); // ← Tambah latest()

        return view('user.product', compact('products'));
    }

    public function show(Product $product)
    {
        return view('user.productdetail', compact('product'));
    }

    public function adminIndex() // halaman product admin
    {
        $products = Product::latest()->get(); // ← Tambah latest()
        return view('admin.adminproduct', compact('products'));
    }
    
    // ✏️ Edit produk dengan Route Model Binding
    public function edit(Product $product) // ← Ubah dari $id ke Product $product
    {
        return view('admin.updateproduct', compact('product'));
    }

    public function update(Request $request, Product $product) // ← Ubah dari $id ke Product $product
    {
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
            // Hapus gambar lama jika ada
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

    public function viewTransactions()
    {
        $transactions = collect([]); // Sementara kosong
        
        return view('admin.producttransaction', compact('transactions'));
    }

    public function destroy(Product $product)
    {
        // Hapus gambar jika ada
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully!');
    }

    public function create()
    {
        return view('admin.createproduct'); // tampilkan form create product untuk admin
    }

    public function store(Request $request)
    {
        $validated = $request->validate([ // validasi input dari form
            'collection_name' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'price_2025' => 'nullable|numeric', // numeric karena harga
            'variants' => 'nullable|string|max:255',
            'net_price' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Product::create($validated); // simpan ke database

        return redirect()->route('admin.products')
            ->with('success', 'Product added successfully!');
    }
}