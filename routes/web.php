<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\LandingPageController;
use App\Http\Controllers\Public\SponsorRegistrationController;
use App\Http\Controllers\Public\IconRegistrationController;
use App\Http\Controllers\Public\SponsorShowController as PublicSponsorShowController;
use App\Http\Controllers\Public\VisitorRegistrationController;
use App\Http\Controllers\Public\ParticipantShowController as PublicParticipantShowController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingSectionController;
use App\Http\Controllers\Admin\PublicSponsorController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\AboutContentController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\HeroMediaController;
use App\Http\Controllers\Admin\SponsorRegistrationController as AdminSponsorController;
use App\Http\Controllers\Admin\IconRegistrationController as AdminIconController;
use App\Http\Controllers\Admin\VisitorRegistrationController as AdminVisitorController;
use App\Http\Controllers\Admin\HallSpaceBookingController;
use App\Models\SponsorRegistration;
use App\Models\IconRegistration;
use App\Models\HallSpaceBooking;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/en');
});

 Route::get('/hall-design', function () {
            $occupiedSpaces = SponsorRegistration::whereNotNull('location_selection')
                ->pluck('location_selection')
                ->merge(
                    IconRegistration::whereNotNull('location_selection')->pluck('location_selection')
                )
                ->merge(
                    HallSpaceBooking::pluck('space')
                )
                ->filter()
                ->map(fn ($space) => strtoupper($space))
                ->unique()
                ->values()
                ->all();

            return view('public.hall-design', compact('occupiedSpaces'));
        });


Route::redirect('/login', '/admin/login')->name('login');

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

        Route::post('/register/icon', [IconRegistrationController::class, 'store'])
            ->name('public.register.icon');

        Route::post('/contact', [ContactController::class, 'submit'])
            ->name('public.contact');

        Route::get('/sponsors/{sponsor}', PublicSponsorShowController::class)
            ->name('public.sponsors.show');

        Route::get('/participants/{participant}', PublicParticipantShowController::class)
            ->name('public.participants.show');
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

        // Icon registrations
        Route::get('/icon-registrations', [AdminIconController::class, 'index'])
            ->name('icons.index');

        Route::get('/icon-registrations/export', [AdminIconController::class, 'export'])
            ->name('icons.export');

        Route::get('/icon-registrations/{registration}', [AdminIconController::class, 'show'])
            ->name('icons.show');

        Route::post('/icon-registrations/{registration}/status', [AdminIconController::class, 'updateStatus'])
            ->name('icons.update-status');

        Route::get('/icon-registrations/{registration}/pdf', [AdminIconController::class, 'downloadPdf'])
            ->name('icons.download-pdf');

        Route::post('/icon-registrations/{registration}/pdf/regenerate', [AdminIconController::class, 'regeneratePdf'])
            ->name('icons.regenerate-pdf');

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

        // Hall design controls
        Route::get('/hall-spaces', [HallSpaceBookingController::class, 'index'])
            ->name('hall-spaces.index');
        Route::post('/hall-spaces', [HallSpaceBookingController::class, 'store'])
            ->name('hall-spaces.store');
        Route::delete('/hall-spaces/{hallSpaceBooking}', [HallSpaceBookingController::class, 'destroy'])
            ->name('hall-spaces.destroy');

        Route::resource('public-sponsors', PublicSponsorController::class);
        Route::resource('participants', ParticipantController::class);
        Route::resource('organizers', OrganizerController::class);

        Route::match(['get', 'post'], 'sections/hero', [LandingSectionController::class, 'hero'])
            ->name('sections.hero');
        Route::match(['get', 'post'], 'sections/registration', [LandingSectionController::class, 'registration'])
            ->name('sections.registration');
        Route::match(['get', 'post'], 'sections/about', [LandingSectionController::class, 'about'])
            ->name('sections.about');
        Route::match(['get', 'post'], 'sections/contact', [LandingSectionController::class, 'contact'])
            ->name('sections.contact');

        // About content – treat as single resource
        Route::get('about-content', [AboutContentController::class, 'edit'])->name('about.edit');
        Route::put('about-content', [AboutContentController::class, 'update'])->name('about.update');

        // Contact infos
        Route::resource('contact-infos', ContactInfoController::class)->except(['show']);

        // Hero media
        Route::resource('hero-media', HeroMediaController::class)->except(['show']);
    });



// ...


// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');








require __DIR__ . '/auth.php';
