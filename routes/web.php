<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;

// 🏠 Home page — kirim reviews ke view
Route::get('/', [ProductController::class, 'home'])->name('home');

// 🕯️ Product page
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

// 🏬 Store page
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

// ℹ️ About page
Route::get('/about', function () {
    return view('about');
})->name('about');
