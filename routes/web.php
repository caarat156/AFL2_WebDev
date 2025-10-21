<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/product', [ProductController::class, 'index'])->name('product.index');


Route::get('/store', [StoreController::class, 'index'])->name('store.index');


Route::get('/about', function () {
    return view('about');
})->name('about');


// Route::get('/review', [ReviewController::class, 'index'])->name('review.index');