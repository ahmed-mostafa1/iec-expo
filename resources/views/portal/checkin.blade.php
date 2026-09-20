<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manual check-in · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-black text-white">
    <div class="min-h-screen flex flex-col">
        <header class="flex items-center justify-between px-4 py-2 bg-gray-900 text-sm">
            <a href="{{ route('portal.scan') }}" class="text-gray-300 hover:text-white">&larr; {{ __('Back to scan') }}</a>
            <form method="POST" action="{{ route('portal.logout') }}">
                @csrf
                <button type="submit" class="text-gray-300 hover:text-white">{{ __('Log out') }}</button>
            </form>
        </header>

        <main class="w-full max-w-md mx-auto p-4 flex flex-col gap-3">
            <div id="success" hidden class="rounded-lg bg-emerald-600 p-3 text-center"></div>
            <div id="error" hidden class="rounded-lg bg-red-600 p-3 text-sm"></div>

            <div class="flex gap-2">
                <input type="text" id="search" placeholder="{{ __('Search name, phone or email…') }}" autocomplete="off"
                    class="flex-1 rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-white">
                <button type="button" id="register-toggle" class="rounded-lg bg-blue-600 px-4 py-2 font-semibold">{{ __('Register') }}</button>
            </div>

            <div id="results" class="flex flex-col gap-2"></div>

            <div id="selected" hidden class="rounded-lg border border-blue-500 bg-gray-800 p-3 flex flex-col gap-2">
                <div id="selected-info"></div>
                <button type="button" id="checkin-btn" class="rounded-lg bg-emerald-600 py-2 font-semibold">{{ __('Check-in') }}</button>
            </div>

            <form id="register-form" hidden class="flex flex-col gap-2 rounded-lg bg-gray-900 p-3">
                @foreach ([
                    'full_name' => ['Full name', 'text', ''],
                    'email' => ['Email', 'email', ''],
                    'phone' => ['Phone', 'text', '05XXXXXXXX'],
                    'job_title' => ['Job title', 'text', ''],
                    'company_name' => ['Company', 'text', ''],
                ] as $name => [$label, $type, $placeholder])
                    <label class="text-xs text-gray-400">{{ __($label) }}
                        <input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}" required
                            class="mt-1 w-full rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white">
                    </label>
                @endforeach
                <button type="submit" class="rounded-lg bg-blue-600 py-2 font-semibold">{{ __('Register & check in') }}</button>
            </form>
        </main>
    </div>

    <script>
        const base = '/iec360/portal/checkin';
        const $ = (id) => document.getElementById(id);
        const el = { search: $('search'), results: $('results'), selected: $('selected'), info: $('selected-info'),
            success: $('success'), error: $('error'), form: $('register-form') };
        let selected = null;
        let debounce = null;

        const headers = () => ({
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            Accept: 'application/json',
        });

        function showError(message) {
            el.error.textContent = message;
            el.error.hidden = false;
        }

        function reset() {
            selected = null;
            el.search.value = '';
            el.results.replaceChildren();
            el.selected.hidden = true;
            el.form.hidden = true;
            el.form.reset();
        }

        function done(data) {
            reset();
            el.success.textContent = `${data.name}${data.company ? ' — ' + data.company : ''} (${data.type_label})`;
            el.success.hidden = false;
        }

        function line(className, text) {
            const d = document.createElement('div');
            d.className = className;
            d.textContent = text;
            return d;
        }

        el.search.addEventListener('input', () => {
            clearTimeout(debounce);
            el.success.hidden = el.error.hidden = true;
            const q = el.search.value.trim();
            if (q.length < 2) {
                el.results.replaceChildren();
                return;
            }
            debounce = setTimeout(() => runSearch(q), 300);
        });

        async function runSearch(q) {
            try {
                const res = await fetch(`${base}/search?q=${encodeURIComponent(q)}`, { headers: { Accept: 'application/json' } });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || `HTTP ${res.status}`);
                renderResults(data.results);
            } catch (err) {
                showError(`Search failed: ${err.message}`);
            }
        }

        function meta(r) {
            return [r.phone, r.email, r.type].filter(Boolean).join(' · ');
        }

        function renderResults(results) {
            if (!results.length) {
                el.results.replaceChildren(line('text-sm text-gray-400', 'No matches.'));
                return;
            }
            el.results.replaceChildren(...results.map((r) => {
                const b = document.createElement('button');
                b.type = 'button';
                b.className = 'text-left rounded-lg bg-gray-800 p-3 active:bg-gray-700';
                b.append(line('font-semibold', r.name), line('text-xs text-gray-400', meta(r)));
                b.addEventListener('click', () => select(r));
                return b;
            }));
        }

        function select(r) {
            selected = r;
            el.results.replaceChildren();
            el.info.replaceChildren(line('font-semibold', r.name), line('text-xs text-gray-400', meta(r)));
            el.selected.hidden = false;
        }

        async function post(url, body) {
            el.error.hidden = true;
            try {
                const res = await fetch(url, { method: 'POST', headers: headers(), body: JSON.stringify(body) });
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.errors ? Object.values(data.errors).flat().join(' ') : (data.error || data.message || `HTTP ${res.status}`));
                }
                return data;
            } catch (err) {
                showError(err.message);
                return null;
            }
        }

        $('checkin-btn').addEventListener('click', async () => {
            let confirm = false;
            let data = await post(`${base}/${selected.type}/${selected.id}`, { confirm });
            if (data?.duplicate) {
                if (!window.confirm(`Already scanned by ${data.employee} at ${data.scanned_at}. Check in anyway?`)) return;
                data = await post(`${base}/${selected.type}/${selected.id}`, { confirm: true });
            }
            if (data) done(data);
        });

        $('register-toggle').addEventListener('click', () => {
            el.form.hidden = !el.form.hidden;
        });

        el.form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = await post(`${base}/register`, Object.fromEntries(new FormData(el.form)));
            if (data) done(data);
        });
    </script>
</body>

</html>
