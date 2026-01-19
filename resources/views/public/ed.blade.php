<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ app()->getLocale() === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }} - IEC 360 EXPO</title>
    <meta name="description" content="{{ app()->getLocale() === 'ar' ? 'شاهد النسخ السابقة من معرض IEC' : 'Watch previous editions of IEC Expo' }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="IEC 360 EXPO">
    <meta property="og:title" content="{{ app()->getLocale() === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/IEC-logo-nav.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Somar Sans';
            font-style: normal;
            font-weight: 400;
            src: url('https://fonts.cdnfonts.com/s/90887/SomarSans-Regular.woff') format('woff');
        }

        @font-face {
            font-family: 'Somar Sans';
            font-style: normal;
            font-weight: 500;
            src: url('https://fonts.cdnfonts.com/s/90887/SomarSans-Medium.woff') format('woff');
        }

        @font-face {
            font-family: 'Somar Sans';
            font-style: normal;
            font-weight: 600;
            src: url('https://fonts.cdnfonts.com/s/90887/SomarSans-SemiBold.woff') format('woff');
        }

        @font-face {
            font-family: 'Somar Sans';
            font-style: normal;
            font-weight: 700;
            src: url('https://fonts.cdnfonts.com/s/90887/SomarSans-Bold.woff') format('woff');
        }

        :root {
            --primary-color: rgba(96, 36, 193, 1);
            --secondary-color: #6024c1;
            --accent-color: #6024c1;
            --dark-color: #1a1a1a;
            --light-color: #f8f9fa;
            --text-color: #333;
            --text-light: #666;
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --background: 0 0 0;
            --foreground: 248 248 248;
            --card: 18 18 18;
            --card-foreground: 248 248 248;
            --primary: 152, 3, 189, 1;
            --primary-foreground: 251 251 248;
            --secondary: 226 233 226;
            --secondary-foreground: 69 84 69;
            --muted: 20 20 20;
            --muted-foreground: 248 248 248;
            --accent: 28 28 28;
            --accent-foreground: 248 248 248;
            --border: 152, 3, 189, 1;
            --ring: 51 153 88;
            --radius: 0.75rem;
            --chart-1: #9803bd;
            --button-bg: #9803bd;
            --button-hover-bg: rgba(96, 36, 193, 1);
            --button-text: #ffffff;
            --hover-accent: #ffffff;
            --font-en: 'Poppins', sans-serif;
            --font-ar: 'Somar Sans', sans-serif;
        }

        body.locale-en {
            --font-base: var(--font-en);
        }

        body.locale-ar {
            --font-base: var(--font-ar);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            --font-base: var(--font-en);
            font-family: var(--font-base);
            background: linear-gradient(to bottom, #000000 0%, #0f0520 50%, #1a0a2e 100%);
            background-attachment: fixed;
            color: rgb(var(--foreground));
            line-height: 1.6;
            padding-top: 64px;
        }

        body.locale-ar {
            --font-base: var(--font-ar);
        }

        html {
            scroll-behavior: smooth;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: #000;
            backdrop-filter: blur(12px);
        }

        .header-inner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            height: 64px;
            gap: 1rem;
        }

        .nav {
            display: none;
            align-items: center;
            gap: 1rem;
            justify-self: center;
        }

        .nav-link {
            text-decoration: none;
            position: relative;
            transition: color 0.4s ease;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            opacity: 0;
            transform: translateY(-12px);
            animation: navLinkFade 0.6s ease forwards;
        }

        .nav-link:hover {
            color: #9803bde1;
        }

        .nav-link::before {
            content: "";
            position: absolute;
            width: 0;
            height: 4px;
            bottom: 0;
            left: 50%;
            background-color: #9803bde1;
            transition: all 0.4s;
        }

        .nav-link:hover::before {
            width: 100%;
            left: 0;
        }

        @keyframes navLinkFade {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-logo {
            height: 80px;
        }

        .nav-logo-bu {
            height: 60px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: flex-end;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .lang-switch {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #fff;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
            font-family: var(--font-base);
        }

        .lang-switch:hover {
            color: #9873AC;
        }

        .mobile-menu-btn {
            display: none;
            padding: 0.5rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        .mobile-nav {
            display: none;
            padding: 1rem 0;
            border-top: 1px solid rgb(var(--border));
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav-link {
            display: block;
            padding: 0.75rem 0;
            color: rgb(var(--foreground) / 0.8);
            text-decoration: none;
            font-weight: 500;
        }

        /* Main Content */
        .page-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin: 3rem 0 1rem;
            background: linear-gradient(135deg, #9803bd, #6024c1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            text-align: center;
            color: rgb(var(--muted-foreground));
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .videos-section {
            padding: 2rem 0 4rem;
        }

        .videos-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .video-card {
            background: rgb(var(--card));
            border: 1px solid rgba(152, 3, 189, 0.3);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 20px 50px -28px rgba(0, 0, 0, 0.75);
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -28px rgba(152, 3, 189, 0.4);
            border-color: rgba(152, 3, 189, 0.6);
        }

        .video-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
            text-align: center;
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: calc(var(--radius) - 4px);
            background: #000;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .sponsors-section {
            padding: 0 0 5rem;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #ffffff, #b187ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sponsor-carousel {
            position: relative;
            overflow: hidden;
            padding: 1.75rem 0;
            border-radius: calc(var(--radius) + 4px);
            border: 1px solid rgba(152, 3, 189, 0.3);
            background: linear-gradient(120deg, rgba(12, 12, 24, 0.85), rgba(18, 6, 34, 0.85));
            box-shadow: 0 25px 60px -40px rgba(152, 3, 189, 0.5);
        }

        .sponsor-carousel::before,
        .sponsor-carousel::after {
            content: "";
            position: absolute;
            top: 0;
            width: 15%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .sponsor-carousel::before {
            left: 0;
            background: linear-gradient(90deg, rgba(8, 8, 16, 0.9), rgba(8, 8, 16, 0));
        }

        .sponsor-carousel::after {
            right: 0;
            background: linear-gradient(270deg, rgba(8, 8, 16, 0.9), rgba(8, 8, 16, 0));
        }

        .sponsor-track {
            display: flex;
            width: max-content;
            animation: sponsorScroll 28s linear infinite;
        }

        .sponsor-carousel:hover .sponsor-track {
            animation-play-state: paused;
        }

        .sponsor-set {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-right: 1.5rem;
        }

        .sponsor-item {
            display: grid;
            place-items: center;
            width: 200px;
            /* height: 110px; */
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .sponsor-item img {
            max-width: 70%;
            max-height: 70%;
            object-fit: contain;
            /* filter: grayscale(1) brightness(1.05); */
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .sponsor-item:hover {
            transform: translateY(-6px);
            border-color: rgba(152, 3, 189, 0.55);
            box-shadow: 0 18px 35px -22px rgba(152, 3, 189, 0.6);
        }

        .sponsor-item:hover img {
            /* filter: grayscale(0) brightness(1.1); */
            transform: scale(1.06);
        }

        @keyframes sponsorScroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Footer */
        .footer {
            padding: 2rem 0;
            border-top: 1px solid rgb(var(--border));
            background: rgb(var(--card));
        }

        .footer-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-align: center;
        }

        .footer-text {
            font-size: 0.875rem;
            color: rgb(var(--muted-foreground));
        }

        /* Icons */
        .icon {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .icon-sm {
            width: 16px;
            height: 16px;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .mobile-menu-btn {
                display: block;
            }

            .nav-logo {
                height: 60px;
            }

            .nav-logo-bu {
                height: 40px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.6rem;
            }

            .sponsor-item {
                width: 160px;
                /* height: 90px; */
            }

            .sponsor-track {
                animation-duration: 22s;
            }
        }

        @media (min-width: 768px) {
            .nav {
                display: flex;
            }

            .videos-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .nav-logo {
                height: 80px;
            }

            .nav-logo-bu {
                height: 60px;
            }
        }
    </style>
</head>

<body class="locale-{{ app()->getLocale() }}">
    @php
        $locale = app()->getLocale();
    @endphp

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero">
                    <img src="{{ asset('./img/IEC-logo-nav.png') }}" alt="IEC Logo" class="nav-logo" />
                </a>
                <nav class="nav">
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero" class="nav-link" 
                       data-en="Home" data-ar="الرئيسية">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    <a href="{{ route('public.ed', ['locale' => $locale]) }}" class="btn-primary nav-link"
                       data-en="Previous Editions of IEC" data-ar="النسخ السابقة من المعرض">{{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#register" class="nav-link"
                       data-en="Register" data-ar="التسجيل">{{ $locale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#about" class="nav-link" 
                       data-en="About" data-ar="عن المعرض">{{ $locale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#sponsors" class="nav-link" 
                       data-en="Sponsor" data-ar="الراعي">{{ $locale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#participants" class="nav-link" 
                       data-en="Icons" data-ar="الأيكون">{{ $locale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#organizers" class="nav-link" 
                       data-en="Owned by" data-ar="الشركة المالكة">{{ $locale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#contact" class="nav-link" 
                       data-en="Contact" data-ar="تواصل معنا">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
                </nav>
                <div class="header-right">
                    <div class="header-actions">
                        <button class="lang-switch" onclick="toggleLocale()">
                            <svg class="icon icon-sm" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                            <span id="lang-text">{{ $locale === 'ar' ? 'English' : 'العربية' }}</span>
                        </button>
                        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                            <svg class="icon" viewBox="0 0 24 24" id="menu-icon">
                                <path d="M3 12h18M3 6h18M3 18h18" />
                            </svg>
                        </button>
                    </div>
                    <a href="https://umbrella.sa">
                        <img class="nav-logo-bu" src="{{ asset('./img/bu_logo.png') }}" alt="BU Logo" />
                    </a>
                </div>
            </div>
            <nav class="mobile-nav" id="mobile-nav">
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero" class="mobile-nav-link">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                <a href="{{ route('public.ed', ['locale' => $locale]) }}" class="mobile-nav-link">{{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#register" class="mobile-nav-link">{{ $locale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#about" class="mobile-nav-link">{{ $locale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#sponsors" class="mobile-nav-link">{{ $locale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#participants" class="mobile-nav-link">{{ $locale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#organizers" class="mobile-nav-link">{{ $locale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#contact" class="mobile-nav-link">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1 class="page-title" data-en="Previous Editions of IEC" data-ar="النسخ السابقة من المعرض">
                {{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}
            </h1>

            <section class="videos-section">
                <div class="videos-grid">
                    <!-- IEC-1 Video -->
                    <div class="video-card">
                        <h2 class="video-title" data-en="IEC-1" data-ar="IEC-1">
                            {{ $locale === 'ar' ? 'IEC-1' : 'IEC-1' }}
                        </h2>
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/viNQUdsQdHc?list=PL-CMva54bKaHWAKjyPnRTbrC6Fski3_B8&index=2" 
                                title="IEC-1 Video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- IEC-2 Video -->
                    <div class="video-card">
                        <h2 class="video-title" data-en="IEC-2" data-ar="IEC-2">
                            {{ $locale === 'ar' ? 'IEC-2' : 'IEC-2' }}
                        </h2>
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/ZmpZq2n_C3M?list=PL-CMva54bKaFlD3JWQq8cgfyRmE6mjhSq&index=1" 
                                title="IEC-2 Video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>

            <section class="sponsors-section" aria-labelledby="sponsors-title">
                <h2 class="section-title" id="sponsors-title" data-en="Our Sponsors" data-ar="Our Sponsors">
                    {{ $locale === 'ar' ? 'Our Sponsors' : 'Our Sponsors' }}
                </h2>
                <div class="sponsor-carousel">
                    <div class="sponsor-track">
                        <div class="sponsor-set">
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/1.jpeg') }}" alt="IEC 360 Expo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/2.jpeg') }}" alt="IEC Logo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/3.jpeg') }}" alt="Business Umbrella">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/4.png') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/5.png') }}" alt="The Arena">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/6.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/7.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/8.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/9.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/10.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/11.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/12.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/13.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/14.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/15.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/16.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/17.png') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/18.png') }}" alt="Sponsor Placeholder">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-text">
                    <span data-en="IEC 360&deg; EXPO" data-ar="IEC 360&deg; EXPO">IEC 360&deg; EXPO</span>
                </div>
                <div class="footer-text" data-en="All rights reserved ©️ Business Umbrella Company" data-ar="جميع الحقوق محفوظة ©️ شركة مظلة الأعمال.">
                    {{ $locale === 'ar' ? 'جميع الحقوق محفوظة ©️ شركة مظلة الأعمال.' : 'All rights reserved ©️ Business Umbrella Company' }}
                </div>
            </div>
        </div>
    </footer>

    <script>
        let currentLocale = @json($locale);

        function toggleLocale() {
            const newLocale = currentLocale === 'en' ? 'ar' : 'en';
            const currentPath = window.location.pathname;
            const newPath = currentPath.replace(`/${currentLocale}`, `/${newLocale}`);
            window.location.href = newPath;
        }

        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobile-nav');
            mobileNav.classList.toggle('active');
        }

        // Update text based on locale
        function updateLocaleText() {
            document.querySelectorAll('[data-en][data-ar]').forEach(el => {
                if (el.hasAttribute('data-en') && el.hasAttribute('data-ar')) {
                    const text = currentLocale === 'ar' ? el.getAttribute('data-ar') : el.getAttribute('data-en');
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                        el.placeholder = text;
                    } else {
                        el.textContent = text;
                    }
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateLocaleText();
        });
    </script>
</body>

</html>
