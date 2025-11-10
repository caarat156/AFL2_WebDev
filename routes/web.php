<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| 🌐 Public Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman utama (untuk pengunjung belum login)
Route::get('/', function () {
    return view('homeumum');
})->middleware('guest')->name('homeumum');

// 📦 Daftar produk (bisa diakses siapa pun)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 📄 About page
Route::view('/about', 'about')->name('about');

// 🧾 Daftar toko offline (public)
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');


/*
|--------------------------------------------------------------------------
| 🔐 Authentication Routes
|--------------------------------------------------------------------------
*/
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


/*
|--------------------------------------------------------------------------
| 👤 USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard User
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');
    Route::get('/product', [ProductController::class, 'userIndex'])->name('product');

    // User stores → URL: /user/stores
    Route::get('/stores', [StoreController::class, 'userIndex'])->name('store');


    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Review (pakai resource, otomatis generate: index, create, store, edit, update, destroy)
    Route::resource('reviews', ReviewController::class);

});


/*
|--------------------------------------------------------------------------
| 🛠️ ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

    // Admin Product Management
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('product');
    Route::get('/createproduct', [ProductController::class, 'create'])->name('createproduct');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Admin Store Management
    Route::get('/stores', [StoreController::class, 'adminIndex'])->name('store');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('createstore');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');

    // Admin Profile
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
});
