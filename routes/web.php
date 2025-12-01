<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;


Route::get('/', function () {
    return view('homeumum');
})->middleware('guest')->name('homeumum');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::view('/about', 'about')->name('about');

Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');

/*
|--------------------------------------------------------------------------
| 👤 USER AREA
|--------------------------------------------------------------------------
*/
// Semua URL diawali /user.
// Nama route diawali user.

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () { //hanya bisa diakses oleh yg udah login
    // 🏠 Dashboard User
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');

    // 📦 Produk (same as public index) daftar produk versi user (bisa ada fitur khusus user).
    Route::get('/products', [ProductController::class, 'userIndex'])->name('products');

    Route::get('/stores', [StoreController::class, 'userIndex'])->name('stores');

    // 👤 Profile Edit profile user, update, dan hapus akun.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 💬 Reviews Membuat CRUD review otomatis (index, create, store, edit, update, destroy, show).
    Route::resource('reviews', ReviewController::class);
});

/*
|--------------------------------------------------------------------------
| 🛠️ ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () { //hanya bisa diakses oleh yg udah login dan itu admin
    // 🏠 Dashboard Admin
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

    // 📦 Product Management CRUD produk untuk admin: lihat, tambah, edit, update, hapus.
    Route::get('/adminproduct', [ProductController::class, 'adminIndex'])->name('products'); 
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 🏪 Store Management CRUD
    // /stores itu url yg diakses, admin index itu method di controller, name stores itu nama route untuk dipake di view blade
    Route::get('/stores', [StoreController::class, 'adminIndex'])->name('stores');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');

    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
});


//get untuk nampilin sesuatu
//post untuk ngirim / menyimpan data ke server
//put untuk update data yang sudah ada
//delete untuk hapus data
//patch untuk update sebagian data 
//resource untuk bikin route CRUD sekaligus untuk satu controller
//middleware untuk proteksi route berdasarkan kondisi tertentu (misal harus login dulu/ siapa yg bisa akses route)