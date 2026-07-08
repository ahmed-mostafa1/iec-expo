@php
    $seoLocale = app()->getLocale() === 'ar' ? 'ar' : 'en';
    $seoPage = config("seo.pages.ed.$seoLocale", config('seo.pages.ed.en'));
    $seoKeywords = implode(', ', config("seo.keywords.$seoLocale", []));
    $seoCanonical = route('public.ed', ['locale' => $seoLocale]);
    $seoAlternateEn = route('public.ed', ['locale' => 'en']);
    $seoAlternateAr = route('public.ed', ['locale' => 'ar']);
    $seoImage = asset(config('seo.image'));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $seoPage['title'] }}</title>
    <meta name="description" content="{{ $seoPage['description'] }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <link rel="alternate" hreflang="en" href="{{ $seoAlternateEn }}">
    <link rel="alternate" hreflang="ar" href="{{ $seoAlternateAr }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seoAlternateEn }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('seo.site_name') }}">
    <meta property="og:locale" content="{{ $seoLocale === 'ar' ? 'ar_SA' : 'en_US' }}">
    <meta property="og:title" content="{{ $seoPage['title'] }}">
    <meta property="og:description" content="{{ $seoPage['description'] }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoPage['title'] }}">
    <meta name="twitter:description" content="{{ $seoPage['description'] }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

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
        height: 48px;
        max-height: 100%;
        width: auto;
        display: block;
    }

    .nav-logo-bu {
        height: 40px;
        max-height: 100%;
        width: auto;
        display: block;
    }

    .header-right {
        display: flex;
        align-items: center;
        /* gap: 1rem; */
        justify-content: flex-end;
    }

    .header-actions {
        display: flex;
        align-items: center;
        /* gap: 1rem; */
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
        padding-bottom: 56.25%;
        /* 16:9 aspect ratio */
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
        /* --sponsor-item-height: 110px; */
        /* min-height: calc(var(--sponsor-item-height) + 3.5rem); */
    }

    /* Increase the value to make the carousel slower, decrease to make it faster */
    #sponsors-carousel {
        --carousel-speed: 36s;
    }

    #icons-carousel {
        --carousel-speed: 80s;
    }

    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(152, 3, 189, 0.8);
        border: 1px solid rgba(152, 3, 189, 0.6);
        color: #fff;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        backdrop-filter: blur(8px);
    }

    .carousel-control:hover {
        background: rgba(152, 3, 189, 1);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 20px rgba(152, 3, 189, 0.6);
    }

    .carousel-control-prev {
        left: 15px;
    }

    .carousel-control-next {
        right: 15px;
    }

    .carousel-control i {
        font-size: 1.2rem;
    }

    /* 
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
        } */

    .sponsor-track {
        display: flex;
        align-items: center;
        width: max-content;
        animation: sponsorScroll var(--carousel-speed, 20s) linear infinite;
        --offset: 0px;
    }

    body.locale-ar .sponsor-track {
        animation-direction: reverse;
    }

    body.locale-ar .sponsor-carousel {
        direction: ltr;
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
        height: var(--sponsor-item-height);
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .sponsor-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 8px;
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
            transform: translateX(var(--offset, 0px));
        }

        100% {
            transform: translateX(calc(var(--offset, 0px) - 50%));
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
        stroke: #fff;
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
            height: 44px;
        }

        .nav-logo-bu {
            height: 32px;
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

        .sponsor-carousel {
            /* --sponsor-item-height: 90px; */
            min-height: calc(var(--sponsor-item-height) + 3rem);
        }

        .sponsor-item {
            width: 160px;
            height: var(--sponsor-item-height);
        }

        .sponsor-track {
            animation-duration: var(--carousel-speed-mobile, var(--carousel-speed, 16s));
        }

        #sponsors-carousel {
            --carousel-speed-mobile: 28s;
        }

        #icons-carousel {
            --carousel-speed-mobile: 64s;
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
            height: 56px;
        }

        .nav-logo-bu {
            height: 48px;
        }
    }

    /* To Top Button */
    .to-top-button {
        position: fixed !important;
        bottom: 2rem !important;
        left: 2rem !important;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #9803bd;
        border: none;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(152, 3, 189, 0.4);
        transition: all 0.3s ease;
        z-index: 10000 !important;
        opacity: 0;
        visibility: hidden;
        transform: translateY(100px);
        animation: pulse 2s infinite;
    }

    .to-top-button.show {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }

    .to-top-button:hover {
        background: rgba(96, 36, 193, 1);
        box-shadow: 0 6px 20px rgba(152, 3, 189, 0.6);
        transform: translateY(-3px);
        animation: none;
    }

    .to-top-button:active {
        transform: translateY(-1px);
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 4px 12px rgba(152, 3, 189, 0.4);
        }

        50% {
            box-shadow: 0 4px 20px rgba(152, 3, 189, 0.7), 0 0 0 10px rgba(152, 3, 189, 0.1);
        }
    }

    @media (max-width: 768px) {
        .to-top-button {
            bottom: 1.5rem;
            left: 1.5rem;
            width: 45px;
            height: 45px;
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

<body class="locale-{{ app()->getLocale() }}">
    @php
    $locale = app()->getLocale();
    @endphp

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero">
                    <img src="{{ asset('./img/IEC-logo-nav-v2.png') }}" alt="IEC Logo" class="nav-logo" />
                </a>
                <nav class="nav">
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero" class="nav-link" data-en="Home"
                        data-ar="الرئيسية">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    <a href="{{ route('public.ed', ['locale' => $locale]) }}" class="btn-primary nav-link"
                        data-en="Previous Editions of IEC"
                        data-ar="النسخ السابقة من المعرض">{{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#register" class="nav-link"
                        data-en="Register" data-ar="التسجيل">{{ $locale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#about" class="nav-link"
                        data-en="About" data-ar="عن المعرض">{{ $locale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#sponsors" class="nav-link"
                        data-en="Sponsor" data-ar="الراعي">{{ $locale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#participants" class="nav-link"
                        data-en="Icons" data-ar="الأيكون">{{ $locale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#organizers" class="nav-link"
                        data-en="Owned by"
                        data-ar="الشركة المالكة">{{ $locale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                    <a href="{{ route('public.landing', ['locale' => $locale]) }}#contact" class="nav-link"
                        data-en="Contact" data-ar="تواصل معنا">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
                </nav>
                <div class="header-right">
                    <div class="header-actions">
                        <button class="lang-switch" onclick="toggleLocale()">
                            <svg class="icon icon-sm" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path
                                    d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
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
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#hero"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                <a href="{{ route('public.ed', ['locale' => $locale]) }}"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#register"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'التسجيل' : 'Register' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#about"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'عن المعرض' : 'About' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#sponsors"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'الراعي' : 'Sponsor' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#participants"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'الأيكون' : 'Icon' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#organizers"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'الشركة المالكة' : 'Owned by' }}</a>
                <a href="{{ route('public.landing', ['locale' => $locale]) }}#contact"
                    class="mobile-nav-link">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact' }}</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1 class="page-title" data-en="Previous Editions of IEC" data-ar="النسخ السابقة من المعرض">
                {{ $locale === 'ar' ? 'النسخ السابقة من المعرض' : 'Previous Editions of IEC' }}
            </h1>
            <!-- Videos -->
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
            <!-- Sponsors Section -->
            <section class="sponsors-section" aria-labelledby="sponsors-title">
                <h2 class="section-title" id="sponsors-title" data-en="Sponsors" data-ar="الرعاة">
                    {{ $locale === 'ar' ? 'Sponsors' : 'Sponsors' }}
                </h2>
                <div class="sponsor-carousel" id="sponsors-carousel">
                    <button class="carousel-control carousel-control-prev"
                        onclick="scrollCarousel('sponsors-carousel', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="sponsor-track">
                        <div class="sponsor-set">
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/1.jpg') }}" alt="IEC Logo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/2.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/3.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/4.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/5.jpg') }}" alt="IEC Logo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/6.jpg') }}" alt="The Arena">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/7.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/8.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/9.jpg') }}" alt="Authority">
</div>
                                <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/10.jpg') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/11.jpg') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/12.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/13.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/14-v2.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <!-- Duplicate Slider Items for Infinite Loop -->
                           <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/1.jpg') }}" alt="IEC Logo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/2.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/3.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/4.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/5.jpg') }}" alt="IEC Logo">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/6.jpg') }}" alt="The Arena">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/7.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/8.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/9.jpg') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/10.jpg') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/11.jpg') }}" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/12.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/13.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exsponsor/14-v2.jpg') }}" style="background-color: #fff;" alt="Authority">
                            </div>
                            <!-- end of duplicate -->
                        </div>
                    </div>
                    <button class="carousel-control carousel-control-next"
                        onclick="scrollCarousel('sponsors-carousel', 'right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>

            <!-- Icons Section -->
            <section class="sponsors-section" aria-labelledby="sponsors-title">
                <h2 class="section-title" id="sponsors-title" data-en="ICONS" data-ar="الأيكونز">
                    {{ $locale === 'ar' ? 'ICONS' : 'ICONS' }}
                </h2>
                <div class="sponsor-carousel" id="icons-carousel">
                    <button class="carousel-control carousel-control-prev"
                        onclick="scrollCarousel('icons-carousel', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="sponsor-track">
                        <div class="sponsor-set">

                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/1.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/2.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/3.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/4.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/5.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/6.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/7.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/8.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/9.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/10.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/11.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/12.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/13.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/14.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/15.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/16.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/17.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/18.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/19.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/20.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/21.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/22.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/23.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/24.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/25.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/26.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/27.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/28.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/29.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/30.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/31.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/32.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/33.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/34.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/35.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/36.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/37.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/40.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/41.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/42.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/43.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/44.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/45.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/46.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/47.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/48.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/49.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/50.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/51.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/52.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/53.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/54.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/55.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/56.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/57.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/58.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/59.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/60.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/61.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/62.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/63.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/64.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/65.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/66.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/67.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/68.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/69.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                            <div class="sponsor-item">
                                <img src="{{ asset('img/exicons/70.jpg') }}" alt="Sponsor Placeholder">
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control carousel-control-next"
                        onclick="scrollCarousel('icons-carousel', 'right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
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
                <div class="footer-text" data-en="All rights reserved ©️ Business Umbrella Company"
                    data-ar="جميع الحقوق محفوظة ©️ شركة مظلة الأعمال.">
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

    // Carousel scroll function
    function scrollCarousel(carouselId, direction) {
        const carousel = document.getElementById(carouselId);
        const track = carousel.querySelector('.sponsor-track');
        const sponsorSet = track.querySelector('.sponsor-set');
        const item = track.querySelector('.sponsor-item');

        if (!item) return;

        // Calculate one step (item width + gap)
        const style = window.getComputedStyle(sponsorSet);
        const gap = parseFloat(style.gap) || 24;
        const scrollAmount = item.offsetWidth + gap;

        // Get current offset from CSS variable
        let currentOffset = parseFloat(getComputedStyle(track).getPropertyValue('--offset')) || 0;

        // Calculate new offset
        // In LTR, 'left' means moving content to the right (positive offset)
        // 'right' means moving content to the left (negative offset)
        let newOffset = direction === 'left' ? currentOffset + scrollAmount : currentOffset - scrollAmount;

        // Calculate the width of half the content (one complete set)
        // The sponsor-set contains all items (original + duplicate)
        const totalWidth = sponsorSet.scrollWidth;
        const halfWidth = totalWidth / 2;

        // Infinite loop logic: reset position when reaching boundaries
        // When scrolling right (negative offset) and we've gone past halfway
        if (newOffset <= -halfWidth) {
            newOffset = newOffset + halfWidth;
        }
        // When scrolling left (positive offset) and we've gone past the start
        else if (newOffset > 0) {
            newOffset = newOffset - halfWidth;
        }

        // Apply new offset to CSS variable
        track.style.setProperty('--offset', newOffset + 'px');

        // Brief visual feedback if not hovering
        if (!carousel.matches(':hover')) {
            track.style.animationPlayState = 'paused';
            setTimeout(() => {
                track.style.animationPlayState = 'running';
            }, 50);
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateLocaleText();
    });

    // To Top Button functionality
    const toTopBtn = document.getElementById('to-top-btn');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            toTopBtn.classList.add('show');
        } else {
            toTopBtn.classList.remove('show');
        }
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    </script>

    <!-- To Top Button -->
    <button id="to-top-btn" class="to-top-button" type="button" aria-label="Back to top" onclick="scrollToTop()">
        <svg class="icon icon-sm" viewBox="0 0 24 24">
            <path d="M12 19V5M5 12l7-7 7 7" />
        </svg>
    </button>
</body>

</html>
