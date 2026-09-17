@extends('layouts.frontend')

@section('title', 'Galeri Foto Kegiatan')

@section('content')
  <!-- Bento Subpage Banner -->
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item active text-truncate" aria-current="page">Galeri Foto</li>
        </ol>
      </nav>

      <div class="d-flex flex-wrap align-items-center gap-2 mb-2.5">
        <span class="bento-badge bento-badge-primary">
          <i class="bi bi-camera-fill me-1"></i> DOKUMENTASI VISUAL
        </span>
        <span class="bento-badge">
          <i class="bi bi-images me-1"></i> {{ number_format($galeris->total()) }} Foto Kegiatan
        </span>
      </div>

      <h1 class="bento-page-title mb-2">Galeri Foto Kegiatan</h1>
      <p class="bento-page-subtitle mb-0">Dokumentasi visual kegiatan pemerintahan, pelayanan publik, dan pembangunan Kabupaten Solok Selatan</p>
    </div>
  </section>

  <!-- Bento Grid Galeri Foto -->
  <div class="container bento-overlap-container pb-5">
    <div class="bento-grid">
      @forelse($galeris as $galeri)
        <div class="bento-col-4">
          <div class="bento-card bento-card-interactive h-100 p-0 border border-subtle d-flex flex-column"
               style="cursor: pointer;"
               data-bs-toggle="modal"
               data-bs-target="#photoModal"
               data-img="{{ asset('storage/' . $galeri->file_path) }}"
               data-title="{{ $galeri->judul }}"
               data-date="{{ \Carbon\Carbon::parse($galeri->tanggal)->translatedFormat('d F Y') }}">
            <span class="bento-accent-line"></span>

            <!-- Media Container (Aspect Ratio 4/3) -->
            <div class="bento-media" style="aspect-ratio: 4/3;">
              <img src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}" loading="lazy">
              <div class="position-absolute top-0 start-0 p-3 d-flex justify-content-between align-items-center w-100">
                <span class="bento-badge bento-badge-primary fs-8 shadow-xs">
                  <i class="bi bi-image me-1"></i> Foto
                </span>
                <span class="badge bg-dark bg-opacity-60 text-white rounded-pill px-2.5 py-1 fs-8 shadow-xs" title="Klik untuk memperbesar">
                  <i class="bi bi-arrows-fullscreen"></i>
                </span>
              </div>
            </div>

            <!-- Card Caption Content -->
            <div class="p-3.5 p-md-4 d-flex flex-column justify-content-between flex-grow-1">
              <h6 class="fw-bold line-clamp-2 fs-7 mb-2 text-body-emphasis" title="{{ $galeri->judul }}">
                {{ $galeri->judul }}
              </h6>
              <div class="pt-2.5 border-top border-subtle d-flex align-items-center justify-content-between fs-8 text-muted-custom">
                <span>
                  <i class="bi bi-calendar3 me-1 text-primary"></i>
                  {{ \Carbon\Carbon::parse($galeri->tanggal)->translatedFormat('d M Y') }}
                </span>
                <span class="text-primary fw-semibold fs-8">
                  Lihat Foto <i class="bi bi-arrow-right ms-1"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="bento-col-12 py-5 text-center">
          <div class="bento-card p-5 d-inline-block text-muted-custom">
            <i class="bi bi-images fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Belum Ada Galeri Foto</h5>
            <p class="fs-8 mb-0">Dokumentasi foto belum tersedia saat ini.</p>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination Navigasi -->
    @if($galeris->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $galeris->links('pagination::bootstrap-5') }}
      </div>
    @endif

    {{-- Bottom Navigation --}}
    <div class="mt-5 pt-4 border-top border-subtle d-flex justify-content-center">
      <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
        <i class="bi bi-house-door"></i> Kembali ke Beranda
      </a>
    </div>
  </div>

  <!-- Photo Lightbox Modal (1 Card: Gambar, Judul, Perbesar, dan Exit) -->
  <div class="modal fade image-lightbox-modal" id="photoModal" tabindex="-1" aria-labelledby="photoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content; margin: 1.75rem auto;">
      <div class="modal-content bg-transparent border-0 shadow-none">
        <div class="popup-single-card" id="photoSingleCard">

          <!-- Area Gambar, Action Buttons, dan Judul Menyatu 1 Card -->
          <div class="popup-card-media position-relative text-center">
            <!-- Floating Action Buttons: Tombol Perbesar & Exit (Tepat di pojok kanan atas gambar) -->
            <div class="popup-card-actions">
              <a href="" id="photoModalOpenFull" target="_blank" class="btn-popup-ctrl" title="Perbesar / Buka Gambar Penuh">
                <i class="bi bi-arrows-fullscreen"></i>
              </a>
              <button type="button" class="btn-popup-ctrl btn-popup-exit" data-bs-dismiss="modal" aria-label="Tutup" title="Keluar / Tutup">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>

            <!-- Gambar Pop-up -->
            <img src="" id="photoModalImg" class="popup-img" alt="Gallery Photo">

            <!-- Judul & Tanggal Foto (Overlay Menyatu di bagian bawah gambar) -->
            <div class="popup-card-caption">
              <h5 class="popup-title mb-1" id="photoModalTitle">Judul Foto</h5>
              <small class="text-white-50 fs-8 d-flex align-items-center gap-1.5">
                <i class="bi bi-calendar3"></i> <span id="photoModalDate">Tanggal Foto</span>
              </small>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const photoModal = document.getElementById('photoModal');
      if (photoModal) {
        photoModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const imgSrc = button.getAttribute('data-img');
          const title = button.getAttribute('data-title');
          const date = button.getAttribute('data-date');

          const modalImg = photoModal.querySelector('#photoModalImg');
          const modalTitle = photoModal.querySelector('#photoModalTitle');
          const modalDate = photoModal.querySelector('#photoModalDate');
          const modalOpenFull = photoModal.querySelector('#photoModalOpenFull');

          if (modalImg) modalImg.src = imgSrc;
          if (modalTitle) modalTitle.textContent = title;
          if (modalDate) modalDate.textContent = date;
          if (modalOpenFull) modalOpenFull.href = imgSrc;
        });
      }
    });
  </script>
@endsection
