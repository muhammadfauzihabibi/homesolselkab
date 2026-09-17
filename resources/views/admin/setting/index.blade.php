@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
@php
    // Ambil data hero images dari controller
    $heroImages = $heroImages ?? [];

    // Tautan media sosial
    $sosmedLinks = $sosmedLinks ?? [];

    // Daftar ikon sosial media yang didukung
    $sosmedIcons = [
        'bi-facebook'    => 'Facebook',
        'bi-instagram'   => 'Instagram',
        'bi-youtube'     => 'YouTube',
        'bi-twitter-x'   => 'X (Twitter)',
        'bi-tiktok'      => 'TikTok',
        'bi-linkedin'    => 'LinkedIn',
        'bi-whatsapp'    => 'WhatsApp',
        'bi-telegram'    => 'Telegram',
        'bi-threads'     => 'Threads',
        'bi-snapchat'    => 'Snapchat',
        'bi-pinterest'   => 'Pinterest',
        'bi-spotify'     => 'Spotify',
        'bi-github'      => 'GitHub',
        'bi-globe'       => 'Website Resmi',
    ];
@endphp

<!-- Header Page Title -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h1 class="admin-page-title mb-0">Pengaturan Website</h1>
            <span class="badge badge-solsel fs-8">Konfigurasi</span>
        </div>
        <p class="admin-page-subtitle">Kelola tampilan latar hero, tautan media sosial, teks berjalan, dan kontak footer.</p>
    </div>
</div>

