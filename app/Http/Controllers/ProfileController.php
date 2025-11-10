<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View //nampilin halaman edit profile
    {
        return view('user.profile', [
            'user' => $request->user(), //ngirim data user yang sedang login ke view
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse //ngupdate profile user
    {
        $request->user()->fill($request->validated()); //isi data user dengan data yang sudah tervalidasi dari form

        if ($request->user()->isDirty('email')) { //cek apakah email user diubah
            $request->user()->email_verified_at = null; //kalo diubah, set email_verified_at jadi null supaya user harus verifikasi email lagi
        }

        $request->user()->save(); // simpan ke db

        return Redirect::route('user.profile')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], //validasi password user sebelum hapus akun
        ]);

        $user = $request->user();

        Auth::logout(); //logout user

        $user->delete(); //hapus user dari db

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
