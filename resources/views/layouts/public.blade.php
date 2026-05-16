@php
    $currentLocale = $currentLocale ?? app()->getLocale();
    $currentLocale = in_array($currentLocale, ['en', 'ar'], true) ? $currentLocale : 'ar';
    $dir = $dir ?? ($currentLocale === 'ar' ? 'rtl' : 'ltr');
    $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
    $currentRoute = request()->route();
    $routeName = $currentRoute?->getName();
    $routeParameters = $currentRoute?->parameters() ?? [];
    $switchParameters = array_merge($routeParameters, ['locale' => $switchLocale]);
    $switchQuery = request()->query();
    unset($switchQuery['locale']);

    $languageSwitchUrl = $routeName
        ? route($routeName, array_merge($switchParameters, $switchQuery))
        : route('public.analytics', ['locale' => $switchLocale]);
@endphp

<!DOCTYPE html>
<html lang="{{ $currentLocale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Event Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Simple font setup (you can refine in Tailwind config) --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

        :root {
            --analytics-nav-border: 255 255 255 / 0.16;
            --analytics-nav-accent: #9873AC;
        }

        body.locale-en {
            font-family: Inter, sans-serif;
        }

        body.locale-ar {
            font-family: Cairo, sans-serif;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: #000;
            backdrop-filter: blur(12px);
        }

        .public-nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header-inner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 1rem;
            min-height: 64px;
        }

        .nav {
            display: none;
            align-items: center;
            justify-self: center;
            gap: 1rem;
        }

        .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            color: #fff;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            transition: color 0.4s ease;
        }

        .nav-link:hover,
        .nav-link:focus-visible {
            color: #9803bde1;
        }

        .nav-link::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -0.35rem;
            width: 0;
            height: 4px;
            background-color: #9803bde1;
            transition: all 0.4s;
        }

        .nav-link:hover::before,
        .nav-link:focus-visible::before {
            left: 0;
            width: 100%;
        }

        .nav-logo {
            display: block;
            width: auto;
            height: 80px;
        }

        .nav-logo-bu {
            display: block;
            width: auto;
            height: 60px;
        }

        .header-right,
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-right {
            justify-content: flex-end;
        }

        .lang-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #fff;
            font: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            background: none;
            border: 0;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .lang-switch:hover,
        .lang-switch:focus-visible {
            color: var(--analytics-nav-accent);
        }

        .icon {
            width: 1.5rem;
            height: 1.5rem;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .icon-sm {
            width: 1rem;
            height: 1rem;
        }

        .mobile-menu-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            color: #fff;
            background: none;
            border: 0;
            cursor: pointer;
        }

        .mobile-menu-btn:hover,
        .mobile-menu-btn:focus-visible {
            color: var(--analytics-nav-accent);
        }

        .mobile-nav {
            display: none;
            padding: 1rem 0;
            border-top: 1px solid rgb(var(--analytics-nav-border));
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav-link {
            display: block;
            padding: 0.75rem 0;
            color: rgb(255 255 255 / 0.84);
            font-weight: 500;
            text-decoration: none;
        }

        .mobile-nav-link:hover,
        .mobile-nav-link:focus-visible {
            color: var(--analytics-nav-accent);
        }

        .analytics-main {
            padding-top: 7rem;
        }

        @media (min-width: 1024px) {
            .nav {
                display: flex;
            }

            .mobile-menu-btn {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .nav-logo {
                height: 56px;
            }

            .nav-logo-bu {
                height: 44px;
            }

            .header-actions {
                gap: 0.5rem;
            }

            .analytics-main {
                padding-top: 6rem;
            }
        }
    </style>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HED35JNVSW"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HED35JNVSW');
</script>
</head>
<body
    class="locale-{{ $currentLocale }} min-h-screen antialiased bg-gray-50 text-gray-900"
    @if(session('scroll_to_contact') ?? false) data-scroll-contact="1" @endif
>
    {{-- Navbar --}}
    <header class="header">
        <div class="public-nav-container">
            <div class="header-inner">
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#hero">
                    <img src="{{ asset('./img/IEC-logo-nav.png') }}" alt="IEC Logo" class="nav-logo">
                </a>

                <nav class="nav" aria-label="{{ __('Primary navigation') }}">
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#hero" class="nav-link">{{ $currentLocale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    <a href="{{ route('public.ed', ['locale' => $currentLocale]) }}" class="nav-link">{{ $currentLocale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#register" class="nav-link">{{ $currentLocale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#about" class="nav-link">{{ $currentLocale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#sponsors" class="nav-link">{{ $currentLocale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#participants" class="nav-link">{{ $currentLocale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#organizers" class="nav-link">{{ $currentLocale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#contact" class="nav-link">{{ $currentLocale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
                </nav>

                <div class="header-right">
                    <div class="header-actions">
                        <a class="lang-switch" href="{{ $languageSwitchUrl }}">
                            <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                            <span id="lang-text">{{ $currentLocale === 'ar' ? 'English' : 'العربية' }}</span>
                        </a>

                        <button type="button" class="mobile-menu-btn" aria-controls="mobile-nav" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 12h18M3 6h18M3 18h18"></path>
                            </svg>
                            <span class="sr-only">{{ __('Toggle navigation') }}</span>
                        </button>
                    </div>

                    <a href="https://umbrella.sa">
                        <img class="nav-logo-bu" src="{{ asset('./img/bu_logo.png') }}" alt="BU Logo">
                    </a>
                </div>
            </div>

            <nav class="mobile-nav" id="mobile-nav" aria-label="{{ __('Mobile navigation') }}">
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#hero" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                <a href="{{ route('public.ed', ['locale' => $currentLocale]) }}" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#register" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#about" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#sponsors" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#participants" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#organizers" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                <a href="{{ route('public.landing', ['locale' => $currentLocale]) }}#contact" class="mobile-nav-link">{{ $currentLocale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
            </nav>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mx-auto max-w-3xl mt-4 px-4">
            <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Validation error summary (optional) --}}
    @if ($errors->any())
        <div class="mx-auto max-w-3xl mt-4 px-4">
            <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                <div class="font-semibold mb-1">{{ __('There were some problems with your submission:') }}</div>
                <ul class="list-disc ms-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="analytics-main mx-auto max-w-6xl px-4 pb-16">
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 py-4 text-sm text-gray-500">
        <div class="mx-auto max-w-6xl px-4 flex items-center justify-between">
            <div>&copy; {{ date('Y') }} {{ config('app.name') }}</div>
            <div>{{ $currentLocale === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}</div>
        </div>
    </footer>

    {{-- Basic JS: smooth scroll, language switcher, scroll_to_contact --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.querySelector('.mobile-menu-btn');
            const mobileNav = document.getElementById('mobile-nav');

            if (menuButton && mobileNav) {
                menuButton.addEventListener('click', () => {
                    const isOpen = mobileNav.classList.toggle('active');
                    menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });

                mobileNav.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileNav.classList.remove('active');
                        menuButton.setAttribute('aria-expanded', 'false');
                    });
                });
            }

            // Scroll to contact if flag set (duplicate sponsor)
            const scrollFlag = document.body.dataset.scrollContact;
            if (scrollFlag) {
                const contact = document.getElementById('contact');
                if (contact) {
                    contact.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    </script>
</body>
</html>