<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingForm">
    @csrf

    {{-- ============================================= --}}
    {{-- 1. GAMBAR LATAR HERO (Maksimal 4 Slot)        --}}
    {{-- ============================================= --}}
    <div class="glass-card p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
            <h5 class="fw-bold  mb-0">
                <i class="bi bi-images me-2 text-primary"></i>1. Gambar Latar Hero
            </h5>
            <span class="badge badge-solsel">Maksimal 4 Gambar</span>
        </div>
        <p class="text-muted fs-8 mb-4">
            Kelola 4 slot gambar latar belakang hero di beranda website. Gambar akan berganti otomatis (slideshow).<br>
            <strong>Format:</strong> JPG, PNG, WEBP • <strong>Ukuran file:</strong> Max 2MB per gambar • <strong>Rekomendasi:</strong> 1920×1080px
        </p>

        {{-- Grid 4 Slot Gambar --}}
        <div class="hero-grid">
            @for($i = 0; $i < 4; $i++)
                @php
                    $imgPath = $heroImages[$i] ?? null;
                    $hasImg = !empty($imgPath) && file_exists(public_path($imgPath));
                @endphp

                <div class="hero-slot-card {{ $hasImg ? 'has-image' : 'is-empty' }}" id="heroCard_{{ $i }}">
                    {{-- Header Slot --}}
                    <div class="hero-slot-header">
                        <span class="hero-slot-badge">Slide {{ $i + 1 }}</span>
                        <button type="button" class="btn-slot-delete" id="btnDelete_{{ $i }}"
                                onclick="hapusSlotHero({{ $i }})" title="Hapus gambar slide ini"
                                style="{{ $hasImg ? '' : 'display:none;' }}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>

                    {{-- Area Gambar / Slot Kosong --}}
                    <div class="hero-slot-body" onclick="pilihGambarSlot({{ $i }})">
                        {{-- Gambar Preview --}}
                        <img src="{{ $hasImg ? asset($imgPath) . '?v=' . time() : '' }}"
                             id="heroPreview_{{ $i }}"
                             class="hero-slot-img"
                             style="{{ $hasImg ? '' : 'display:none;' }}"
                             alt="Hero Slide {{ $i + 1 }}">

                        {{-- Overlay saat hover pada gambar aktif --}}
                        <div class="hero-slot-overlay" id="heroOverlay_{{ $i }}" style="{{ $hasImg ? '' : 'display:none;' }}">
                            <i class="bi bi-camera-fill fs-3 mb-1"></i>
                            <span class="fs-8">Klik untuk ganti gambar</span>
                        </div>

                        {{-- Tampilan saat slot masih kosong --}}
                        <div class="hero-slot-empty" id="heroEmpty_{{ $i }}" style="{{ $hasImg ? 'display:none;' : '' }}">
                            <i class="bi bi-cloud-arrow-up-fill fs-2 mb-2 text-primary opacity-75"></i>
                            <span class="fw-semibold  fs-7">+ Tambah Slide {{ $i + 1 }}</span>
                            <small class="text-muted fs-8">Klik untuk pilih file</small>
                        </div>
                    </div>

                    {{-- Input Hidden & File untuk Slot Ini --}}
                    <input type="hidden" name="hero_existing[{{ $i }}]" id="heroExisting_{{ $i }}" value="{{ $hasImg ? $imgPath : '' }}">
                    <input type="hidden" name="hero_delete[{{ $i }}]" id="heroDelete_{{ $i }}" value="0">
                    <input type="file" name="hero_file[{{ $i }}]" id="heroFile_{{ $i }}"
                           accept="image/jpeg,image/jpg,image/png,image/webp"
                           style="display:none;"
                           onchange="pratinjauGambarHero(this, {{ $i }})">
                </div>
            @endfor
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- 2. SOSIAL MEDIA & LINK EKSTERNAL              --}}
    {{-- ============================================= --}}
    <div class="glass-card p-4 mb-4">
        <h5 class="fw-bold  pb-2 mb-2 border-bottom">
            <i class="bi bi-share-fill me-2 text-primary"></i>2. Sosial Media & Link Eksternal
        </h5>
        <p class="text-muted fs-8 mb-3">
            Tambahkan akun media sosial resmi atau link instansi lainnya.
        </p>

        <div id="sosmedContainer" class="d-flex flex-column gap-2 mb-3">
            @foreach($sosmedLinks as $idx => $sm)
            <div class="sosmed-row d-flex align-items-center gap-2 p-2 rounded-3" id="sosmedRow{{ $idx }}" style="background: var(--card-sub-bg);">
                <div class="icon-preview d-flex align-items-center justify-content-center rounded-3" id="iconPreview{{ $idx }}" style="width: 38px; height: 38px; background: transparent; box-shadow: none; border: none;">
                    <i class="bi {{ $sm['icon'] ?? 'bi-globe' }} text-primary fs-5"></i>
                </div>
                <select name="sosmed_icon[]" class="form-select border-0 py-2 fs-7 fw-semibold" style="width: 180px;" onchange="updateIcon(this, {{ $idx }})">
                    @foreach($sosmedIcons as $iconClass => $iconLabel)
                    <option value="{{ $iconClass }}" {{ ($sm['icon'] ?? '') === $iconClass ? 'selected' : '' }}>{{ $iconLabel }}</option>
                    @endforeach
                </select>
                <input type="text" name="sosmed_label[]" class="form-control border-0 py-2 fs-7" value="{{ $sm['label'] ?? '' }}" placeholder="Label (opsional)" style="max-width:160px;">
                <input type="url" name="sosmed_url[]" class="form-control border-0 py-2 fs-7 flex-grow-1" value="{{ $sm['url'] ?? '' }}" placeholder="https://...">
                <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" onclick="hapusSosmed({{ $idx }})" title="Hapus Link">
                    <i class="bi bi-trash text-danger"></i>
                </button>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-glass-pill px-3 py-2 fs-7 d-flex align-items-center gap-2" onclick="tambahSosmed()">
            <i class="bi bi-plus-circle text-primary"></i> Tambah Akun / Link
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- 3. NAVBAR (Teks Berjalan / Marquee)           --}}
    {{-- ============================================= --}}
    <div class="glass-card p-4 mb-4">
        <h5 class="fw-bold pb-2 mb-3 border-bottom">
            <i class="bi bi-menu-button-wide me-2 text-primary"></i>3. Pengaturan Navbar & Teks Berjalan
        </h5>
        <div class="mb-3">
            <div class="p-3 rounded-4 mb-3" style="background: var(--card-sub-bg);">
                <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
                    <input type="checkbox" name="navbar_marquee_enabled" value="1" id="marqueeSwitch"
                           {{ old('navbar_marquee_enabled', $settings['navbar_marquee_enabled'] ?? '0') == '1' ? 'checked' : '' }}
                           class="form-check-input ms-0" style="width: 2.8em; height: 1.5em;">
                    <label class="form-check-label fw-bold fs-7 ms-2" for="marqueeSwitch">
                        Tampilkan Teks Berjalan di Atas Navbar
                    </label>
                </div>
            </div>

            <label class="form-label fw-bold fs-7 mb-1" for="navbar_marquee_text">
                Teks Pengumuman / Berjalan (Marquee)
            </label>
            <textarea name="navbar_marquee_text" id="navbar_marquee_text" 
                class="form-control @error('navbar_marquee_text') is-invalid @enderror" rows="3"
                placeholder="Masukkan teks pengumuman penting...">{{ old('navbar_marquee_text', $settings['navbar_marquee_text'] ?? '') }}</textarea>
            @error('navbar_marquee_text')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <div class="d-flex justify-content-between align-items-center mt-1">
                <small class="text-muted fs-8">
                    <i class="bi bi-info-circle me-1"></i>Teks ini akan berjalan dari kanan ke kiri di atas navbar pada halaman publik.
                </small>
                <small class="text-muted fs-8" id="marqueeCharCount">
                    0 karakter
                </small>
            </div>

            {{-- Pratinjau Teks Berjalan di Admin --}}
            <div class="mt-3 p-3 rounded-3" id="marqueePreviewBox" style="background: var(--card-sub-bg); border: 1px dashed rgba(0,0,0,0.15);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge bg-primary fs-9 px-2 py-1"><i class="bi bi-eye-fill me-1"></i>Pratinjau Tampilan</span>
                    <span class="badge {{ old('navbar_marquee_enabled', $settings['navbar_marquee_enabled'] ?? '0') == '1' ? 'bg-success' : 'bg-secondary' }}" id="marqueeStatusBadge">
                        {{ old('navbar_marquee_enabled', $settings['navbar_marquee_enabled'] ?? '0') == '1' ? 'Status: Aktif' : 'Status: Nonaktif' }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background: #ffffff; color: #1e293b; border: 1px solid rgba(0,0,0,0.08); overflow: hidden;">
                    <span class="badge rounded-pill d-flex align-items-center gap-1 px-2 py-1 fw-bold text-white" style="background: #0284c7; font-size: 0.72rem; flex-shrink: 0;">
                        <i class="bi bi-megaphone-fill"></i> INFORMASI
                    </span>
                    <div class="flex-grow-1 overflow-hidden" style="white-space: nowrap; text-overflow: ellipsis;">
                        <span id="marqueePreviewText" class="fw-semibold fs-8 text-dark">{{ old('navbar_marquee_text', $settings['navbar_marquee_text'] ?? '') ?: '(Belum ada teks pengumuman)' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- 4. INFORMASI FOOTER                           --}}
    {{-- ============================================= --}}
    <div class="glass-card p-4 mb-4">
        <h5 class="fw-bold pb-2 mb-3 border-bottom">
            <i class="bi bi-layout-text-window-reverse me-2 text-primary"></i>4. Informasi Footer
        </h5>
        <div class="mb-3">
            <label class="form-label fw-bold fs-7 mb-1">Alamat Kantor</label>
            <textarea name="footer_address" class="form-control @error('footer_address') is-invalid @enderror" rows="2"
                placeholder="Jl. Raya Padang Aro...">{{ old('footer_address', $settings['footer_address'] ?? '') }}</textarea>
            @error('footer_address')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold fs-7 mb-1">Email Kontak</label>
                <input type="text" name="footer_email" class="form-control @error('footer_email') is-invalid @enderror" value="{{ old('footer_email', $settings['footer_email'] ?? '') }}">
                @error('footer_email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold fs-7 mb-1">Nomor Telepon</label>
                <input type="text" name="footer_phone" class="form-control @error('footer_phone') is-invalid @enderror" value="{{ old('footer_phone', $settings['footer_phone'] ?? '') }}">
                @error('footer_phone')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-0">
            <label class="form-label fw-bold fs-7 mb-1">
                <i class="bi bi-geo-alt me-1 text-danger"></i>Google Maps (Kode Iframe)
            </label>
            <textarea name="footer_google_maps" class="form-control @error('footer_google_maps') is-invalid @enderror" rows="3"
                placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="200"></iframe>'>{{ old('footer_google_maps', $settings['footer_google_maps'] ?? '') }}</textarea>
            @error('footer_google_maps')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1 fs-8">
                <i class="bi bi-info-circle me-1"></i>Salin kode iframe dari Google Maps (Bagikan / Share → Sematkan peta / Embed a map).
            </small>
        </div>
    </div>

    {{-- Tombol Simpan Pengaturan --}}
    <div class="glass-card p-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mb-5">
        <span class="text-muted fs-8">Perubahan akan langsung diterapkan pada halaman publik.</span>
        <button type="submit" class="btn btn-primary px-5 py-2 fs-7 fw-bold">
            <i class="bi bi-save me-2"></i>Simpan Pengaturan
        </button>
    </div>
</form>

<script>
// =============================================================
// HERO SLOTS JAVASCRIPT LOGIC (4 SLOTS)
// =============================================================

function pilihGambarSlot(slotIndex) {
    var fileInput = document.getElementById('heroFile_' + slotIndex);
    if (fileInput) {
        fileInput.click();
    }
}

function pratinjauGambarHero(input, slotIndex) {
    if (!input.files || !input.files[0]) return;

    var file = input.files[0];

    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (allowedTypes.indexOf(file.type) === -1) {
        Swal.fire({
            icon: 'error',
            title: 'Format Tidak Sesuai',
            text: 'Harap pilih file dengan format JPG, PNG, atau WEBP.'
        });
        input.value = '';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'File Terlalu Besar',
            text: 'Ukuran file maksimal adalah 2MB per gambar.'
        });
        input.value = '';
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var card = document.getElementById('heroCard_' + slotIndex);
        var previewImg = document.getElementById('heroPreview_' + slotIndex);
        var overlay = document.getElementById('heroOverlay_' + slotIndex);
        var emptyBox = document.getElementById('heroEmpty_' + slotIndex);
        var deleteBtn = document.getElementById('btnDelete_' + slotIndex);
        var deleteInput = document.getElementById('heroDelete_' + slotIndex);

        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
        overlay.style.display = 'flex';
        emptyBox.style.display = 'none';
        deleteBtn.style.display = 'flex';

        deleteInput.value = '0';

        card.classList.remove('is-empty');
        card.classList.add('has-image');

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Gambar Slide ' + (slotIndex + 1) + ' dipilih! Klik Simpan.',
            showConfirmButton: false,
            timer: 2500
        });
    };
    reader.readAsDataURL(file);
}

