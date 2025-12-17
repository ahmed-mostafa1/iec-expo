<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $displayName = method_exists($sponsor, 'getLocalizedName')
            ? $sponsor->getLocalizedName(app()->getLocale())
            : ($sponsor->name_en ?? $sponsor->name);
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $displayName }} · {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #f5f6f4;
            --card: #fff;
            --border: #e2e8f0;
            --text: #0f172a;
            --accent: #16a34a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Work Sans', sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header,
        footer {
            padding: 1rem 2rem;
        }

        .back-link {
            text-decoration: none;
            color: var(--accent);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem 3rem;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            max-width: 720px;
            width: 100%;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }

        .logo-box {
            width: 160px;
            height: 160px;
            border-radius: 1rem;
            border: 1px dashed var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            background: #f8fafc;
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 2rem;
        }

        .tier {
            text-align: center;
            margin-top: 0.25rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .meta {
            margin-top: 2rem;
            display: grid;
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed var(--border);
            padding-bottom: 0.75rem;
        }

        .meta-item span:last-child {
            font-weight: 600;
        }

        footer {
            text-align: center;
            font-size: 0.85rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    @php
        $logoPath = $sponsor->logo_path
            ? asset('storage/' . $sponsor->logo_path)
            : asset('img/IEC-logo.png');
    @endphp
    <div class="layout">
        <header>
            <a class="back-link" href="{{ route('public.landing', ['locale' => app()->getLocale()]) }}">
                ← {{ __('Back to homepage') }}
            </a>
        </header>
        <main>
            <article class="card">
                <div class="logo-box">
                    <img src="{{ $logoPath }}" alt="{{ $displayName }}">
                </div>
                <h1>{{ $displayName }}</h1>
                <div class="tier">
                    {{ $sponsor->tier ? ucfirst($sponsor->tier) : __('Sponsor') }}
                </div>
                <div class="meta">
                    <div class="meta-item">
                        <span>{{ __('Tier') }}</span>
                        <span>{{ $sponsor->tier ? ucfirst($sponsor->tier) : __('Not set') }}</span>
                    </div>
                    <div class="meta-item">
                        <span>{{ __('Display order') }}</span>
                        <span>{{ $sponsor->display_order }}</span>
                    </div>
                    <div class="meta-item">
                        <span>{{ __('Status') }}</span>
                        <span>{{ $sponsor->is_active ? __('Active') : __('Inactive') }}</span>
                    </div>
                </div>
            </article>
        </main>
        <footer>
            © {{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>
</body>
</html>
