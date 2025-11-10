<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    //invoke adalah method php yang otomatis dipanggil ketika sebuah objek dari kelas tersebut diperlakukan sebagai fungsi
    public function __invoke(Request $request): RedirectResponse|View //menampilkan prompt verifikasi email
    {                       //untuk tangkap request (misal data user yang sedang login)
        //ambil user yg lagi login dari request, terus cek apakah emailnya sudah terverifikasi
        return $request->user()->hasVerifiedEmail()

                    //klo sudah terverifikasi, arahkan ke halaman y gingin dituju
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}
