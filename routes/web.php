<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// 🌐 Halaman utama (public)
Route::get('/', function () {
    return view('homeumum'); // tampilkan homeumum.blade.php
})->middleware('guest')->name('homeumum');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');


// 🧍 Register (buat akun baru)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// 🚪 Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// 📄 About Page (bebas diakses)
Route::view('/about', 'about')->name('about');


// =============================
// 👤 USER AREA
// =============================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // review route
    Route::resource('reviews', ReviewController::class);
});






// =============================
// 🛠️ ADMIN AREA
// =============================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::get('/admin/adminproduct', [ProductController::class, 'adminIndex'])->name('admin.product');
    Route::get('/admin/adminstore', [StoreController::class, 'adminIndex'])->name('admin.store');
    Route::get('/admin/profileAdmin', [ProfileController::class, 'adminProfile'])->name('admin.profile');
    Route::resource('products', ProductController::class);
    Route::post('/admin/adminproducts', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/createproduct', [ProductController::class, 'create'])->name('admin.createproduct');
});

Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');

// ADMIN routes
Route::get('/admin/stores', [StoreController::class, 'adminIndex'])->name('admin.store');
Route::get('/admin/stores/create', [StoreController::class, 'create'])->name('admin.createstore');
Route::post('/admin/stores', [StoreController::class, 'store'])->name('stores.store');
Route::get('/admin/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::put('/admin/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
Route::delete('/admin/stores/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');