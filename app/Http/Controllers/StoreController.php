<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // 🏪 Halaman user (semua store)
    public function index()
    {
        $stores = Store::all();
        return view('user.store', compact('stores'));
    }

    public function userIndex()
{
    $stores = Store::all(); // Ambil semua store, bisa ditambah filter nanti
    return view('user.store', compact('stores'));
}
    // 📋 Halaman admin list store
    public function adminIndex()
    {
        $stores = Store::all();
        return view('admin.adminstore', compact('stores'));
    }

    // ➕ Form create store (admin)
    public function create()
    {
        return view('admin.createstore');
    }

    // 💾 Store data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan gambar jika diupload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stores', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Store::create($validated);

        return redirect()->route('admin.stores')
            ->with('success', 'Store added successfully!');
    }

    // ✏️ Form edit store
    public function edit(Store $store)
    {;
        return view('admin.updatestore', compact('store'));
    }

    // 💾 Update store
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $store->name = $request->name;
        $store->location = $request->location;

        // Update gambar jika upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($store->image && file_exists(public_path($store->image))) {
                unlink(public_path($store->image));
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('stores', 'public');
            $store->image = 'storage/' . $imagePath;
        }

        $store->save();

        return redirect()->route('admin.stores')
            ->with('success', 'Store updated successfully!');
    }

    // ❌ Hapus store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($store->image && file_exists(public_path($store->image))) {
            unlink(public_path($store->image));
        }

        $store->delete();

        return redirect()->route('admin.stores')
            ->with('success', 'Store deleted successfully!');
    }
}
