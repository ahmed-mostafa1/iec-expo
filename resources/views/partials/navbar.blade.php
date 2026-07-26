@php
    $locale = $locale ?? $currentLocale ?? app()->getLocale();
    $active = $active ?? 'home';
    $langUrl = $langUrl ?? null;
    $containerClass = $containerClass ?? 'container';

    $landing = route('public.landing', ['locale' => $locale]);
    $isAr = $locale === 'ar';

    // key => [href, arabic, english]
    $navItems = [
        'home' => [$landing . '#hero', 'الرئيسية', 'Home'],
        'ed' => [route('public.ed', ['locale' => $locale]), 'النسخ السابقة من المعرض', 'Previous Editions of IEC'],
        'register' => [$landing . '#register', 'التسجيل', 'Register'],
        'about' => [$landing . '#about', 'عن المعرض', 'About'],
        'sponsors' => [$landing . '#sponsors', 'الراعي', 'Sponsor'],
        'participants' => [$landing . '#participants', 'الأيكون', 'Icon'],
        'organizers' => [$landing . '#organizers', 'الشركة المالكة', 'Owned by'],
        'contact' => [$landing . '#contact', 'تواصل معنا', 'Contact'],
    ];
@endphp

<header class="header">
    <div class="{{ $containerClass }}">
        <div class="header-inner">
            <a href="{{ $landing }}#hero">
                <img src="{{ asset('./img/IEC-logo-nav-v2.png') }}" alt="IEC Logo" class="nav-logo" />
            </a>

            <nav class="nav" aria-label="{{ $isAr ? 'التنقل الرئيسي' : 'Primary navigation' }}">
                @foreach ($navItems as $key => [$href, $ar, $en])
                    <a href="{{ $href }}" class="nav-link{{ $key === $active ? ' btn-primary' : '' }}" data-en="{{ $en }}"
                        data-ar="{{ $ar }}">{{ $isAr ? $ar : $en }}</a>
                @endforeach
            </nav>

            <div class="header-right">
                <div class="header-actions">
                    @php
                        $langInner =
                            '<svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">' .
                            '<circle cx="12" cy="12" r="10" />' .
                            '<path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />' .
                            '</svg><span id="lang-text">' .
                            e($isAr ? 'English' : 'العربية') .
                            '</span>';
                    @endphp
                    @if ($langUrl)
                        <a class="lang-switch" href="{{ $langUrl }}">{!! $langInner !!}</a>
                    @else
                        {{-- landing.blade.php's toggleLocale() swaps text in place, it does not navigate --}}
                        <button type="button" class="lang-switch" onclick="toggleLocale()">{!! $langInner !!}</button>
                    @endif

                    <button type="button" class="mobile-menu-btn" onclick="toggleMobileMenu()"
                        aria-controls="mobile-nav" aria-expanded="false">
                        <svg class="icon" viewBox="0 0 24 24" id="menu-icon" aria-hidden="true">
                            <path d="M3 12h18M3 6h18M3 18h18" />
                        </svg>
                        <span class="sr-only">{{ $isAr ? 'فتح القائمة' : 'Toggle navigation' }}</span>
                    </button>
                </div>

                <a href="https://umbrella.sa">
                    <img class="nav-logo-bu" src="{{ asset('./img/bu_logo.png') }}" alt="BU Logo" />
                </a>
            </div>
        </div>

        <nav class="mobile-nav" id="mobile-nav" aria-label="{{ $isAr ? 'قائمة الجوال' : 'Mobile navigation' }}">
            @foreach ($navItems as [$href, $ar, $en])
                <a href="{{ $href }}" class="mobile-nav-link" data-en="{{ $en }}"
                    data-ar="{{ $ar }}">{{ $isAr ? $ar : $en }}</a>
            @endforeach
        </nav>
    </div>
</header>

@once
    <style>
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: #000;
            backdrop-filter: blur(12px);
        }

        .header .container,
        .header .public-nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding-inline: 1rem;
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
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.4s ease;
            opacity: 0;
            transform: translateY(-12px);
            animation: navLinkFade 0.6s ease forwards;
        }

        .nav-link:hover,
        .nav-link:focus-visible {
            color: #9803bde1;
        }

        .nav-link::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
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

        .nav-logo,
        .nav-logo-bu {
            display: block;
            width: auto;
            max-width: 24vw;
            object-fit: contain;
        }

        .nav-logo {
            height: 80px;
        }

        .nav-logo-bu {
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
            color: #9873ac;
        }

        .header .icon {
            width: 1.5rem;
            height: 1.5rem;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .header .icon-sm {
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
            color: #9873ac;
        }

        .mobile-nav {
            display: none;
            padding: 1rem 0;
            border-top: 1px solid rgb(255 255 255 / 0.14);
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
            color: #9873ac;
        }

        @media (min-width: 1024px) {
            .nav {
                display: flex;
            }

            .mobile-menu-btn {
                display: none;
            }
        }

        @media (max-width: 1023px) {
            .nav-logo {
                height: 60px;
            }

            .nav-logo-bu {
                height: 40px;
            }
        }

        @media (max-width: 640px) {
            .nav-logo {
                height: 44px;
            }

            .nav-logo-bu {
                height: 32px;
            }

            .header-inner,
            .header-right,
            .header-actions {
                gap: 0.5rem;
            }

            .mobile-menu-btn {
                padding: 0.25rem;
            }
        }
    </style>
@endonce
