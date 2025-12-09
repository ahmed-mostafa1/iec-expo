<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $dir ?? 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Event Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Simple font setup (you can refine in Tailwind config) --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
    </style>
</head>
<body
    class="min-h-screen antialiased bg-gray-50 text-gray-900
           {{ ($currentLocale ?? app()->getLocale()) === 'ar' ? 'font-[Cairo]' : 'font-sans' }}"
    @if(session('scroll_to_contact') ?? false) data-scroll-contact="1" @endif
>
    {{-- Navbar --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-gray-200">
        <nav class="mx-auto max-w-6xl flex items-center justify-between py-3 px-4">
            <div class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold">
                    EP
                </div>
                <div class="text-sm font-semibold tracking-wide">
                    {{ __('Event Portal') }}
                </div>
            </div>

            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="#hero" class="hover:text-emerald-600 nav-link">{{ __('Home') }}</a>
                <a href="#about" class="hover:text-emerald-600 nav-link">{{ __('About') }}</a>
                <a href="#register" class="hover:text-emerald-600 nav-link">{{ __('Register') }}</a>
                <a href="#sponsors" class="hover:text-emerald-600 nav-link">{{ __('Sponsors') }}</a>
                <a href="#participants" class="hover:text-emerald-600 nav-link">{{ __('Participants') }}</a>
                <a href="#contact" class="hover:text-emerald-600 nav-link">{{ __('Contact') }}</a>

                {{-- Language switcher --}}
                <div class="flex items-center gap-1 text-xs border border-gray-200 rounded-full px-1 py-0.5">
                    <button
                        type="button"
                        class="px-2 py-0.5 rounded-full lang-switch {{ ($currentLocale ?? 'en') === 'en' ? 'bg-emerald-600 text-white' : 'text-gray-600' }}"
                        data-locale="en"
                    >
                        EN
                    </button>
                    <button
                        type="button"
                        class="px-2 py-0.5 rounded-full lang-switch {{ ($currentLocale ?? 'en') === 'ar' ? 'bg-emerald-600 text-white' : 'text-gray-600' }}"
                        data-locale="ar"
                    >
                        AR
                    </button>
                </div>
            </div>
        </nav>
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

    <main class="mx-auto max-w-6xl px-4 pt-6 pb-16">
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 py-4 text-xs text-gray-500">
        <div class="mx-auto max-w-6xl px-4 flex items-center justify-between">
            <div>© {{ date('Y') }} {{ config('app.name') }}</div>
            <div>{{ __('All rights reserved.') }}</div>
        </div>
    </footer>

    {{-- Basic JS: smooth scroll, language switcher, scroll_to_contact --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Smooth scroll for nav links
            document.querySelectorAll('a.nav-link[href^="#"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Language switcher: keep current hash (#section)
            document.querySelectorAll('.lang-switch').forEach(btn => {
                btn.addEventListener('click', () => {
                    const locale = btn.dataset.locale;
                    const hash = window.location.hash || '';
                    window.location.href = '/' + locale + hash;
                });
            });

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