function hapusSlotHero(slotIndex) {
    Swal.fire({
        title: 'Hapus Slide ' + (slotIndex + 1) + '?',
        text: 'Gambar ini akan dihapus setelah Anda mengklik Simpan Pengaturan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then(function(result) {
        if (result.isConfirmed) {
            var card = document.getElementById('heroCard_' + slotIndex);
            var previewImg = document.getElementById('heroPreview_' + slotIndex);
            var overlay = document.getElementById('heroOverlay_' + slotIndex);
            var emptyBox = document.getElementById('heroEmpty_' + slotIndex);
            var deleteBtn = document.getElementById('btnDelete_' + slotIndex);
            var deleteInput = document.getElementById('heroDelete_' + slotIndex);
            var fileInput = document.getElementById('heroFile_' + slotIndex);
            var existingInput = document.getElementById('heroExisting_' + slotIndex);

            previewImg.style.display = 'none';
            previewImg.src = '';
            overlay.style.display = 'none';
            deleteBtn.style.display = 'none';
            emptyBox.style.display = 'flex';

            fileInput.value = '';
            existingInput.value = '';

            deleteInput.value = '1';

            card.classList.remove('has-image');
            card.classList.add('is-empty');

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Slide ' + (slotIndex + 1) + ' dihapus. Klik Simpan untuk menerapkan.',
                showConfirmButton: false,
                timer: 2500
            });
        }
    });
}

