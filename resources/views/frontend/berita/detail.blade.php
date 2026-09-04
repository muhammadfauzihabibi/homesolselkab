@extends('layouts.frontend')

@section('title', $berita->judul)

@section('content')
<section class="page-hero-banner position-relative">
  <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
    <div class="hero-bg-slider w-100 h-100">
      <div class="hero-bg-slide active"><img src="{{ asset('images/bg1.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Hero Header 1"></div>
      <div class="hero-bg-slide"><img src="{{ asset('images/bg2.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Hero Header 2"></div>
    </div>
    <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
  </div>
  <div class="container position-relative" style="z-index: 5;">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.berita.index') }}">Berita & Artikel</a></li>
        <li class="breadcrumb-item active text-white-50 text-truncate max-w-xs" aria-current="page">{{ $berita->judul }}</li>
      </ol>
    </nav>
    <span class="badge bg-primary text-white rounded-pill mb-2 px-3 py-1 fs-8">{{ $berita->kategori ?? 'Berita' }}</span>
    <h1 class="page-title mb-3">{{ $berita->judul }}</h1>
    <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 fs-8 mb-5">
      <span class="d-inline-flex align-items-center"><i class="bi bi-clock me-1.5 text-info"></i> {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d F Y') }}</span>
      <span class="opacity-50">•</span>
      <span class="d-inline-flex align-items-center gap-1.5 px-3 py-1 rounded-pill fw-semibold fs-8" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); backdrop-filter: blur(4px);">
        <i class="bi bi-eye-fill fs-7"></i>
        <span>{{ number_format($berita->views_count ?? 0) }} Kali Dibaca</span>
      </span>
    </div>
  </div>
</section>

<div class="container pb-5 container-overlap" style="margin-top: -60px;">
  <div class="row g-4 align-items-start">
    <!-- Main Article Body (col-lg-8) -->
    <div class="col-lg-8">
      <div class="page-floating-card">
        @if($berita->image)
          <img src="{{ asset('storage/' . $berita->image) }}" class="page-featured-image rounded-4 mb-4 w-100 object-fit-cover shadow-sm" style="max-height: 420px;" alt="{{ $berita->judul }}">
        @endif
        
        <div class="page-detail-body mb-4 leading-relaxed">
          {!! $berita->konten !!}
        </div>

        <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center">
          <a href="{{ route('frontend.berita.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fs-7 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Semua Berita
          </a>
          <span class="text-muted-custom fs-8">
            <i class="bi bi-eye me-1"></i> Total Views: <strong>{{ number_format($berita->views_count ?? 0) }}</strong>
          </span>
        </div>
      </div>
    </div>

    <!-- Sidebar: Berita Terpopuler (col-lg-4) -->
    <div class="col-lg-4 sidebar-berita-col">
      <div class="glass-card p-4 rounded-4 shadow-sm bg-body border-0 mb-4 sticky-top" style="top: 100px;">
        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
          <div class="d-flex align-items-center gap-2">
            <div class="p-2 rounded-3 text-warning bg-warning-subtle">
              <i class="bi bi-fire fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold text-main mb-0 fs-6">Berita Terpopuler</h5>
              <small class="text-muted-custom fs-8">Paling banyak dibaca publik</small>
            </div>
          </div>
        </div>

        @if(isset($beritaTerpopuler) && $beritaTerpopuler->count())
          <div class="d-flex flex-column gap-3">
            @foreach($beritaTerpopuler as $rank => $populer)
              <a href="{{ route('frontend.berita.detail', $populer->slug) }}" class="text-decoration-none text-reset group">
                <div class="d-flex gap-3 align-items-start p-2 rounded-3 transition-all hover-bg-subtle">
                  <!-- Rank Badge & Image -->
                  <div class="position-relative flex-shrink-0" style="width: 80px; height: 60px;">
                    @if($populer->image)
                      <img src="{{ asset('storage/' . $populer->image) }}" class="w-100 h-100 rounded-3 object-fit-cover shadow-sm" alt="{{ $populer->judul }}">
                    @else
                      <div class="w-100 h-100 rounded-3 bg-secondary bg-opacity-15 d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-newspaper fs-4"></i>
                      </div>
                    @endif
                    <span class="position-absolute top-0 start-0 badge {{ $rank == 0 ? 'bg-danger' : ($rank == 1 ? 'bg-warning text-dark' : 'bg-primary') }} rounded-bottom-end rounded-top-start fs-8 shadow-sm">
                      #{{ $rank + 1 }}
                    </span>
                  </div>

                  <!-- Info -->
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="fw-bold fs-8 text-main line-clamp-2 mb-1 group-hover-primary">
                      {{ $populer->judul }}
                    </h6>
                    <div class="d-flex align-items-center justify-content-between text-muted-custom fs-8">
                      <span><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($populer->tanggal_terbit)->translatedFormat('d M') }}</span>
                      <span class="badge bg-primary-subtle text-primary rounded-pill fs-8">
                        <i class="bi bi-eye-fill me-1"></i> {{ number_format($populer->views_count) }}
                      </span>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="text-center py-4 text-muted-custom">
            <i class="bi bi-newspaper fs-2 opacity-50 d-block mb-2"></i>
            <p class="fs-8 mb-0">Belum ada data berita terpopuler lainnya.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection