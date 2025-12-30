@php
$copy = [
    'title' => 'Hall Map',
    'selected' => 'Selected space:',
    'hint' => 'Click any booth (L.W.* / R.W.*). Press D for debug boxes.',
    'openConfirmTitle' => 'Confirm selection',
    'spaceLabel' => 'Space:',
    'cancel' => 'Cancel',
    'confirm' => 'Confirm & return',
];
@endphp
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $copy['title'] }}</title>
  <style>
    body {
      margin: 0;
      font-family: system-ui, Segoe UI, Roboto, Arial;
      background: #f6f7f9;
    }

    .wrap {
      max-width: 1080px;
      margin: 24px auto;
      padding: 0 14px;
    }

    .hidden {
      display: none;
    }

    .card {
      background: #fff;
      border: 1px solid #e6e8ee;
      border-radius: 14px;
      box-shadow: 0 8px 22px rgba(0, 0, 0, .06);
      padding: 16px;
    }

    .topbar {
      display: flex;
      gap: 12px;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 12px;
    }

    .pill {
      display: inline-flex;
      text-align: center;
      gap: 8px;
      padding: 8px 10px;
      border-radius: 999px;
      background: #f2f4f8;
      border: 1px solid #e6e8ee;
      font-size: 14px;
    }

    .pill strong {
      font-weight: 800;
    }

    .hint {
      color: #4b5563;
      font-size: 13px;
    }

    .plan {
      position: relative;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #e6e8ee;
      background: #fff;
    }

    .plan img {
      display: block;
      width: 100%;
      height: auto;
      user-select: none;
      -webkit-user-drag: none;
    }

    .overlay {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
    }

    .hitbox {
      fill: rgba(255, 200, 0, 0.0);
      stroke: rgba(255, 200, 0, 0.0);
      cursor: pointer;
    }

    .hitbox:hover {
      fill: rgba(255, 200, 0, 0.22);
      stroke: rgba(255, 200, 0, 0.55);
      stroke-width: 2;
    }

    .hitbox.selected {
      fill: rgba(255, 140, 0, 0.25);
      stroke: rgba(255, 140, 0, 0.9);
      stroke-width: 3;
    }

    .hitbox.occupied {
      fill: rgba(239, 68, 68, 0.35);
      stroke: rgba(220, 38, 38, 0.95);
      stroke-width: 3;
      cursor: not-allowed;
    }

    .debug .hitbox {
      fill: rgba(0, 150, 255, 0.10);
      stroke: rgba(0, 150, 255, 0.7);
      stroke-width: 1.5;
    }

    .modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      z-index: 50;
    }

    .modal {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
      max-width: 420px;
      width: 100%;
      padding: 20px;
      border: 1px solid #e5e7eb;
      text-align: center;
    }

    .modal-backdrop.hidden {
      display: none !important;
    }

    .modal h3 {
      margin: 0 0 8px;
      font-size: 18px;
      color: #111827;
    }

    .modal p {
      margin: 0 0 16px;
      color: #4b5563;
      font-size: 14px;
    }

    .modal-actions {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn {
      padding: 10px 14px;
      border-radius: 10px;
      border: 1px solid #d1d5db;
      background: #f9fafb;
      cursor: pointer;
      font-weight: 600;
    }

    .btn-primary {
      background: #0f9f6e;
      color: #fff;
      border-color: #0f9f6e;
    }

    .btn:hover {
      filter: brightness(0.98);
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="card">
      <div class="topbar">
        <div class="pill">{{ $copy['selected'] }} <strong id="selectedSpace">—</strong></div>
        <div class="hint">{{ $copy['hint'] }}</div>
      </div>

      <div id="plan" class="plan">
        <img src="{{ asset('img/hall-design.png') }}" alt="Hall Layout">
        <svg id="overlay" class="overlay" viewBox="0 0 3490 6294" preserveAspectRatio="xMidYMid meet"></svg>
      </div>
    </div>
  </div>

  <div id="confirmModal" class="modal-backdrop hidden" aria-hidden="true">
    <div class="modal">
      <h3>{{ $copy['openConfirmTitle'] }}</h3>
      <p>{{ $copy['spaceLabel'] }} <strong id="confirmName">—</strong></p>
      <div class="modal-actions">
        <button type="button" class="btn" id="cancelConfirm">{{ $copy['cancel'] }}</button>
        <button type="button" class="btn btn-primary" id="confirmSelection">{{ $copy['confirm'] }}</button>
      </div>
    </div>
  </div>

  <script>
    // Geometry is measured in PDF pixels (base 1653 x 2339).
    const overlay = document.getElementById("overlay");
    const mapImage = document.querySelector("#plan img");
    const CALIBRATION_URL = "{{ asset('hall-calibration.json') }}";
    const BASE_HEIGHT = 2339;
    let MAP_WIDTH = 3490;
    let MAP_HEIGHT = 6294;
    let SCALE_Y = MAP_HEIGHT / BASE_HEIGHT;
    const X_SCALE = 2.7866;
    const X_OFFSET = -555.3;
    const Y_OFFSET = -25;
    let useCalibrationCoords = false;
    overlay.setAttribute("viewBox", `0 0 ${MAP_WIDTH} ${MAP_HEIGHT}`);
    const selectedSpaceEl = document.getElementById("selectedSpace");
    const planEl = document.getElementById("plan");
    const confirmModal = document.getElementById("confirmModal");
    const confirmName = document.getElementById("confirmName");
    const confirmSelectionBtn = document.getElementById("confirmSelection");
    const cancelConfirmBtn = document.getElementById("cancelConfirm");
    const occupiedSpaces = new Set(@json($occupiedSpaces ?? []));

    let selectedEl = null;
    let pendingSpace = null;
    hideConfirmModal();

    function selectSpace(name, el) {
      selectedSpaceEl.textContent = name;
      pendingSpace = name;

      if (selectedEl) selectedEl.classList.remove("selected");
      selectedEl = el;
      if (selectedEl) selectedEl.classList.add("selected");

      if (typeof window.onSpaceClick === "function") window.onSpaceClick(name);
      showConfirmModal(name);
    }

    function showConfirmModal(name) {
      confirmName.textContent = name;
      confirmModal.classList.remove("hidden");
      confirmModal.style.display = 'flex';
      confirmModal.setAttribute('aria-hidden', 'false');
    }

    function hideConfirmModal() {
      confirmModal.classList.add("hidden");
      confirmModal.style.display = 'none';
      confirmModal.setAttribute('aria-hidden', 'true');
    }

    confirmSelectionBtn.addEventListener('click', () => {
      if (!pendingSpace) {
        hideConfirmModal();
        return;
      }
      const payload = { type: 'hall-selection', space: pendingSpace };
      const origin = window.location.origin;

      if (window.opener && !window.opener.closed) {
        try {
          window.opener.postMessage(payload, origin);
          window.opener.focus();
        } catch (e) {}
        try {
          window.close();
          return;
        } catch (e) {}
      }

      const params = new URLSearchParams(window.location.search || '');
      const locale = params.get('locale') || 'en';
      const landingUrl = `/${encodeURIComponent(locale)}?hall_space=${encodeURIComponent(pendingSpace)}&hall_target=icon`;
      window.location.assign(landingUrl);
    });

    cancelConfirmBtn.addEventListener('click', () => hideConfirmModal());

    function svgEl(tag, attrs = {}, parent = overlay) {
      const el = document.createElementNS("http://www.w3.org/2000/svg", tag);
      for (const [k, v] of Object.entries(attrs)) el.setAttribute(k, v);
      parent.appendChild(el);
      return el;
    }

    function addHitbox({ name, x, y, w, h }) {
      const scaledX = useCalibrationCoords ? x : (x * X_SCALE) + X_OFFSET;
      const scaledY = useCalibrationCoords ? y : (y * SCALE_Y) + Y_OFFSET;
      const scaledW = useCalibrationCoords ? w : w * X_SCALE;
      const scaledH = useCalibrationCoords ? h : h * SCALE_Y;
      const isOccupied = occupiedSpaces.has(name);
      const classes = ["hitbox"];
      if (isOccupied) {
        classes.push("occupied");
      }
      const r = svgEl("rect", {
        x: scaledX,
        y: scaledY,
        width: scaledW,
        height: scaledH,
        class: classes.join(" "),
        "data-name": name
      });
      if (!isOccupied) {
        r.addEventListener("click", () => selectSpace(name, r));
      } else {
        r.style.pointerEvents = 'none';
      }
      return r;
    }

    function generateAisle({
      prefix,
      lowStart,
      highStart,
      lowOnRight,
      x0,
      yStart = 365,
      clusters = 14,
      cellW = 59,
      topH = 39,
      bottomH = 40,
      gapY = 40
    }) {
      const clusterStep = topH + bottomH + gapY;

      for (let rowIndex = 0; rowIndex < clusters; rowIndex++) {
        const i = (clusters - 1) - rowIndex;
        const y0 = yStart + rowIndex * clusterStep;

        const lowBottom = lowStart + (2 * i);
        const lowTop = lowStart + (2 * i) + 1;
        const highBottom = highStart + (2 * i);
        const highTop = highStart + (2 * i) + 1;

        const TL = lowOnRight ? `${prefix}${highTop}` : `${prefix}${lowTop}`;
        const TR = lowOnRight ? `${prefix}${lowTop}` : `${prefix}${highTop}`;
        const BL = lowOnRight ? `${prefix}${highBottom}` : `${prefix}${lowBottom}`;
        const BR = lowOnRight ? `${prefix}${lowBottom}` : `${prefix}${highBottom}`;

        addHitbox({ name: TL, x: x0, y: y0, w: cellW, h: topH });
        addHitbox({ name: TR, x: x0 + cellW, y: y0, w: cellW, h: topH });
        addHitbox({ name: BL, x: x0, y: y0 + topH, w: cellW, h: bottomH });
        addHitbox({ name: BR, x: x0 + cellW, y: y0 + topH, w: cellW, h: bottomH });
      }
    }

    async function fetchCalibrationRects() {
      try {
        const response = await fetch(CALIBRATION_URL, { cache: 'no-store' });
        if (!response.ok) return [];
        const data = await response.json();
        if (!Array.isArray(data)) return [];
        return data.filter(rect =>
          rect &&
          typeof rect.name === "string" &&
          ["x", "y", "w", "h"].every(k => typeof rect[k] === "number")
        );
      } catch (error) {
        return [];
      }
    }

    function renderProceduralGrid() {
      generateAisle({
        prefix: "L.W.",
        lowStart: 57,
        highStart: 85,
        lowOnRight: true,
        x0: 392
      });

      generateAisle({
        prefix: "L.W.",
        lowStart: 1,
        highStart: 29,
        lowOnRight: true,
        x0: 569
      });

      generateAisle({
        prefix: "R.W.",
        lowStart: 1,
        highStart: 29,
        lowOnRight: false,
        x0: 963
      });

      generateAisle({
        prefix: "R.W.",
        lowStart: 57,
        highStart: 85,
        lowOnRight: false,
        x0: 1140
      });
    }

    async function initOverlay() {
      if (mapImage && mapImage.complete && mapImage.naturalWidth) {
        MAP_WIDTH = mapImage.naturalWidth;
        MAP_HEIGHT = mapImage.naturalHeight;
      }
      SCALE_Y = MAP_HEIGHT / BASE_HEIGHT;
      overlay.setAttribute("viewBox", `0 0 ${MAP_WIDTH} ${MAP_HEIGHT}`);
      const calibrationRects = await fetchCalibrationRects();
      if (calibrationRects.length) {
        useCalibrationCoords = true;
        SCALE_X = 1;
        SCALE_Y = 1;
        calibrationRects.forEach(rect => addHitbox(rect));
      } else {
        useCalibrationCoords = false;
        renderProceduralGrid();
      }
    }

    window.addEventListener("load", initOverlay);
    if (mapImage) {
      mapImage.addEventListener("load", initOverlay, { once: true });
    }

    window.addEventListener("keydown", (e) => {
      if (e.key.toLowerCase() === "d") planEl.classList.toggle("debug");
    });
  </script>
</body>

</html>
