<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\VisitorRegistrationController;
use App\Http\Controllers\SponsorRegistrationController;
use App\Http\Controllers\ContactController;



Route::get('/', function () {
    return redirect('/en');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// localized routes
Route::prefix('{locale}')
    ->whereIn('locale', ['en', 'ar'])
    ->middleware('setlocale')
    ->group(function () {
        // Landing page (we will create the controller later)
        Route::get('/', [LandingPageController::class, 'index'])
            ->name('public.landing');

        Route::post('/register/visitor', [VisitorRegistrationController::class, 'store'])
            ->name('public.register.visitor');

        Route::post('/register/sponsor', [SponsorRegistrationController::class, 'store'])
            ->name('public.register.sponsor');

        Route::post('/contact', [ContactController::class, 'submit'])
            ->name('public.contact');
    });

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // hook Breeze Livewire auth views into here

        Route::middleware('auth:admin')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])
                ->name('dashboard');

            // later: admin resource routes for registrations & content
        });
    });




Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');








require __DIR__.'/auth.php';
