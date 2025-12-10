<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin · {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-60 bg-white border-e border-gray-200 py-4 px-3 hidden md:flex flex-col">
            <div class="flex items-center gap-2 mb-6 ps-2 pe-2">
                <div class="h-8 w-8 rounded-full bg-emerald-600 flex items-center justify-center text-xs font-bold text-white">
                    EP
                </div>
                <div class="text-xs font-semibold text-gray-900">
                    {{ __('Admin Panel') }}
                </div>
            </div>

            <nav class="flex-1 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Dashboard') }}
                </a>

                <div class="mt-4 text-[10px] uppercase tracking-wide text-gray-400 ps-2">
                    {{ __('Registrations') }}
                </div>
                <a href="{{ route('admin.sponsors.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Sponsor registrations') }}
                </a>
                <a href="{{ route('admin.visitors.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Visitor registrations') }}
                </a>

                <div class="mt-4 text-[10px] uppercase tracking-wide text-gray-400 ps-2">
                    {{ __('Website content') }}
                </div>
                <a href="{{ route('admin.public-sponsors.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Sponsors (public)') }}
                </a>
                <a href="{{ route('admin.participants.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Participants') }}
                </a>
                <a href="{{ route('admin.about.edit') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('About content') }}
                </a>
                <a href="{{ route('admin.contact-infos.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Contact info') }}
                </a>
                <a href="{{ route('admin.hero-media.index') }}" class="block rounded-lg px-2 py-1.5 hover:bg-emerald-50 text-gray-700">
                    {{ __('Hero media') }}
                </a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                    {{ __('Log out') }}
                </button>
            </form>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col">
            <header class="h-12 bg-white border-b border-gray-200 flex items-center justify-between px-4">
                <div class="text-xs text-gray-500">
                    {{ __('Welcome, Admin') }}
                </div>
            </header>

            <main class="flex-1 p-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
