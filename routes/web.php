<?php

use App\Http\Controllers\Admin\AboutContentController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HallSpaceBookingController;
use App\Http\Controllers\Admin\HeroMediaController;
use App\Http\Controllers\Admin\IconPlusQuartetRegistrationController as AdminIconPlusQuartetController;
use App\Http\Controllers\Admin\IconPlusRegistrationController as AdminIconPlusController;
use App\Http\Controllers\Admin\IconQuartetRegistrationController as AdminIconQuartetController;
use App\Http\Controllers\Admin\IconRegistrationController as AdminIconController;
use App\Http\Controllers\Admin\LandingSectionController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\PublicSponsorController;
use App\Http\Controllers\Admin\SponsorRegistrationController as AdminSponsorController;
use App\Http\Controllers\Admin\VisitorRegistrationController as AdminVisitorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Portal\AuthController as PortalAuthController;
use App\Http\Controllers\Portal\ScanController;
use App\Http\Controllers\Public\AnalyticsController;
use App\Http\Controllers\Public\BadgeController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\IconPlusQuartetRegistrationController;
use App\Http\Controllers\Public\IconPlusRegistrationController;
use App\Http\Controllers\Public\IconQuartetRegistrationController;
use App\Http\Controllers\Public\IconRegistrationController;
use App\Http\Controllers\Public\LandingPageController;
use App\Http\Controllers\Public\ParticipantShowController as PublicParticipantShowController;
use App\Http\Controllers\Public\SponsorRegistrationController;
use App\Http\Controllers\Public\SponsorShowController as PublicSponsorShowController;
use App\Http\Controllers\Public\VisitorRegistrationController;
use App\Models\PublicSponsor as PublicSponsorModel;
use App\Services\HallSpaceService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/en');
});

Route::get('/analytics', function () {
    return redirect()->route('public.analytics', ['locale' => 'ar'] + request()->query());
});

Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow:\nSitemap: ".url('/sitemap.xml')."\n", 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    $urls = [];
    $addUrl = function (string $url, ?array $alternates = null) use (&$urls): void {
        $urls[] = [
            'loc' => $url,
            'lastmod' => now()->toDateString(),
            'alternates' => $alternates ?? [],
        ];
    };

    foreach (['en', 'ar'] as $locale) {
        $addUrl(route('public.landing', ['locale' => $locale]), [
            'en' => route('public.landing', ['locale' => 'en']),
            'ar' => route('public.landing', ['locale' => 'ar']),
        ]);
        $addUrl(route('public.ed', ['locale' => $locale]), [
            'en' => route('public.ed', ['locale' => 'en']),
            'ar' => route('public.ed', ['locale' => 'ar']),
        ]);
        $addUrl(route('public.analytics', ['locale' => $locale]), [
            'en' => route('public.analytics', ['locale' => 'en']),
            'ar' => route('public.analytics', ['locale' => 'ar']),
        ]);
        $addUrl(url('/hall-design').'?locale='.$locale, [
            'en' => url('/hall-design').'?locale=en',
            'ar' => url('/hall-design').'?locale=ar',
        ]);
    }

    PublicSponsorModel::query()
        ->where('is_active', true)
        ->orderBy('display_order')
        ->get()
        ->each(function (PublicSponsorModel $sponsor) use ($addUrl): void {
            foreach (['en', 'ar'] as $locale) {
                $addUrl(route('public.sponsors.show', ['locale' => $locale, 'sponsor' => $sponsor]), [
                    'en' => route('public.sponsors.show', ['locale' => 'en', 'sponsor' => $sponsor]),
                    'ar' => route('public.sponsors.show', ['locale' => 'ar', 'sponsor' => $sponsor]),
                ]);
            }
        });

    $escape = fn (string $value): string => htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">\n";

    foreach ($urls as $entry) {
        $xml .= "  <url>\n";
        $xml .= '    <loc>'.$escape($entry['loc'])."</loc>\n";
        $xml .= '    <lastmod>'.$escape($entry['lastmod'])."</lastmod>\n";

        foreach ($entry['alternates'] as $locale => $alternateUrl) {
            $xml .= '    <xhtml:link rel="alternate" hreflang="'.$escape($locale).'" href="'.$escape($alternateUrl).'" />'."\n";
        }

        $xml .= "  </url>\n";
    }

    $xml .= "</urlset>\n";

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

Route::view('/contract-form', 'contract-form');
Route::post('/generate-pdf', [DocumentController::class, 'generate'])
    ->name('contract.generate-pdf');

Route::get('/hall-design', function () {
    $target = request()->query('target', 'icon');

    if (! in_array($target, ['icon', 'icon-plus', 'icon-quartet', 'icon-plus-quartet'], true)) {
        $target = 'icon';
    }

    $occupiedSpaces = HallSpaceService::occupiedSpaces();
    $allowedSpaces = HallSpaceService::allowedSpaces($target);
    $iconPlusSpaces = HallSpaceService::allowedSpaces('icon-plus');
    $isQuartet = str_contains($target, 'quartet');

    return view('public.hall-design', compact('occupiedSpaces', 'allowedSpaces', 'iconPlusSpaces', 'isQuartet', 'target'));
});

Route::redirect('/login', '/admin/login')->name('login');

