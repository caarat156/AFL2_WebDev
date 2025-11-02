<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;

// 🏠 Home page — kirim reviews ke view
Route::get('/', [HomeController::class, 'home'])->name('home');

// 🕯️ Product page
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

// 🏬 Store page
Route::get('/store', [StoreController::class, 'index'])->name('store.index');


Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/review', [ReviewController::class, 'index'])->name('review.index');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
