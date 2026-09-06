import jsQR from 'jsqr';

const video = document.getElementById('scan-video');
const canvas = document.getElementById('scan-canvas');
const ctx = canvas.getContext('2d', { willReadFrequently: true });
const statusEl = document.getElementById('scan-status');
const cameraErrorEl = document.getElementById('camera-error');

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
    const res = await fetch('/portal/scan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            Accept: 'application/json',
        },
        body: JSON.stringify({ url, confirm }),
    });
    const data = await res.json();

    if (!res.ok) {
        showCard('error', data.error || 'Scan failed.');
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
