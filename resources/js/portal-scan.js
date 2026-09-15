import jsQR from 'jsqr';

const video = document.getElementById('scan-video');
const canvas = document.getElementById('scan-canvas');
const ctx = canvas.getContext('2d', { willReadFrequently: true });
const statusEl = document.getElementById('scan-status');
const cameraErrorEl = document.getElementById('camera-error');
const scanUrl = '/iec360/portal/scan';
const searchUrl = '/iec360/portal/checkin/search';
const registerUrl = '/iec360/portal/checkin/register';
const checkInUrlBase = '/iec360/portal/checkin';

let scanning = true;

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' },
        });
        video.srcObject = stream;
        await video.play();
        requestAnimationFrame(tick);
    } catch (err) {
        cameraErrorEl.hidden = false;
    }
}

function tick() {
    if (scanning && video.readyState === video.HAVE_ENOUGH_DATA) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const frame = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(frame.data, frame.width, frame.height);

        if (code) {
            scanning = false;
            submitScan(code.data, false);
        }
    }
    requestAnimationFrame(tick);
}

async function submitScan(url, confirm) {
    let res;
    let data;

    try {
        res = await fetch(scanUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                Accept: 'application/json',
            },
            body: JSON.stringify({ url, confirm }),
        });
    } catch (err) {
        showCard('error', `Network error: ${err.message}`);
        resumeAfterDelay();
        return;
    }

    const rawBody = await res.text();
    try {
        data = JSON.parse(rawBody);
    } catch {
        // The server returned something that isn't JSON (an HTML error page,
        // a redirect to the login screen, etc.) — surface the HTTP status and
        // a snippet of the body instead of a silent/generic failure so the
        // real cause is visible on the device during a live scan.
        showCard('error', `Scan failed (HTTP ${res.status}). ${rawBody.slice(0, 120)}`);
        resumeAfterDelay();
        return;
    }

    if (!res.ok) {
        showCard('error', data.error || data.message || `Scan failed (HTTP ${res.status}).`);
        resumeAfterDelay();
        return;
    }

    if (data.duplicate) {
        showDuplicateCard(url, data);
        return;
    }

    showCard('success', `${data.name}${data.company ? ' — ' + data.company : ''} (${data.type_label})`);
    resumeAfterDelay();
}

function resumeAfterDelay() {
    setTimeout(() => {
        hideCard();
        scanning = true;
    }, 2000);
}

function showCard(kind, message) {
    statusEl.hidden = false;
    statusEl.className = `status-card ${kind}`;
    statusEl.innerHTML = `<p>${message}</p>`;
}

function showDuplicateCard(url, data) {
    statusEl.hidden = false;
    statusEl.className = 'status-card warning';
    statusEl.innerHTML = `
        <p>Already scanned by ${data.employee} at ${data.scanned_at}</p>
        <button type="button" id="scan-anyway">Scan anyway</button>
        <button type="button" id="scan-dismiss">Dismiss</button>
    `;
    document.getElementById('scan-anyway').addEventListener('click', () => submitScan(url, true));
    document.getElementById('scan-dismiss').addEventListener('click', () => {
        hideCard();
        scanning = true;
    });
}

function hideCard() {
    statusEl.hidden = true;
    statusEl.innerHTML = '';
}

startCamera();

// --- Manual check-in ---

const manualModal = document.getElementById('manual-modal');
const manualOpenBtn = document.getElementById('manual-open');
const manualCloseBtn = document.getElementById('manual-close');
const tabSearch = document.getElementById('tab-search');
const tabRegister = document.getElementById('tab-register');
const panelSearch = document.getElementById('panel-search');
const panelRegister = document.getElementById('panel-register');
const manualSearchInput = document.getElementById('manual-search-input');
const manualResults = document.getElementById('manual-results');
const manualError = document.getElementById('manual-error');

let searchDebounce = null;

function openManualModal() {
    scanning = false;
    manualModal.hidden = false;
    manualError.hidden = true;
    manualSearchInput.value = '';
    manualResults.innerHTML = '';
    manualSearchInput.focus();
}

