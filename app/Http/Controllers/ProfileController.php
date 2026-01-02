<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Orders;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 🔥 AMBIL RIWAYAT PEMBELIAN USER
        $orders = Orders::with('items.product')
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->latest()
            ->get();

        return view('user.profile', [
            'user' => $user,
            'orders' => $orders, // 👈 kirim ke blade
        ]);
    }

    /**
     * Update the user's profile information
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('user.profile')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function adminProfile()
    {
        return view('admin.profileAdmin', [
            'user' => Auth::user()
        ]);
    }
}
