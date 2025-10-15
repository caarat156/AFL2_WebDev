<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/product', function () {
    return view('product');
});

Route::get('/store', function () {
    return view('store');
});

Route::get('/about', function () {
    return view('about');
});