Route::get('/badge/{type}/{registration}', [BadgeController::class, 'show'])
    ->name('public.badge.show')
    ->middleware('signed');

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

        Route::view('/ed', 'public.ed')
            ->name('public.ed');

        Route::get('/analytics', [AnalyticsController::class, 'index'])
            ->middleware('throttle:analytics')
            ->name('public.analytics');

        Route::get('/analytics/export', [AnalyticsController::class, 'export'])
            ->middleware('throttle:analytics-export')
            ->name('public.analytics.export');

        Route::post('/register/visitor', [VisitorRegistrationController::class, 'store'])
            ->name('public.register.visitor');

        Route::post('/register/sponsor', [SponsorRegistrationController::class, 'store'])
            ->name('public.register.sponsor');

        Route::get('/register/sponsor/{registration}/pdf', [SponsorRegistrationController::class, 'download'])
            ->name('public.register.sponsor.pdf')
            ->middleware('signed');

        Route::post('/register/icon', [IconRegistrationController::class, 'store'])
            ->name('public.register.icon');

        Route::get('/register/icon/{registration}/pdf', [IconRegistrationController::class, 'download'])
            ->name('public.register.icon.pdf')
            ->middleware('signed');

        Route::post('/register/icon-plus', [IconPlusRegistrationController::class, 'store'])
            ->name('public.register.icon-plus');

        Route::get('/register/icon-plus/{registration}/pdf', [IconPlusRegistrationController::class, 'download'])
            ->name('public.register.icon-plus.pdf')
            ->middleware('signed');

        Route::post('/register/icon-quartet', [IconQuartetRegistrationController::class, 'store'])
            ->name('public.register.icon-quartet');

        Route::get('/register/icon-quartet/{registration}/pdf', [IconQuartetRegistrationController::class, 'download'])
            ->name('public.register.icon-quartet.pdf')
            ->middleware('signed');

        Route::post('/register/icon-plus-quartet', [IconPlusQuartetRegistrationController::class, 'store'])
            ->name('public.register.icon-plus-quartet');

        Route::get('/register/icon-plus-quartet/{registration}/pdf', [IconPlusQuartetRegistrationController::class, 'download'])
            ->name('public.register.icon-plus-quartet.pdf')
            ->middleware('signed');

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

        // Icon Plus registrations
        Route::get('/icon-plus-registrations', [AdminIconPlusController::class, 'index'])
            ->name('icon-plus.index');

        Route::get('/icon-plus-registrations/export', [AdminIconPlusController::class, 'export'])
            ->name('icon-plus.export');

        Route::get('/icon-plus-registrations/{registration}', [AdminIconPlusController::class, 'show'])
            ->name('icon-plus.show');

        Route::post('/icon-plus-registrations/{registration}/status', [AdminIconPlusController::class, 'updateStatus'])
            ->name('icon-plus.update-status');

        Route::get('/icon-plus-registrations/{registration}/pdf', [AdminIconPlusController::class, 'downloadPdf'])
            ->name('icon-plus.download-pdf');

        Route::post('/icon-plus-registrations/{registration}/pdf/regenerate', [AdminIconPlusController::class, 'regeneratePdf'])
            ->name('icon-plus.regenerate-pdf');

        // Icon Quartet registrations
        Route::get('/icon-quartet-registrations', [AdminIconQuartetController::class, 'index'])
            ->name('icon-quartet.index');

        Route::get('/icon-quartet-registrations/export', [AdminIconQuartetController::class, 'export'])
            ->name('icon-quartet.export');

        Route::get('/icon-quartet-registrations/{registration}', [AdminIconQuartetController::class, 'show'])
            ->name('icon-quartet.show');

        Route::post('/icon-quartet-registrations/{registration}/status', [AdminIconQuartetController::class, 'updateStatus'])
            ->name('icon-quartet.update-status');

        Route::get('/icon-quartet-registrations/{registration}/pdf', [AdminIconQuartetController::class, 'downloadPdf'])
            ->name('icon-quartet.download-pdf');

        Route::post('/icon-quartet-registrations/{registration}/pdf/regenerate', [AdminIconQuartetController::class, 'regeneratePdf'])
            ->name('icon-quartet.regenerate-pdf');

        // Icon Plus Quartet registrations
        Route::get('/icon-plus-quartet-registrations', [AdminIconPlusQuartetController::class, 'index'])
            ->name('icon-plus-quartet.index');

        Route::get('/icon-plus-quartet-registrations/export', [AdminIconPlusQuartetController::class, 'export'])
            ->name('icon-plus-quartet.export');

        Route::get('/icon-plus-quartet-registrations/{registration}', [AdminIconPlusQuartetController::class, 'show'])
            ->name('icon-plus-quartet.show');

        Route::post('/icon-plus-quartet-registrations/{registration}/status', [AdminIconPlusQuartetController::class, 'updateStatus'])
            ->name('icon-plus-quartet.update-status');

        Route::get('/icon-plus-quartet-registrations/{registration}/pdf', [AdminIconPlusQuartetController::class, 'downloadPdf'])
            ->name('icon-plus-quartet.download-pdf');

        Route::post('/icon-plus-quartet-registrations/{registration}/pdf/regenerate', [AdminIconPlusQuartetController::class, 'regeneratePdf'])
            ->name('icon-plus-quartet.regenerate-pdf');

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
        Route::resource('employees', EmployeeController::class)->except(['show']);

        Route::get('/check-ins', [CheckInController::class, 'index'])->name('check-ins.index');
        Route::get('/check-ins/export', [CheckInController::class, 'export'])->name('check-ins.export');

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

// Portal (Employee) Routes
Route::prefix('portal')
    ->name('portal.')
    ->group(function () {
        Route::middleware('guest:employee')->group(function () {
            Route::get('/login', [PortalAuthController::class, 'showLogin'])->name('login');
            Route::post('/login', [PortalAuthController::class, 'login'])->name('login.submit');
        });

        Route::middleware('auth:employee')->group(function () {
            Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout');

            Route::get('/scan', [ScanController::class, 'index'])->name('scan');
            Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
        });
    });

// ...

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
