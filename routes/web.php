<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;


// 🏬 Store page
Route::get('/store', [StoreController::class, 'index'])->name('store.index'); // ke halaman store

// ℹ️ About page
Route::get('/about', function () {
    return view('about');
})->name('about'); // ke halaman about
// langsung render ke file about (ini route statis dan gak pake controller)

// Route::get('/review', [ReviewController::class, 'index'])->name('review.index'); // ke halaman review

Route::get('/', [HomeController::class, 'index'])->name('home'); // ke halaman home
Route::get('/product', [ProductController::class, 'index'])->name('product.index'); // ke halaman product
