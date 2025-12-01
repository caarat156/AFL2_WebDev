<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View //menampilkan halaman register
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([ //validasi input register
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Buat user baru (default role = 'user')
    $user = User::create([ //bikin user baru di database
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), //hash password supaya aman
        'role' => 'user', //set default role jadi 'user'
    ]);

    event(new Registered($user)); //memicu event Registered setelah user terdaftar

    // 🚫 jangan auto login
    // Auth::login($user);

    // Arahkan ke halaman login setelah register
    return redirect()->route('login')->with('success', 'Registration successful! Please login.'); 
    //setelah register, arahkan ke halaman login 
}

}