// =============================================================
// MEDIA SOSIAL JAVASCRIPT LOGIC
// =============================================================

var sosmedIcons = @json($sosmedIcons);
var sosmedCount = {{ count($sosmedLinks) }};

function tambahSosmed() {
    var idx = sosmedCount++;
    var container = document.getElementById('sosmedContainer');

    var optionsHtml = '';
    for (var cls in sosmedIcons) {
        optionsHtml += '<option value="' + cls + '">' + sosmedIcons[cls] + '</option>';
    }

    var row = document.createElement('div');
    row.className = 'sosmed-row d-flex align-items-center gap-2 p-2 rounded-3';
    row.style.background = 'var(--card-sub-bg)';
    row.id = 'sosmedRow' + idx;
    row.innerHTML =
        '<div class="icon-preview d-flex align-items-center justify-content-center rounded-3" id="iconPreview' + idx + '" style="width: 38px; height: 38px; background: transparent; box-shadow: none; border: none;">' +
            '<i class="bi bi-facebook text-primary fs-5"></i>' +
        '</div>' +
        '<select name="sosmed_icon[]" class="form-select border-0 py-2 fs-7 fw-semibold" style="width: 180px;" onchange="updateIcon(this, ' + idx + ')">' +
            optionsHtml +
        '</select>' +
        '<input type="text" name="sosmed_label[]" class="form-control border-0 py-2 fs-7" placeholder="Label (opsional)" style="max-width:160px;">' +
        '<input type="url" name="sosmed_url[]" class="form-control border-0 py-2 fs-7 flex-grow-1" placeholder="https://...">' +
        '<button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" onclick="hapusSosmed(' + idx + ')" title="Hapus Link">' +
            '<i class="bi bi-trash text-danger"></i>' +
        '</button>';

    container.appendChild(row);

    row.style.opacity = '0';
    row.style.transform = 'translateY(10px)';
    requestAnimationFrame(function() {
        row.style.transition = 'all .25s ease';
        row.style.opacity = '1';
        row.style.transform = 'translateY(0)';
    });
}

