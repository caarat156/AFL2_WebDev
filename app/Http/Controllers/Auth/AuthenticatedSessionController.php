<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; //ambil data yang dikirim user
use Illuminate\Support\Facades\Auth; //untuk autentikasi
use Illuminate\View\View; //untuk menampilkan view halaman login

class AuthenticatedSessionController extends Controller //mengelola sesi login/logout dan extend ini artinya mewarisi fungsionalitas dasar dari Controller Laravel
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View //panggil file auth/login.blade.php
    {
        return view('auth.login'); //menampilkan halaman login
    }

    /**
     * Proses login.
     */
    public function store(Request $request) //mengelola data yang dikirim user saat login
    {
        $credentials = $request->validate([ //cek input user
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials,  //coba login dengan data yang sudah dicek
        $request->boolean('remember'))) { //klo user klik remember me laravel akan simpan session lebih lama
            $request->session()->regenerate(); //menghindari session fixation attack dengan ganti session id
        
            // 🚀 arahkan sesuai role
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/adminproduct'); //klo ini admin lgsg diarahkan ke adminproduct
            } else {
                return redirect('/user/home'); //klo bukan admin diarahkan ke home user
            }
        }

        return back()->withErrors([ // kalau login gagal balik ke halaman login dengan pesan error
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Logout.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); //logout user dari guard web

        $request->session()->invalidate(); //hapus data session lama
        $request->session()->regenerateToken(); //menghindari CSRF attack dengan ganti token CSRF

        return redirect('/'); //arahkan ke halaman utama setelah logout
    }
}
