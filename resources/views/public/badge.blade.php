<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name }} — IEC 360° Expo Badge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #e5e7eb;
            font-family: 'Poppins', Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .badge {
            position: relative;
            width: 70mm;
            height: 100mm;
            overflow: hidden;
            border-radius: 4mm;
            background: linear-gradient(180deg, #000000 0%, #0f0520 55%, #1a0a2e 100%);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(152, 3, 189, 0.4);
            color: #f8f9fa;
        }

        .badge-glow {
            position: absolute;
            top: -22mm;
            left: 50%;
            transform: translateX(-50%);
            width: 55mm;
            height: 45mm;
            background: radial-gradient(closest-side, rgba(152, 3, 189, 0.45), transparent);
            pointer-events: none;
        }

        .badge-inner {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 6mm 5mm;
            text-align: center;
        }

        .badge-logo {
            display: block;
            height: 17mm;
            max-width: 58mm;
            object-fit: contain;
            margin-bottom: 4mm;
        }

        .badge-name {
            font-size: 14pt;
            font-weight: 700;
            letter-spacing: 0.01em;
            line-height: 1.25;
            max-width: 100%;
            overflow-wrap: break-word;
        }

        .badge-divider {
            width: 20mm;
            height: 2px;
            margin: 3mm 0;
            background: linear-gradient(90deg, transparent, #9803bd, #6024c1, transparent);
            border-radius: 2px;
        }

        .badge-company {
            font-size: 10pt;
            font-weight: 500;
            letter-spacing: 0.03em;
            line-height: 1.35;
            color: rgba(248, 249, 250, 0.75);
            max-width: 100%;
            overflow-wrap: break-word;
        }

        .badge-qr-wrap {
            margin-top: auto;
            margin-bottom: 5mm;
            padding: 1.5mm;
            background: #fff;
            border-radius: 2.5mm;
            box-shadow: 0 0 0 1.5px #9803bd, 0 0 18px rgba(152, 3, 189, 0.45);
            line-height: 0;
        }

        .badge-qr-wrap img {
            display: block;
            width: 22mm;
            height: 22mm;
        }

        .badge-type-pill {
            display: inline-block;
            padding: 1.8mm 8mm;
            border-radius: 999px;
            background: linear-gradient(90deg, #9803bd, #6024c1);
            font-size: 8pt;
            font-weight: 700;
            letter-spacing: 0.14em;
            color: #fff;
            box-shadow: 0 4px 14px rgba(152, 3, 189, 0.4);
        }

        @media print {
            @page {
                size: 70mm 100mm;
                margin: 0;
            }

            html, body {
                background: #000;
                padding: 0;
            }

            .badge {
                box-shadow: none;
                border-radius: 0;
                width: 70mm;
                height: 100mm;
            }
        }
    </style>
</head>
<body>
    <div class="badge">
        <div class="badge-glow"></div>

        <div class="badge-inner">
            <img class="badge-logo" src="{{ asset('img/IEC-logo-v2-1.png') }}" alt="IEC 360 Expo">

            <div class="badge-name">{{ $name }}</div>

            @if($company)
                <div class="badge-divider"></div>
                <div class="badge-company">{{ $company }}</div>
            @endif

            <div class="badge-qr-wrap">
                <img src="{{ $qrDataUri }}" alt="Badge QR code">
            </div>

            <div class="badge-type-pill">{{ $typeLabel }}</div>
        </div>
    </div>
</body>
</html>
