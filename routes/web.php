<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// 🔹 Halaman utama (bisa pakai controller yang sama)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔹 Halaman home (setelah login)
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

// 🔐 Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// 🚪 Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// 🧍 Register (daftar akun baru)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::resource('products', ProductController::class);