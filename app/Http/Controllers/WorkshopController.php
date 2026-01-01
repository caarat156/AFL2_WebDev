<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use App\Models\Guest;
use App\Models\GuestWorkshopRegistration;
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

    public function show(Workshop $workshop)
    {
    return view('workshopdetail', compact('workshop'));
    }

    public function storeGuestRegistration(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'participant_count' => 'required|integer|min:1',
        ]);

        // 1️⃣ Ambil / buat guest
        $guest = Guest::firstOrCreate(
            ['guest_email' => $validated['email']],
            ['guest_phone' => $validated['phone'] ?? null]
        );

        // 2️⃣ Cegah daftar dobel
        $alreadyRegistered = GuestWorkshopRegistration::where('guest_id', $guest->guest_id)
            ->where('workshop_id', $workshop->id)
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Email ini sudah terdaftar untuk workshop ini.');
        }

        // 3️⃣ Simpan registrasi guest
        GuestWorkshopRegistration::create([
            'guest_id' => $guest->guest_id,
            'workshop_id' => $workshop->id,
            'registration_date' => now()->toDateString(),
            'payment_status' => 'pending',
        ]);

        return redirect()
            ->route('workshops.show', $workshop)
            ->with('success', 'Pendaftaran berhasil! Silakan lanjutkan pembayaran.');
    }

    // ============================
    // USER AREA
    // ============================
    public function registerForm(Workshop $workshop)
    {
        return view('workshopregist', compact('workshop'));
    }

    public function storeRegistration(Workshop $workshop, Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'participant_count' => 'required|integer|min:1',
        ]);

        // Cek apakah user sudah terdaftar untuk workshop ini
        $existingRegistration = WorkshopRegistration::where('workshop_id', $workshop->id)
            ->where('email', $validated['email'])
            ->first();

        if ($existingRegistration) {
            return redirect()->back()
                ->with('error', 'Email ini sudah terdaftar untuk workshop ini!');
        }

        // Add workshop_id, user_id, and timestamps AFTER validation
        $validated['workshop_id'] = $workshop->id;
        $validated['user_id'] = auth()->id();
        $validated['registration_date'] = now()->toDateString();
        $validated['payment_status'] = 'pending';

        // Simpan registrasi menggunakan Model
        WorkshopRegistration::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Registrasi berhasil!');
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

    public function showParticipants(Workshop $workshop) 
    {
        $participants = $workshop->registrations()->get();
    
        return view('admin.workshopparticipant', compact('workshop', 'participants'));
    }
}