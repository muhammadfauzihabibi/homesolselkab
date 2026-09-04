<!-- Accessibility Widget Component (Circular Trigger & Reactive Light/Dark Mode) -->
<div id="accessibility-widget" class="accessibility-widget-wrapper">
  <!-- Circular Floating Trigger Button -->
  <button id="access-widget-toggle" class="access-widget-trigger shadow-lg rounded-circle" title="Alat Aksesibilitas / Accessibility Tools" aria-label="Alat Aksesibilitas">
    <i class="bi bi-universal-access fs-3"></i>
  </button>

  <!-- Panel Overlay (Slides from Right) -->
  <div id="access-widget-panel" class="access-widget-panel shadow-lg rounded-4">
    <!-- Panel Header -->
    <div class="access-panel-header d-flex align-items-center justify-content-between p-3 border-bottom">
      <div class="d-flex align-items-center gap-2">
        <div class="app-icon-badge rounded-3 d-flex align-items-center justify-content-center">
          <i class="bi bi-universal-access fs-5 text-primary"></i>
        </div>
        <h6 class="fw-bold mb-0 access-title-text">Alat Aksesibilitas</h6>
      </div>
      <button type="button" id="access-widget-close" class="btn-close fs-7" aria-label="Tutup"></button>
    </div>

    <!-- Panel Body / Controls -->
    <div class="access-panel-body p-3">
      
      <!-- 1. Text Zoom Controls -->
      <div class="access-control-group mb-3 pb-3 border-bottom">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="fs-7 fw-semibold access-label-text">Ukuran Teks</span>
          <span id="text-size-indicator" class="badge bg-primary text-white rounded-pill px-2.5 py-1 fs-8 fw-bold">100%</span>
        </div>
        <div class="d-flex gap-2">
          <button type="button" id="btn-increase-text" class="access-btn w-50 py-2 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-zoom-in"></i> <span>Perbesar</span>
          </button>
          <button type="button" id="btn-decrease-text" class="access-btn w-50 py-2 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-zoom-out"></i> <span>Perkecil</span>
          </button>
        </div>
        <small class="opacity-75 fs-8 d-block mt-1 text-center">(Batas: 70% - 150%)</small>
      </div>

      <!-- 2. Font Family Selection -->
      <div class="access-control-group mb-3 pb-3 border-bottom">
        <label for="access-font-select" class="form-label fs-7 fw-semibold mb-1 access-label-text">
          <i class="bi bi-fonts me-1 text-primary"></i> Jenis Font
        </label>
        <select id="access-font-select" class="form-select form-select-sm fs-7 rounded-3 access-font-dropdown">
          <option value="default">Default (Plus Jakarta Sans)</option>
          <option value="readable">Readable / Dyslexic Friendly</option>
          <option value="serif">Serif (Formal / Merriweather)</option>
          <option value="monospace">Monospace (Ketik / Code)</option>
          <option value="sans-serif">Sans-Serif Standard (Arial)</option>
        </select>
      </div>

      <!-- 3. Visual Toggles -->
      <div class="access-control-group mb-3 pb-3 border-bottom d-flex flex-column gap-2">
        
        <!-- Grayscale -->
        <button type="button" id="btn-toggle-grayscale" class="access-toggle-btn w-100 py-2 px-3 d-flex align-items-center justify-content-between">
          <span class="d-flex align-items-center gap-2">
            <i class="bi bi-circle-half text-primary"></i> <span>Skala Abu-abu (Grayscale)</span>
          </span>
          <i class="bi bi-check-circle-fill toggle-icon fs-6"></i>
        </button>

        <!-- Negative / High Contrast -->
        <button type="button" id="btn-toggle-contrast" class="access-toggle-btn w-100 py-2 px-3 d-flex align-items-center justify-content-between">
          <span class="d-flex align-items-center gap-2">
            <i class="bi bi-eye-fill text-primary"></i> <span>Kontras Tinggi (High Contrast)</span>
          </span>
          <i class="bi bi-check-circle-fill toggle-icon fs-6"></i>
        </button>

        <!-- Links Underline -->
        <button type="button" id="btn-toggle-underline" class="access-toggle-btn w-100 py-2 px-3 d-flex align-items-center justify-content-between">
          <span class="d-flex align-items-center gap-2">
            <i class="bi bi-link-45deg text-primary"></i> <span>Garis Bawah Tautan</span>
          </span>
          <i class="bi bi-check-circle-fill toggle-icon fs-6"></i>
        </button>

        <!-- Text to Speech -->
        <button type="button" id="btn-toggle-tts" class="access-toggle-btn w-100 py-2 px-3 d-flex align-items-center justify-content-between">
          <span class="d-flex align-items-center gap-2">
            <i class="bi bi-volume-up-fill text-primary"></i> <span>Pembaca Suara (Text to Speech)</span>
          </span>
          <i class="bi bi-check-circle-fill toggle-icon fs-6"></i>
        </button>
      </div>

      <!-- 4. Reset Button -->
      <button type="button" id="btn-reset-access" class="access-reset-btn w-100 py-2 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-arrow-counterclockwise"></i> <span>Reset Ulang Pengaturan</span>
      </button>

    </div>
  </div>
