<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    //pake single action controller, email verification memastikan rew sudah valid dan url belum kadaluarsa
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        //cek apakah email user sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1'); //klo sudah, arahkan ke yg di tuju
        }                                                                    //verified=1 biar bisa nampilin pesan sukses

        //tandai email user sebagai terverifikasi
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); //memicu event Verified
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1'); // kalau user mau ke halaman lain sebelum verifikasi, arahkan ke halaman tsb
    }
}
