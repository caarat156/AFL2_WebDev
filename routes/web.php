<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return view('home');
});

// ubah ini:
Route::get('/product', [ProductController::class, 'index']); // ✅ pakai controller

Route::get('/store', [StoreController::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

