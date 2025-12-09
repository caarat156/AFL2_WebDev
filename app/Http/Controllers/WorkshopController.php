<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    // ============================
    // PUBLIC (Guest & User)
    // ============================
    public function index()
    {
        $workshops = Workshop::latest()->get(); // ← Tambah latest()
        return view('workshop', compact('workshops'));
    }

    // Jika userIndex dipisah seperti StoreController
    public function userIndex()
    {
        $workshops = Workshop::latest()->get(); // ← Tambah latest()
        return view('user.workshop', compact('workshops'));
    }

    // ============================
    // ADMIN AREA
    // ============================
    public function adminIndex()
    {
        $workshops = Workshop::latest()->get(); // ← Tambah latest()
        return view('admin.adminworkshop', compact('workshops'));
    }

    public function create()
    {
        return view('admin.createworkshop');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'date'        => 'required|date',
            'time'        => 'required',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('workshops', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Workshop::create($validated);

        return redirect()->route('admin.workshops')
            ->with('success', 'Workshop added successfully!');
    }

    // ✏️ Edit Form dengan Route Model Binding
    public function edit(Workshop $workshop) // ✅ Sudah benar
    {
        return view('admin.updateworkshop', compact('workshop'));
    }

    public function update(Request $request, Workshop $workshop) // ← Ubah dari $id ke Workshop $workshop
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'date'        => 'required|date',
            'time'        => 'required',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data (cara lebih efisien dengan update())
        $workshop->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'date'        => $validated['date'],
            'time'        => $validated['time'],
            'location'    => $validated['location'],
            'capacity'    => $validated['capacity'],
        ]);

        // Update image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($workshop->image && file_exists(public_path($workshop->image))) {
                unlink(public_path($workshop->image));
            }

            $path = $request->file('image')->store('workshops', 'public');
            $workshop->update(['image' => 'storage/' . $path]);
        }

        return redirect()->route('admin.workshops')
            ->with('success', 'Workshop updated successfully!');
    }

    public function destroy(Workshop $workshop) // ✅ Sudah benar
    {
        // Hapus semua registrasi terkait
        $workshop->registrations()->delete();
        $workshop->guestRegistrations()->delete();
        
        // Hapus image jika ada
        if ($workshop->image && file_exists(public_path($workshop->image))) {
            unlink(public_path($workshop->image));
        }

        $workshop->delete();

        return redirect()->route('admin.workshops')
            ->with('success', 'Workshop deleted successfully!');
    }
}