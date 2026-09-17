@extends('layouts.frontend')

@section('title', 'Poster Digital')

@section('content')
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Poster Digital</li>
        </ol>
      </nav>

      <span class="bento-eyebrow bento-eyebrow-accent mb-2">PUBLIKASI VISUAL</span>
      <h1 class="bento-page-title">Poster Digital & Infografis</h1>
      <p class="bento-page-subtitle">Informasi visual dan poster resmi terbaru dari Pemerintah Kabupaten Solok Selatan</p>
    </div>
  </section>

  <div class="container bento-overlap-container pb-5">
    <div class="row g-4">
      @forelse($posters as $poster)
        @php
          $posterImg = !empty($poster->foto_poster) ? asset('storage/' . $poster->foto_poster) : asset('images/rth.png');
          $tglPoster = !empty($poster->tanggal_publikasi) ? \Carbon\Carbon::parse($poster->tanggal_publikasi)->translatedFormat('d M Y') : date('d M Y');
        @endphp
        <div class="col-lg-4 col-md-6">
          <a href="{{ route('frontend.poster.detail', $poster->slug) }}" class="text-decoration-none d-block h-100 group">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100 bg-body">
              <!-- Thumbnail Poster Image (Agak Lonjong / Portrait 365px) -->
              <div class="position-relative overflow-hidden" style="height: 365px; background-color: #0f172a;">
                <img src="{{ $posterImg }}"
                     alt="{{ $poster->judul }}"
                     class="w-100 h-100 object-fit-contain transition-all"
                     onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                <div class="position-absolute top-0 start-0 p-3 w-100 d-flex align-items-center justify-content-between z-2">
                  <span class="badge bg-primary rounded-pill px-3 py-1.5 fs-8 fw-semibold shadow-sm">
                    <i class="bi bi-image me-1"></i> Poster Digital
                  </span>
                  <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 fs-8">
                    <i class="bi bi-eye-fill me-1"></i> {{ number_format($poster->views_count ?? 0) }}
                  </span>
                </div>

                <!-- Quick Zoom/Pop-up Button -->
                <button type="button"
                        class="btn btn-sm btn-glass-modal rounded-pill position-absolute bottom-0 end-0 m-3 z-2 d-inline-flex align-items-center gap-1.5 shadow"
                        title="Lihat Pop-up Gambar Penuh"
                        data-img="{{ $posterImg }}"
                        data-title="{{ $poster->judul }}"
                        data-date="{{ $tglPoster }}"
                        data-category="Poster Digital"
                        data-link="{{ route('frontend.poster.detail', $poster->slug) }}"
                        onclick="event.preventDefault(); event.stopPropagation(); openSingleImageModal(this);">
                  <i class="bi bi-arrows-fullscreen"></i> Perbesar
                </button>
              </div>

              <!-- Poster Card Body -->
              <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-bold text-body-emphasis fs-6 line-clamp-2 mb-2 group-hover-primary transition-all leading-snug">
                    {{ $poster->judul }}
                  </h5>
                  <p class="text-body-secondary fs-8 line-clamp-2 mb-3">
                    {{ Str::limit(strip_tags($poster->deskripsi ?? ''), 95) }}
                  </p>
                </div>
                <div class="pt-3 border-top border-subtle d-flex align-items-center justify-content-between fs-8 text-body-secondary">
                  <span>
                    <i class="bi bi-clock me-1 text-primary"></i> {{ $tglPoster }}
                  </span>
                  <span class="text-primary fw-semibold group-hover-primary">
                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                  </span>
                </div>
              </div>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <div class="card border-0 rounded-4 p-5 d-inline-block text-muted shadow-sm bg-body">
            <i class="bi bi-image fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Belum Ada Poster</h5>
            <p class="fs-8 mb-0">Poster digital dan infografis belum dipublikasikan saat ini.</p>
          </div>
        </div>
      @endforelse
    </div>

    @if($posters->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $posters->links('pagination::bootstrap-5') }}
      </div>
    @endif

    {{-- Bottom Navigation --}}
    <div class="mt-5 pt-4 border-top border-subtle d-flex justify-content-center">
      <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
        <i class="bi bi-house-door"></i> Kembali ke Beranda
      </a>
    </div>
  </div>

  <!-- Modal Detail Gambar Pop-up -->
  <div class="modal fade image-lightbox-modal" id="imageDetailModal" tabindex="-1" aria-labelledby="imgModalTitle" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content; margin: 1.75rem auto;">
      <div class="modal-content bg-transparent border-0 shadow-none">
        <div class="popup-single-card" id="popupSingleCard">
          <div class="popup-card-media position-relative text-center">
            <div class="popup-card-actions">
              <button type="button" class="btn-popup-ctrl" id="btnToggleZoom" title="Perbesar Layar Penuh" onclick="togglePopupFullscreen()">
                <i class="bi bi-arrows-fullscreen" id="zoomIcon"></i>
              </button>
              <button type="button" class="btn-popup-ctrl btn-popup-exit" data-bs-dismiss="modal" aria-label="Tutup" title="Keluar / Tutup">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
            <img src="" id="imgModalDisplay" class="popup-img" alt="Detail Gambar" onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
            <div class="popup-card-caption">
              <h5 class="popup-title mb-0" id="imgModalTitle">Judul Foto</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.openSingleImageModal = function(el) {
      const img = el.getAttribute('data-img');
      const title = el.getAttribute('data-title');
      const displayImg = document.getElementById('imgModalDisplay');
      const modalTitle = document.getElementById('imgModalTitle');

      if (displayImg) {
        displayImg.src = img;
        displayImg.alt = title;
      }
      if (modalTitle) {
        modalTitle.textContent = title;
      }

      const modalEl = document.getElementById('imageDetailModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();
      }
    };

    window.togglePopupFullscreen = function() {
      const card = document.getElementById('popupSingleCard');
      const icon = document.getElementById('zoomIcon');
      if (card) {
        card.classList.toggle('popup-fullscreen');
        if (card.classList.contains('popup-fullscreen')) {
          icon.classList.remove('bi-arrows-fullscreen');
          icon.classList.add('bi-fullscreen-exit');
        } else {
          icon.classList.remove('bi-fullscreen-exit');
          icon.classList.add('bi-arrows-fullscreen');
        }
      }
    };
  </script>
@endsection
