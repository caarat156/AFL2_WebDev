<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View //nampilin halaman minta reset password
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([ //validasi email hrs dlm format email yg valid
            'email' => ['required', 'email'],
        ]);

        
        $status = Password::sendResetLink(
            $request->only('email') //kirim email reset pw ke user yg punya email tsb
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
                        //Jika email berhasil dikirim → redirect kembali ke form dengan status sukses (with('status', ...)) supaya bisa ditampilkan pesan “link reset terkirim”.
                        //Jika gagal (misal email tidak terdaftar) → redirect kembali dengan error message.
                        //withInput() → supaya user tidak perlu mengetik ulang email yang sudah dimasukkan.
    }
}