function updateIcon(select, idx) {
    var preview = document.getElementById('iconPreview' + idx);
    if (preview) {
        preview.innerHTML = '<i class="bi ' + select.value + ' text-primary fs-5"></i>';
    }
}

function hapusSosmed(idx) {
    var row = document.getElementById('sosmedRow' + idx);
    if (!row) return;

    row.style.transition = 'all .2s ease';
    row.style.opacity = '0';
    row.style.transform = 'translateX(20px)';
    setTimeout(function() { row.remove(); }, 200);
}

// =============================================================
// MARQUEE TEKS BERJALAN & PRATINJAU REALTIME
// =============================================================

function updateMarqueePreview() {
    var textarea = document.getElementById('navbar_marquee_text');
    var charCount = document.getElementById('marqueeCharCount');
    var previewText = document.getElementById('marqueePreviewText');
    var switchEl = document.getElementById('marqueeSwitch');
    var statusBadge = document.getElementById('marqueeStatusBadge');

    if (!textarea) return;

    var len = textarea.value.length;
    if (charCount) {
        charCount.textContent = len + ' karakter' + (len > 3000 ? ' (Maksimal 3000 karakter)' : '');
        if (len > 3000) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    }

    if (previewText) {
        previewText.textContent = textarea.value.trim() || '(Belum ada teks pengumuman)';
    }

    if (statusBadge && switchEl) {
        if (switchEl.checked) {
            statusBadge.className = 'badge bg-success';
            statusBadge.textContent = 'Status: Aktif';
        } else {
            statusBadge.className = 'badge bg-secondary';
            statusBadge.textContent = 'Status: Nonaktif';
        }
    }
}

var marqueeTextarea = document.getElementById('navbar_marquee_text');
var marqueeSwitchEl = document.getElementById('marqueeSwitch');

if (marqueeTextarea) {
    marqueeTextarea.addEventListener('input', updateMarqueePreview);
}
if (marqueeSwitchEl) {
    marqueeSwitchEl.addEventListener('change', updateMarqueePreview);
}

// Inisialisasi saat load
updateMarqueePreview();

// =============================================================
// LOADING SAAT SIMPAN
// =============================================================

document.getElementById('settingForm').addEventListener('submit', function() {
    Swal.fire({
        title: 'Menyimpan Pengaturan...',
        text: 'Mohon tunggu beberapa saat.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: function() { Swal.showLoading(); }
    });
});

// =============================================================
// NOTIFIKASI FLASH DARI SERVER
// =============================================================

@if(session('success'))
Swal.fire({
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    icon: 'success',
    confirmButtonText: 'OK',
    confirmButtonColor: '#10b981'
});
@endif

@if(isset($errors) && $errors->any())
var errorMessages = @json($errors->all());
Swal.fire({
    title: 'Gagal Menyimpan!',
    html: errorMessages.join('<br>'),
    icon: 'error',
    confirmButtonText: 'OK',
    confirmButtonColor: '#dc3545'
});
@endif
</script>
@endsection

<style>
/* Grid 4 Slot Hero */
.hero-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

/* Card Tiap Slot */
.hero-slot-card {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    background: var(--card-sub-bg);
    border: 2px dashed rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.hero-slot-card.has-image {
    border: 2px solid rgba(37, 99, 235, 0.4);
}

.hero-slot-card:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

/* Header Slot */
.hero-slot-header {
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 10;
}

.hero-slot-badge {
    background: rgba(15, 23, 42, 0.75);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    backdrop-filter: blur(6px);
}

.btn-slot-delete {
    background: rgba(220, 53, 69, 0.95);
    color: white;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.btn-slot-delete:hover {
    background: #dc3545;
    transform: scale(1.15);
}

/* Body Slot (16:9) */
.hero-slot-body {
    position: relative;
    aspect-ratio: 16/9;
    cursor: pointer;
    overflow: hidden;
}

.hero-slot-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.hero-slot-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(2px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.hero-slot-card:hover .hero-slot-overlay {
    opacity: 1;
}

.hero-slot-empty {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.hero-slot-card:hover .hero-slot-empty {
    background: rgba(37, 99, 235, 0.05);
}

@media (max-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr;
    }
}
</style>
