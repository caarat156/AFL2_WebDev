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

// 🔹 Login & Logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::resource('products', ProductController::class);