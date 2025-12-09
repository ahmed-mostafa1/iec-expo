<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\Logout;

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admins: login/forgot/reset
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', Login::class)->name('login');

        Route::get('/forgot-password', ForgotPassword::class)
            ->name('password.request');

        Route::get('/reset-password/{token}', ResetPassword::class)
            ->name('password.reset');
    });

    // Authenticated admins
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', Logout::class)->name('logout');

        // You can also protect email verification/confirm-password if you use them
        Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
        Route::get('/confirm-password', ConfirmPassword::class)->name('password.confirm');
    });
});
