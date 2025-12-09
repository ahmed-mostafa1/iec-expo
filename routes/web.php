<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\LandingPageController;
use App\Http\Controllers\Public\SponsorRegistrationController;
use App\Http\Controllers\Public\VisitorRegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SponsorRegistrationController as AdminSponsorController;
use App\Http\Controllers\Admin\VisitorRegistrationController as AdminVisitorController;
use Illuminate\Support\Facades\Route;



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
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Other admin routes
        Route::get('/sponsor-registrations', [AdminSponsorController::class, 'index'])
            ->name('sponsors.index');

        Route::get('/sponsor-registrations/export', [AdminSponsorController::class, 'export'])
            ->name('sponsors.export');

        Route::get('/sponsor-registrations/{registration}', [AdminSponsorController::class, 'show'])
            ->name('sponsors.show');

        Route::post('/sponsor-registrations/{registration}/status', [AdminSponsorController::class, 'updateStatus'])
            ->name('sponsors.update-status');

        Route::get('/sponsor-registrations/{registration}/pdf', [AdminSponsorController::class, 'downloadPdf'])
            ->name('sponsors.download-pdf');

        Route::post('/sponsor-registrations/{registration}/pdf/regenerate', [AdminSponsorController::class, 'regeneratePdf'])
            ->name('sponsors.regenerate-pdf');

        // Visitor registrations

        Route::get('/visitor-registrations', [AdminVisitorController::class, 'index'])
            ->name('visitors.index');

        Route::get('/visitor-registrations/export', [AdminVisitorController::class, 'export'])
            ->name('visitors.export');

        Route::get('/visitor-registrations/{registration}', [AdminVisitorController::class, 'show'])
            ->name('visitors.show');

        Route::get('/visitor-registrations/{registration}/pdf', [AdminVisitorController::class, 'downloadPdf'])
            ->name('visitors.download-pdf');

        Route::post('/visitor-registrations/{registration}/pdf/regenerate', [AdminVisitorController::class, 'regeneratePdf'])
            ->name('visitors.regenerate-pdf');
    });



// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');








require __DIR__ . '/auth.php';
