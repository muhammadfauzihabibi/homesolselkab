@extends('layouts.frontend')

@section('title', 'Galeri Video')

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
          <li class="breadcrumb-item active" aria-current="page">Video</li>
        </ol>
      </nav>

      <span class="bento-eyebrow bento-eyebrow-accent mb-2">DOKUMENTASI VIDEO</span>
      <h1 class="bento-page-title">Galeri Video Daerah</h1>
      <p class="bento-page-subtitle">Rekam jejak audio-visual liputan kegiatan resmi dan inovasi daerah Pemerintah Kabupaten Solok Selatan</p>
    </div>
  </section>

  <div class="container bento-overlap-container pb-5">
    <div class="bento-grid">
      @forelse($videos as $video)
        <div class="bento-col-4">
          <div class="bento-card p-0 h-100 overflow-hidden">
            <div class="ratio ratio-16x9">
              <iframe src="{{ $video->youtube_embed }}" title="{{ $video->judul }}" allowfullscreen loading="lazy"></iframe>
            </div>

            <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
              <div>
                <span class="bento-badge bento-badge-danger mb-2">
                  <i class="bi bi-youtube me-1"></i> YouTube
                </span>
                <h5 class="fw-bold line-clamp-2 fs-7 mb-2">
                  {{ $video->judul }}
                </h5>
              </div>
              <small class="text-muted-custom fs-8 mt-2 pt-2 border-top border-subtle d-flex align-items-center">
                <i class="bi bi-calendar3 me-1.5"></i>
                {{ \Carbon\Carbon::parse($video->tanggal ?? now())->translatedFormat('d F Y') }}
              </small>
            </div>
          </div>
        </div>
      @empty
        <div class="bento-col-12 py-5 text-center">
          <div class="bento-card p-5 d-inline-block text-muted-custom">
            <i class="bi bi-play-btn fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Belum Ada Video</h5>
            <p class="fs-8 mb-0">Dokumentasi video belum dipublikasikan saat ini.</p>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination Navigasi -->
    @if($videos->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $videos->links('pagination::bootstrap-5') }}
      </div>
    @endif

    {{-- Bottom Navigation --}}
    <div class="mt-5 pt-4 border-top border-subtle d-flex justify-content-center">
      <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
        <i class="bi bi-house-door"></i> Kembali ke Beranda
      </a>
    </div>
  </div>
@endsection
