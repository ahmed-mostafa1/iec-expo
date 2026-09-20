<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/portal-scan.js'])
    <style>
        .status-card { margin: 0.75rem 1rem; padding: 1rem; border-radius: 0.75rem; color: #fff; text-align: center; }
        .status-card.success { background: #059669; }
        .status-card.warning { background: #d97706; }
        .status-card.error { background: #dc2626; }
        .status-card button { margin: 0.5rem 0.25rem 0; padding: 0.4rem 0.8rem; border-radius: 0.5rem; border: none; background: rgba(255,255,255,.2); color: #fff; }

        .manual-modal { position: fixed; inset: 0; background: rgba(0,0,0,.6); display: flex; align-items: flex-end; justify-content: center; z-index: 50; }
        .manual-panel { background: #111827; color: #fff; width: 100%; max-width: 480px; max-height: 85vh; overflow-y: auto; border-radius: 1rem 1rem 0 0; padding: 1rem; }
        .manual-tabs { display: flex; gap: .5rem; margin-bottom: .75rem; }
        .manual-tabs button { flex: 1; padding: .5rem; border-radius: .5rem; border: none; background: #1f2937; color: #9ca3af; }
        .manual-tabs button.active { background: #2563eb; color: #fff; }
        .manual-panel input, .manual-panel select { width: 100%; padding: .5rem .6rem; margin-bottom: .5rem; border-radius: .5rem; border: 1px solid #374151; background: #1f2937; color: #fff; }
        .manual-panel label { font-size: .8rem; color: #9ca3af; display: block; margin-bottom: .2rem; }
        .manual-close { float: right; background: none; border: none; color: #9ca3af; font-size: 1.2rem; }
        .manual-result { padding: .6rem; border-radius: .5rem; background: #1f2937; margin-bottom: .4rem; cursor: pointer; }
        .manual-result:active { background: #374151; }
        .manual-result .name { font-weight: 600; }
        .manual-result .meta { font-size: .8rem; color: #9ca3af; }
        .manual-submit { width: 100%; padding: .6rem; border-radius: .5rem; border: none; background: #2563eb; color: #fff; font-weight: 600; }
        .manual-error { color: #f87171; font-size: .85rem; margin-bottom: .5rem; }
    </style>
</head>

<body class="bg-black">
    <div class="relative min-h-screen flex flex-col">
        <header class="flex items-center justify-between px-4 py-2 bg-gray-900 text-white text-sm">
            <span>{{ __('Scan badge') }}</span>
            <div class="flex items-center gap-3">
                <button type="button" id="manual-open" class="text-gray-300 hover:text-white">{{ __('Manual check-in') }}</button>
                <form method="POST" action="{{ route('portal.logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white">{{ __('Log out') }}</button>
                </form>
            </div>
        </header>

        <div id="camera-error" hidden class="m-4 rounded-lg bg-red-600 text-white text-sm p-3">
            {{ __('Camera access denied or unavailable. Please allow camera permission and reload the page.') }}
        </div>

        <div id="scan-status" hidden class="status-card"></div>

        <video id="scan-video" playsinline autoplay muted class="w-full flex-1 object-cover"></video>
        <canvas id="scan-canvas" hidden></canvas>

        <div id="manual-modal" hidden class="manual-modal">
            <div class="manual-panel">
                <button type="button" id="manual-close" class="manual-close">&times;</button>
                <div class="manual-tabs">
                    <button type="button" id="tab-search" class="active">{{ __('Search') }}</button>
                    <button type="button" id="tab-register">{{ __('Register new') }}</button>
                </div>

                <div id="manual-error" class="manual-error" hidden></div>

                <div id="panel-search">
                    <input type="text" id="manual-search-input" placeholder="{{ __('Search name or phone…') }}" autocomplete="off">
                    <div id="manual-results"></div>
                </div>

                <form id="panel-register" hidden>
                    <label>{{ __('Full name') }}</label>
                    <input type="text" name="full_name" required>
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" required>
                    <label>{{ __('Phone') }}</label>
                    <input type="text" name="phone" placeholder="05XXXXXXXX" required>
                    <label>{{ __('Job title') }}</label>
                    <input type="text" name="job_title" required>
                    <label>{{ __('Company') }}</label>
                    <input type="text" name="company_name" required>
                    <button type="submit" class="manual-submit">{{ __('Register & check in') }}</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
