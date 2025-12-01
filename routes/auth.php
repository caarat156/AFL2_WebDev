<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () { //semua route hanya diakses oleh guest(yg blm login)
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register'); //menampilkan form registrasi

    Route::post('register', [RegisteredUserController::class, 'store']);
    //mengirim data registrasi untuk diproses

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); //menampilkan form login

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    //mengirim data login untuk diproses

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
        //form untuk minta llink reset pw

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
        //mengirim email berisi link reset pw

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
        //form untuk reset pw pake token dari email

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
        //mengirim data reset pw untuk diproses
});

Route::middleware('auth')->group(function () { //hanya bisa diakses oleh yg udah login
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
        //halaman notifikasi verifikasi email

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
        //link yg dikirim lewat email untuk verifikasi email

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1') //batasi pengiriman 6 kali per menit
        ->name('verification.send');
        //mengirim ulang email verifikasi

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
        //menampilkan form konfirmasi password

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    //mengirim data konfirmasi password untuk diproses

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    //mengupdate password user yg udh login

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    //logout user dan hapus session
});
