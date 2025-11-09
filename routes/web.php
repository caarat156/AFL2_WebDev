<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;   

// Halaman utama (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login & Logout  
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// About Page
Route::view('/about', 'about')->name('about');


Route::middleware(['auth'])->group(function () {

    // Halaman home setelah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile (user profile)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produk — user tetap bisa lihat (index/show)
    Route::resource('/user/product', ProductController::class);

    Route::resource('/user/store', StoreController::class);
});


Route::middleware(['auth'])->group(function () {

    // Admin Product List
    Route::get('/admin/adminproduct', [ProductController::class, 'adminIndex'])
        ->name('admin.product');

    // Admin Store List
    Route::get('/admin/adminstore', [StoreController::class, 'adminIndex'])
        ->name('admin.store');

    // Admin Profile
    Route::get('/admin/profileAdmin', [ProfileController::class, 'adminProfile'])
        ->name('admin.profile');
});