</div>

<style>
  /* Accessibility Widget Styles - Circular Button & Theme Reactive */
  .accessibility-widget-wrapper {
    position: fixed;
    top: 200px;
    right: 20px;
    z-index: 99999;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  /* Circular Trigger Button */
  .access-widget-trigger {
    width: 52px;
    height: 52px;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #0284c7;
    color: #ffffff;
    border: 2px solid #ffffff;
    box-shadow: 0 8px 25px rgba(2, 132, 199, 0.4);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .access-widget-trigger:hover {
    transform: scale(1.08);
    background: #0369a1;
    box-shadow: 0 12px 30px rgba(2, 132, 199, 0.5);
  }

  /* Flyout Panel Base */
  .access-widget-panel {
    position: fixed;
    top: 190px;
    right: -360px;
    width: 320px;
    max-height: calc(100vh - 210px);
    overflow-y: auto;
    transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 99998;
    scrollbar-width: thin;
  }

  .access-widget-panel.show {
    right: 80px;
  }

  @media (max-width: 576px) {
    .accessibility-widget-wrapper {
      right: 12px;
    }
    .access-widget-panel {
      width: 290px;
    }
    .access-widget-panel.show {
      right: 70px;
    }
  }

  /* --- LIGHT MODE THEME (DEFAULT) --- */
  .access-widget-panel {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(0, 0, 0, 0.08);
    color: #0f172a;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
  }

  .access-widget-panel .border-bottom {
    border-bottom-color: rgba(0, 0, 0, 0.08) !important;
  }

  .access-widget-panel .app-icon-badge {
    width: 32px;
    height: 32px;
    background: rgba(2, 132, 199, 0.12);
  }

  .access-widget-panel .access-btn {
    background: rgba(0, 0, 0, 0.04);
    color: #0f172a;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    font-size: 0.825rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .access-widget-panel .access-btn:hover:not(:disabled) {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
  }

  .access-widget-panel .access-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
  }

  .access-widget-panel .access-font-dropdown {
    background-color: #f8fafc;
    color: #0f172a;
    border-color: rgba(0, 0, 0, 0.15);
  }

  .access-widget-panel .access-toggle-btn {
    background: rgba(0, 0, 0, 0.03);
    color: #0f172a;
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
    font-size: 0.825rem;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: all 0.2s ease;
  }

  .access-widget-panel .access-toggle-btn:hover {
    background: rgba(0, 0, 0, 0.06);
    border-color: rgba(0, 0, 0, 0.18);
  }

  .access-widget-panel .access-toggle-btn .toggle-icon {
    opacity: 0.25;
    color: #0f172a;
    transition: all 0.2s ease;
  }

  .access-widget-panel .access-toggle-btn.active {
    background: rgba(2, 132, 199, 0.12);
    border-color: #0284c7;
    color: #0284c7;
  }

  .access-widget-panel .access-toggle-btn.active .toggle-icon {
    opacity: 1;
    color: #0284c7;
  }

  .access-widget-panel .access-reset-btn {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .access-widget-panel .access-reset-btn:hover {
    background: #ef4444;
    color: #ffffff;
    border-color: #ef4444;
  }

  /* --- DARK MODE OVERRIDES ([data-bs-theme="dark"]) --- */
  [data-bs-theme="dark"] .access-widget-trigger {
    background: #38bdf8;
    color: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 8px 25px rgba(56, 189, 248, 0.35);
  }

  [data-bs-theme="dark"] .access-widget-trigger:hover {
    background: #7dd3fc;
  }

  [data-bs-theme="dark"] .access-widget-panel {
    background: rgba(15, 23, 42, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #f8fafc;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
  }

  [data-bs-theme="dark"] .access-widget-panel .border-bottom {
    border-bottom-color: rgba(255, 255, 255, 0.1) !important;
  }

  [data-bs-theme="dark"] .access-widget-panel .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
  }

  [data-bs-theme="dark"] .access-widget-panel .app-icon-badge {
    background: rgba(56, 189, 248, 0.15);
  }

  [data-bs-theme="dark"] .access-widget-panel .app-icon-badge i,
  [data-bs-theme="dark"] .access-widget-panel .bi-fonts,
  [data-bs-theme="dark"] .access-widget-panel .bi-circle-half,
  [data-bs-theme="dark"] .access-widget-panel .bi-eye-fill,
  [data-bs-theme="dark"] .access-widget-panel .bi-link-45deg,
  [data-bs-theme="dark"] .access-widget-panel .bi-volume-up-fill {
    color: #38bdf8 !important;
  }

  [data-bs-theme="dark"] .access-widget-panel .access-btn {
    background: rgba(255, 255, 255, 0.08);
    color: #f8fafc;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  [data-bs-theme="dark"] .access-widget-panel .access-btn:hover:not(:disabled) {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
  }

  [data-bs-theme="dark"] .access-widget-panel .access-font-dropdown {
    background-color: #1e293b;
    color: #f8fafc;
    border-color: rgba(255, 255, 255, 0.2);
  }

  [data-bs-theme="dark"] .access-widget-panel .access-toggle-btn {
    background: rgba(255, 255, 255, 0.06);
    color: #f8fafc;
    border: 1px solid rgba(255, 255, 255, 0.12);
  }

  [data-bs-theme="dark"] .access-widget-panel .access-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.14);
    border-color: rgba(255, 255, 255, 0.25);
  }

  [data-bs-theme="dark"] .access-widget-panel .access-toggle-btn .toggle-icon {
    opacity: 0.25;
    color: #ffffff;
  }

  [data-bs-theme="dark"] .access-widget-panel .access-toggle-btn.active {
    background: rgba(56, 189, 248, 0.2);
    border-color: #38bdf8;
    color: #38bdf8;
  }

  [data-bs-theme="dark"] .access-widget-panel .access-toggle-btn.active .toggle-icon {
    opacity: 1;
    color: #38bdf8;
  }

  [data-bs-theme="dark"] .access-widget-panel .access-reset-btn {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.35);
  }

  /* --- GLOBAL ACCESSIBILITY MODIFIERS --- */
  html.access-grayscale {
    filter: grayscale(100%) !important;
  }

  html.access-high-contrast {
    filter: invert(100%) hue-rotate(180deg) !important;
  }

  html.access-high-contrast img,
  html.access-high-contrast video,
  html.access-high-contrast iframe,
  html.access-high-contrast .hero-bg-backdrop {
    filter: invert(100%) hue-rotate(180deg) !important;
  }

  html.access-underline-links a {
    text-decoration: underline !important;
    text-decoration-thickness: 2px !important;
  }

  /* Fonts Override */
  html.access-font-readable body,
  html.access-font-readable p,
  html.access-font-readable span,
  html.access-font-readable a,
  html.access-font-readable h1,
  html.access-font-readable h2,
  html.access-font-readable h3,
  html.access-font-readable h4,
  html.access-font-readable h5,
  html.access-font-readable h6 {
    font-family: 'Trebuchet MS', 'Comic Sans MS', Arial, sans-serif !important;
  }

  html.access-font-serif body,
  html.access-font-serif p,
  html.access-font-serif span,
  html.access-font-serif a,
  html.access-font-serif h1,
  html.access-font-serif h2,
  html.access-font-serif h3,
  html.access-font-serif h4,
  html.access-font-serif h5,
  html.access-font-serif h6 {
    font-family: 'Merriweather', 'Georgia', 'Times New Roman', serif !important;
  }

  html.access-font-monospace body,
  html.access-font-monospace p,
  html.access-font-monospace span,
  html.access-font-monospace a,
  html.access-font-monospace h1,
  html.access-font-monospace h2,
  html.access-font-monospace h3,
  html.access-font-monospace h4,
  html.access-font-monospace h5,
  html.access-font-monospace h6 {
    font-family: 'Consolas', 'Courier New', monospace !important;
  }

  html.access-font-sans-serif body,
  html.access-font-sans-serif p,
  html.access-font-sans-serif span,
  html.access-font-sans-serif a,
  html.access-font-sans-serif h1,
  html.access-font-sans-serif h2,
  html.access-font-sans-serif h3,
  html.access-font-sans-serif h4,
  html.access-font-sans-serif h5,
  html.access-font-sans-serif h6 {
    font-family: Arial, Helvetica, sans-serif !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // --- 1. STATE & CONSTANTS ---
    const MIN_ZOOM = 70;  // Batas Minimal perkecil (70%)
    const MAX_ZOOM = 150; // Batas Maksimal perbesar (150%)
    const ZOOM_STEP = 10; // Setiap klik bertambah/berkurang 10%

    let currentZoom = parseInt(localStorage.getItem('access_zoom') || '100');
    let currentFont = localStorage.getItem('access_font') || 'default';
    let isGrayscale = localStorage.getItem('access_grayscale') === 'true';
    let isContrast = localStorage.getItem('access_contrast') === 'true';
    let isUnderline = localStorage.getItem('access_underline') === 'true';
    let isTTS = localStorage.getItem('access_tts') === 'true';

    // --- 2. DOM ELEMENTS ---
    const toggleTrigger = document.getElementById('access-widget-toggle');
    const closeBtn = document.getElementById('access-widget-close');
    const panel = document.getElementById('access-widget-panel');

    const btnIncrease = document.getElementById('btn-increase-text');
    const btnDecrease = document.getElementById('btn-decrease-text');
    const zoomIndicator = document.getElementById('text-size-indicator');

    const fontSelect = document.getElementById('access-font-select');

    const btnGrayscale = document.getElementById('btn-toggle-grayscale');
    const btnContrast = document.getElementById('btn-toggle-contrast');
    const btnUnderline = document.getElementById('btn-toggle-underline');
    const btnTTS = document.getElementById('btn-toggle-tts');
    const btnReset = document.getElementById('btn-reset-access');

    // --- 3. TOGGLE PANEL SHOW/HIDE ---
    toggleTrigger.addEventListener('click', () => {
      panel.classList.toggle('show');
    });

    closeBtn.addEventListener('click', () => {
      panel.classList.remove('show');
    });

    document.addEventListener('click', (e) => {
      if (!panel.contains(e.target) && !toggleTrigger.contains(e.target)) {
        panel.classList.remove('show');
      }
    });

    // --- 4. TEXT ZOOM CONTROLLER WITH MIN/MAX LIMITS ---
    const applyZoom = (zoom) => {
      currentZoom = Math.min(MAX_ZOOM, Math.max(MIN_ZOOM, zoom));
      document.documentElement.style.fontSize = `${currentZoom}%`;
      zoomIndicator.textContent = `${currentZoom}%`;
      localStorage.setItem('access_zoom', currentZoom);

      btnIncrease.disabled = currentZoom >= MAX_ZOOM;
      btnDecrease.disabled = currentZoom <= MIN_ZOOM;
    };

    btnIncrease.addEventListener('click', () => {
      if (currentZoom < MAX_ZOOM) {
        applyZoom(currentZoom + ZOOM_STEP);
      }
    });

    btnDecrease.addEventListener('click', () => {
      if (currentZoom > MIN_ZOOM) {
        applyZoom(currentZoom - ZOOM_STEP);
      }
    });

    // --- 5. FONT FAMILY SWITCHER ---
    const applyFont = (font) => {
      currentFont = font;
      document.documentElement.classList.remove(
        'access-font-readable',
        'access-font-serif',
        'access-font-monospace',
        'access-font-sans-serif'
      );

      if (font !== 'default') {
        document.documentElement.classList.add(`access-font-${font}`);
      }

      fontSelect.value = font;
      localStorage.setItem('access_font', font);
    };

    fontSelect.addEventListener('change', (e) => {
      applyFont(e.target.value);
    });

    // --- 6. VISUAL TOGGLES (GRAYSCALE, CONTRAST, UNDERLINE) ---
    const applyGrayscale = (active) => {
      isGrayscale = active;
      document.documentElement.classList.toggle('access-grayscale', active);
      btnGrayscale.classList.toggle('active', active);
      localStorage.setItem('access_grayscale', active);
    };

    btnGrayscale.addEventListener('click', () => {
      applyGrayscale(!isGrayscale);
    });

    const applyContrast = (active) => {
      isContrast = active;
      document.documentElement.classList.toggle('access-high-contrast', active);
      btnContrast.classList.toggle('active', active);
      localStorage.setItem('access_contrast', active);
    };

    btnContrast.addEventListener('click', () => {
      applyContrast(!isContrast);
    });

    const applyUnderline = (active) => {
      isUnderline = active;
      document.documentElement.classList.toggle('access-underline-links', active);
      btnUnderline.classList.toggle('active', active);
      localStorage.setItem('access_underline', active);
    };

    btnUnderline.addEventListener('click', () => {
      applyUnderline(!isUnderline);
    });

    // --- 7. TEXT TO SPEECH (WEB SPEECH SYNTHESIS API) ---
    let speechHandler = null;

    const applyTTS = (active) => {
      isTTS = active;
      btnTTS.classList.toggle('active', active);
      localStorage.setItem('access_tts', active);

      if (active) {
        if ('speechSynthesis' in window) {
          const speakText = (text) => {
            if (!text || text.trim() === '') return;
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 1;
            window.speechSynthesis.speak(utterance);
          };

          speechHandler = (e) => {
            const targetText = e.target.innerText || e.target.alt || e.target.title;
            if (targetText && isTTS) {
              speakText(targetText.substring(0, 150));
            }
          };

          document.body.addEventListener('click', speechHandler);
          speakText('Pembaca suara diaktifkan');
        } else {
          alert('Perangkat Anda tidak mendukung fitur Text to Speech.');
        }
      } else {
        if ('speechSynthesis' in window) {
          window.speechSynthesis.cancel();
        }
        if (speechHandler) {
          document.body.removeEventListener('click', speechHandler);
        }
      }
    };

    btnTTS.addEventListener('click', () => {
      applyTTS(!isTTS);
    });

    // --- 8. RESET ALL SETTINGS ---
    btnReset.addEventListener('click', () => {
      applyZoom(100);
      applyFont('default');
      applyGrayscale(false);
      applyContrast(false);
      applyUnderline(false);
      applyTTS(false);

      localStorage.clear();
    });

    // --- 9. INITIALIZE PREFERENCES ON LOAD ---
    applyZoom(currentZoom);
    applyFont(currentFont);
    applyGrayscale(isGrayscale);
    applyContrast(isContrast);
    applyUnderline(isUnderline);
    applyTTS(isTTS);
  });
</script>