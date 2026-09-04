@extends('layouts.frontend')

@section('title', 'Galeri Video')

@section('content')
<section class="page-hero-banner position-relative">
        <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
        <div class="hero-bg-slider w-100 h-100">
            <div class="hero-bg-slide active">
            <img src="{{ asset('images/bg1.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Background Header 1">
            </div>
            <div class="hero-bg-slide">
            <img src="{{ asset('images/bg2.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Background Header 2">
            </div>
            <div class="hero-bg-slide">
            <img src="{{ asset('images/bg3.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Background Header 3">
            </div>
            <div class="hero-bg-slide">
            <img src="{{ asset('images/bg4.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Background Header 4">
            </div>
        </div>
        <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
        </div>

        <div class="container position-relative" style="z-index: 5;">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Video</li>
            </ol>
        </nav>

        <h1 class="page-title">Video</h1>
        <p class="page-description">Dokumentasi video liputan dan kegiatan daerah</p>
        </div>
    </section>

<div class="container pb-5 container-overlap" style="margin-top: -60px;">
  <div class="row g-4">
    @forelse($videos as $video)
      <div class="col-lg-4 col-md-6">
              <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100">
                <!-- Video Frame Player -->
                <div class="ratio ratio-16x9">
                  <iframe src="{{ $video->youtube_embed }}" title="{{ $video->judul }}" allowfullscreen></iframe>
                </div>
                
                <!-- Information Footer -->
                <div class="card-body p-3 d-flex flex-column justify-content-between bg-body">
                  <div>
                    <span class="badge bg-danger-subtle text-danger fw-semibold mb-2 fs-8">
                      <i class="bi bi-youtube me-1"></i> YouTube
                    </span>
                    <h6 class="fw-bold text-body-emphasis line-clamp-2 mb-2 fs-7">
                      {{ $video->judul }}
                    </h6>
                  </div>
                  <small class="text-body-secondary fs-8 mt-2">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ \Carbon\Carbon::parse($video->tanggal ?? now())->translatedFormat('d F Y') }}
                  </small>
                </div>
              </div>
            </div>
    @empty
      <div class="col-12 py-5 text-center text-muted-custom">Belum ada video.</div>
    @endforelse
  </div>
  <!-- Pagination Navigasi -->
    @if($videos->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $videos->links('pagination::bootstrap-5') }}
      </div>
    @endif
</div>
@endsection