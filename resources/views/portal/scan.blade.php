<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/portal-scan.js'])
    <style>
        .status-card { position: fixed; left: 1rem; right: 1rem; bottom: 1rem; padding: 1rem; border-radius: 0.75rem; color: #fff; text-align: center; }
        .status-card.success { background: #059669; }
        .status-card.warning { background: #d97706; }
        .status-card.error { background: #dc2626; }
        .status-card button { margin: 0.5rem 0.25rem 0; padding: 0.4rem 0.8rem; border-radius: 0.5rem; border: none; background: rgba(255,255,255,.2); color: #fff; }
    </style>
</head>

<body class="bg-black">
    <div class="relative min-h-screen flex flex-col">
        <header class="flex items-center justify-between px-4 py-2 bg-gray-900 text-white text-sm">
            <span>{{ __('Scan badge') }}</span>
            <form method="POST" action="{{ route('portal.logout') }}">
                @csrf
                <button type="submit" class="text-gray-300 hover:text-white">{{ __('Log out') }}</button>
            </form>
        </header>

        <div id="camera-error" hidden class="m-4 rounded-lg bg-red-600 text-white text-sm p-3">
            {{ __('Camera access denied or unavailable. Please allow camera permission and reload the page.') }}
        </div>

        <video id="scan-video" playsinline autoplay muted class="w-full flex-1 object-cover"></video>
        <canvas id="scan-canvas" hidden></canvas>

        <div id="scan-status" hidden class="status-card"></div>
    </div>
</body>

</html>
