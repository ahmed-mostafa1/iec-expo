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
    $seoPageKey = trim($__env->yieldContent('seo_page', 'analytics')) ?: 'analytics';
    $seoPage = config("seo.pages.$seoPageKey.$currentLocale", config("seo.pages.$seoPageKey.en", config('seo.pages.analytics.en')));
    $seoTitle = trim($__env->yieldContent('title', $seoPage['title'])) ?: $seoPage['title'];
    $seoDescription = trim($__env->yieldContent('meta_description', $seoPage['description'])) ?: $seoPage['description'];
    $seoKeywords = implode(', ', config("seo.keywords.$currentLocale", []));
    $seoCanonical = $routeName
        ? route($routeName, array_merge($routeParameters, ['locale' => $currentLocale]))
        : url()->current();
    $seoAlternateEn = $routeName
        ? route($routeName, array_merge($routeParameters, ['locale' => 'en']))
        : $seoCanonical;
    $seoAlternateAr = $routeName
        ? route($routeName, array_merge($routeParameters, ['locale' => 'ar']))
        : $seoCanonical;
    $seoImage = asset(config('seo.image'));
@endphp

<!DOCTYPE html>
<html lang="{{ $currentLocale }}" dir="{{ $dir }}">
<head>
    @include("partials.favicons")
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <link rel="alternate" hreflang="en" href="{{ $seoAlternateEn }}">
    <link rel="alternate" hreflang="ar" href="{{ $seoAlternateAr }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seoAlternateEn }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('seo.site_name') }}">
    <meta property="og:locale" content="{{ $currentLocale === 'ar' ? 'ar_SA' : 'en_US' }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

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

        html,
        body {
            min-height: 100%;
            background:
                radial-gradient(circle at 18% 0%, rgba(152, 115, 172, 0.22), transparent 34rem),
                radial-gradient(circle at 82% 12%, rgba(75, 23, 101, 0.24), transparent 30rem),
                #050208;
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

        .analytics-main {
            padding-top: 7rem;
        }

        @media (min-width: 1024px) {
        }

        @media (max-width: 640px) {
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
    class="locale-{{ $currentLocale }} min-h-screen bg-[#050208] text-white antialiased"
    @if(session('scroll_to_contact') ?? false) data-scroll-contact="1" @endif
>
    {{-- Navbar --}}
    @include('partials.navbar', ['locale' => $currentLocale, 'langUrl' => $languageSwitchUrl, 'containerClass' => 'public-nav-container'])

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

    <footer class="border-t border-white/10 bg-[#050208] py-4 text-sm text-white/[0.55]">
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
