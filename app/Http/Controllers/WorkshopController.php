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
        $workshops = Workshop::all();
        return view('workshop', compact('workshops'));
    }


    // Jika userIndex dipisah seperti StoreController
    public function userIndex()
    {
        $workshops = Workshop::all();
        return view('user.workshop', compact('workshops'));
    }

    // ============================
    // ADMIN AREA
    // ============================
    public function adminIndex()
    {
        $workshops = Workshop::all();
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

    // ✏️ Edit Form
    public function edit(Workshop $workshop)
    {
        return view('admin.updateworkshop', compact('workshop'));
    }

    public function update(Request $request, $id)
    {
        $workshop = Workshop::findOrFail($id);

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

        // Update data
        $workshop->title = $validated['title'];
        $workshop->description = $validated['description'];
        $workshop->price = $validated['price'];
        $workshop->date = $validated['date'];
        $workshop->time = $validated['time'];
        $workshop->location = $validated['location'];
        $workshop->capacity = $validated['capacity'];

        // Update image jika ada file baru
        if ($request->hasFile('image')) {

            // Hapus image lama
            if ($workshop->image && file_exists(public_path($workshop->image))) {
                unlink(public_path($workshop->image));
            }

            $path = $request->file('image')->store('workshops', 'public');
            $workshop->image = 'storage/' . $path;
        }

        $workshop->save();

        return redirect()->route('admin.workshops')
            ->with('success', 'Workshop updated successfully!');
    }

    public function destroy(Workshop $workshop)
    {
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
