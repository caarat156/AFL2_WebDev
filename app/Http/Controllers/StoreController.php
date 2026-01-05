<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->get(); // ← Tambah latest()
        return view('user.store', compact('stores'));
    }

    public function userIndex()
    {
        $stores = Store::latest()->get(); // ← Tambah latest()
        return view('user.store', compact('stores'));
    }

    public function adminIndex()
    {
        $stores = Store::latest()->get(); // ← Tambah latest()
        return view('admin.adminstore', compact('stores'));
    }

    public function create()
    {
        return view('admin.createstore');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'linkgmap' => 'string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stores', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Store::create($validated);

        return redirect()->route('admin.stores')
            ->with('success', 'Store added successfully!');
    }

    // ✏️ Form edit store dengan Route Model Binding
    public function edit(Store $store) // ✅ Sudah benar
    {
        return view('admin.updatestore', compact('store'));
    }

    public function update(Request $request, Store $store) // ← Ubah dari $id ke Store $store
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'linkgmap' => 'string|max:255',
        ]);

        $store->name = $request->name;
        $store->location = $request->location;
        $store->linkgmap = $request->linkgmap;


        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($store->image && file_exists(public_path($store->image))) {
                unlink(public_path($store->image));
            }

            $imagePath = $request->file('image')->store('stores', 'public');
            $store->image = 'storage/' . $imagePath;
        }

        $store->save();

        return redirect()->route('admin.stores')
            ->with('success', 'Store updated successfully!');
    }

    public function destroy(Store $store) // ✅ Sudah benar
    {
        // Hapus gambar jika ada
        if ($store->image && file_exists(public_path($store->image))) {
            unlink(public_path($store->image));
        }

        $store->delete();

        return redirect()->route('admin.stores')
            ->with('success', 'Store deleted successfully!');
    }
}