<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;


// 🏠 Halaman utama (belum login)
Route::get('/', function () {
    return view('homeumum');
})->middleware('guest')->name('homeumum');

// 📦 Semua produk (public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 📄 About
Route::view('/about', 'about')->name('about');

// 🏪 Daftar toko (public)
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');


Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // 🏠 Dashboard User
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');

    // 📦 Produk (same as public index)
    Route::get('/products', [ProductController::class, 'userIndex'])->name('products');

    // 🏪 Store List
    Route::get('/stores', [StoreController::class, 'userIndex'])->name('stores');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 💬 Reviews
    Route::resource('reviews', ReviewController::class);
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // 🏠 Dashboard Admin
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

    // 📦 Product Management
    Route::get('/adminproduct', [ProductController::class, 'adminIndex'])->name('products'); 
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 🏪 Store Management
    Route::get('/stores', [StoreController::class, 'adminIndex'])->name('stores');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');

    // 👤 Admin Profile
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
});
