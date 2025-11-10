<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View //nampilin halaman reset password
    {
        return view('auth.reset-password', ['request' => $request]); //kirim data request ke view reset-password supaya pakai data dari link reset
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse //proses reset password baru dan setelah selesai akan di arahkan ke halaman lain
    {
        $request->validate([ //validasi data yang dikirim user
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], //harus ada, cocok dengan password_confirmation, dan sesuai aturan password default laravel
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset( //coba reset password
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) { //jika berhasil, jalankan closure ini dengan user yang direset passwordnya
                $user->forceFill([ //paksa isi field password 
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user)); //beri tahu sistem bahwa password user sudah direset
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET //ngatur redirect ke halaman login setelah reset pw
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
