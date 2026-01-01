<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admins: login/forgot/reset
    Route::middleware('guest:admin')->group(function () {
        Volt::route('/login', 'pages.auth.login')->name('login');

        Volt::route('/forgot-password', 'pages.auth.forgot-password')
            ->name('password.request');

        Volt::route('/reset-password/{token}', 'pages.auth.reset-password')
            ->name('password.reset');
    });

    // Authenticated admins
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', function (Logout $logout) {
            $logout();

            $locale = app()->getLocale() ?: config('app.locale');

            return redirect()->route('public.landing', ['locale' => $locale]);
        })->name('logout');

        // You can also protect email verification/confirm-password if you use them
        Volt::route('/verify-email', 'pages.auth.verify-email')->name('verification.notice');
        Volt::route('/confirm-password', 'pages.auth.confirm-password')->name('password.confirm');
    });
});
