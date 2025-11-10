<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse //ngubah password
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], //validasi password lama
            'password' => ['required', Password::defaults(), 'confirmed'], //validasi password baru
        ]);

        $request->user()->update([ //ngupdate password user
            'password' => Hash::make($validated['password']), //hash password baru supaya ga kesimpen jadi text biasa
        ]);

        return back()->with('status', 'password-updated'); //setelah pw diupdate, balik ke halaman sebelumnya dengan pesan sukses
    }
}