function closeManualModal() {
    manualModal.hidden = true;
    scanning = true;
}

function switchTab(tab) {
    const isSearch = tab === 'search';
    tabSearch.classList.toggle('active', isSearch);
    tabRegister.classList.toggle('active', !isSearch);
    panelSearch.hidden = !isSearch;
    panelRegister.hidden = isSearch;
    manualError.hidden = true;
}

manualOpenBtn.addEventListener('click', openManualModal);
manualCloseBtn.addEventListener('click', closeManualModal);
tabSearch.addEventListener('click', () => switchTab('search'));
tabRegister.addEventListener('click', () => switchTab('register'));

manualSearchInput.addEventListener('input', () => {
    clearTimeout(searchDebounce);
    const q = manualSearchInput.value.trim();

    if (q.length < 2) {
        manualResults.innerHTML = '';
        return;
    }

    searchDebounce = setTimeout(() => runSearch(q), 300);
});

async function runSearch(q) {
    let res;
    let data;

    try {
        res = await fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
            headers: { Accept: 'application/json' },
        });
        data = await res.json();
    } catch (err) {
        showManualError(`Search failed: ${err.message}`);
        return;
    }

    if (!res.ok) {
        showManualError(data.error || `Search failed (HTTP ${res.status}).`);
        return;
    }

    renderResults(data.results || []);
}

function renderResults(results) {
    if (results.length === 0) {
        manualResults.innerHTML = '<p class="meta">No matches.</p>';
        return;
    }

    manualResults.innerHTML = results.map((r, i) => `
        <div class="manual-result" data-index="${i}">
            <div class="name">${r.name}</div>
            <div class="meta">${r.phone || ''} ${r.email ? '· ' + r.email : ''} · ${r.type}</div>
        </div>
    `).join('');

    manualResults.querySelectorAll('.manual-result').forEach((el) => {
        el.addEventListener('click', () => {
            const r = results[Number(el.dataset.index)];
            submitManualCheckIn(r.type, r.id, false);
        });
    });
}

async function submitManualCheckIn(type, id, confirm) {
    let res;
    let data;

    try {
        res = await fetch(`${checkInUrlBase}/${type}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                Accept: 'application/json',
            },
            body: JSON.stringify({ confirm }),
        });
        data = await res.json();
    } catch (err) {
        showManualError(`Check-in failed: ${err.message}`);
        return;
    }

    if (!res.ok) {
        showManualError(data.error || `Check-in failed (HTTP ${res.status}).`);
        return;
    }

    if (data.duplicate) {
        const ok = window.confirm(`Already scanned by ${data.employee} at ${data.scanned_at}. Check in anyway?`);
        if (ok) {
            submitManualCheckIn(type, id, true);
        }
        return;
    }

    closeManualModal();
    showCard('success', `${data.name}${data.company ? ' — ' + data.company : ''} (${data.type_label})`);
    resumeAfterDelay();
}

panelRegister.addEventListener('submit', async (e) => {
    e.preventDefault();
    manualError.hidden = true;

    const formData = new FormData(panelRegister);
    const payload = Object.fromEntries(formData.entries());

    let res;
    let data;

    try {
        res = await fetch(registerUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                Accept: 'application/json',
            },
            body: JSON.stringify(payload),
        });
        data = await res.json();
    } catch (err) {
        showManualError(`Registration failed: ${err.message}`);
        return;
    }

    if (!res.ok) {
        const message = data.errors
            ? Object.values(data.errors).flat().join(' ')
            : (data.error || data.message || `Registration failed (HTTP ${res.status}).`);
        showManualError(message);
        return;
    }

    closeManualModal();
    showCard('success', `${data.name}${data.company ? ' — ' + data.company : ''} (${data.type_label})`);
    resumeAfterDelay();
    panelRegister.reset();
});

function showManualError(message) {
    manualError.hidden = false;
    manualError.textContent = message;
}
