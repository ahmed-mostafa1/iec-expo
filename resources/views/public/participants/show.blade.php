<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $participant->name }} · {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Work Sans', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }
        .layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header, footer {
            padding: 1rem 2rem;
        }
        .back-link {
            text-decoration: none;
            color: #16a34a;
            font-weight: 600;
        }
        main {
            flex: 1;
            padding: 2rem 1rem 3rem;
            display: flex;
            justify-content: center;
        }
        .card {
            background: #fff;
            border-radius: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
            max-width: 860px;
            width: 100%;
            padding: 2.5rem;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-box {
            width: 150px;
            height: 150px;
            border-radius: 1rem;
            background: #f1f5f9;
            border: 1px dashed #cbd5f5;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        h1 {
            margin: 0;
            font-size: 2.2rem;
        }
        .sections {
            display: grid;
            gap: 1.5rem;
        }
        .section {
            background: #fdfdfd;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
        }
        .section h2 {
            margin-top: 0;
            font-size: 1.1rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .section p {
            margin-bottom: 0.5rem;
            color: #1e293b;
            line-height: 1.6;
        }
        .cta {
            margin-top: 2rem;
            text-align: center;
        }
        .cta a {
            text-decoration: none;
            padding: 0.9rem 1.8rem;
            border-radius: 999px;
            background: #16a34a;
            color: #fff;
            font-weight: 600;
        }
        footer {
            text-align: center;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="layout">
        <header>
            <a class="back-link" href="{{ route('public.landing', ['locale' => app()->getLocale()]) }}">
                ← {{ __('Back to homepage') }}
            </a>
        </header>
        <main>
            <article class="card">
                <div class="header">
                    <div class="logo-box">
                        @if($participant->logo_path)
                            <img src="{{ asset('storage/'.$participant->logo_path) }}" alt="{{ $participant->name }}">
                        @else
                            <span style="font-size: 2.5rem; color: #16a34a;">{{ mb_strtoupper(mb_substr($participant->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <h1>{{ $participant->name }}</h1>
                </div>

                <div class="sections">
                    <div class="section">
                        <h2>{{ __('About') }}</h2>
                        <p>{{ $participant->description_en ?: __('No description provided yet.') }}</p>
                    </div>
                    <div class="section">
                        <h2>{{ __('About (Arabic)') }}</h2>
                        <p>{{ $participant->description_ar ?: __('No Arabic description provided yet.') }}</p>
                    </div>
                </div>

                @if($participant->url)
                    <div class="cta">
                        <a href="{{ $participant->url }}" target="_blank" rel="noopener">
                            {{ __('Visit participant website') }}
                        </a>
                    </div>
                @endif
            </article>
        </main>
        <footer>
            © {{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>
</body>
</html>
