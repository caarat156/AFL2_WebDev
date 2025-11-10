<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse //kirim email verifikasi baru
    {
        if (Auth::user()->hasVerifiedEmail()) { //cek apakah email user sudah terverifikasi
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.product'); //arahkan ke halaman admin.product kalau sudah verifikasi
            } else {
                return redirect()->route('user.home');
            }
        }
        
        Auth::user()->sendEmailVerificationNotification();

        $request->user()->sendEmailVerificationNotification(); //kirim email verifikasi baru

        return back()->with('status', 'verification-link-sent'); //kembali ke halaman sebelumnya dengan pesan status bahwa link verifikasi telah dikirim
    }
}