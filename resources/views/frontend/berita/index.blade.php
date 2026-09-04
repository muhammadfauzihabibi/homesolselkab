@extends('layouts.frontend')

@section('title', 'Daftar Berita & Artikel')

@section('content')
  <!-- 1. HERO BANNER SECTION WITH BACKGROUND SLIDER -->
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
          <li class="breadcrumb-item active" aria-current="page">Berita & Artikel</li>
        </ol>
      </nav>

      <h1 class="page-title">Berita & Artikel</h1>
      <p class="page-description">Informasi dan kabar terbaru seputar Pemerintah Kabupaten Solok Selatan</p>
    </div>
  </section>

  <!-- 2. DAFTAR BERITA DENGAN SIDEBAR BERITA TERPOPULER -->
  <div class="container pb-5 container-overlap" style="margin-top: -60px;">
    <div class="row g-4">

      <!-- Kolom Kiri: Grid Semua Berita (col-lg-8) -->
      <div class="col-lg-8">
        <div class="row g-4">
          @forelse($beritas as $berita)
            <div class="col-md-6">
              <a href="{{ route('frontend.berita.detail', $berita->slug) }}" class="text-decoration-none h-100 d-block">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 card-jds-hover bg-body">
                  
                  <!-- Thumbnail Gambar -->
                  <div class="ratio ratio-16x9">
                    @if($berita->image)
                      <img src="{{ asset('storage/' . $berita->image) }}" class="object-fit-cover w-100 h-100" alt="{{ $berita->judul }}">
                    @else
                      <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                      </div>
                    @endif
                  </div>

                  <!-- Card Body -->
                  <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-primary-subtle text-primary fw-semibold rounded-pill fs-8">
                          {{ $berita->kategori ?? 'Pemerintahan' }}
                        </span>
                        <span class="text-muted-custom fs-8">
                          <i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count ?? 0) }}x
                        </span>
                      </div>
                      <h5 class="fw-bold text-main line-clamp-2 fs-7 mb-2">
                        {{ $berita->judul }}
                      </h5>
                      @if(isset($berita->ringkas) || isset($berita->konten))
                        <p class="text-muted-custom fs-8 line-clamp-2 mb-3">
                          {{ Str::limit(strip_tags($berita->ringkas ?? $berita->konten), 90) }}
                        </p>
                      @endif
                    </div>

                    <!-- Card Footer Info -->
                    <small class="text-muted-custom fs-8 pt-2 border-top border-subtle d-flex align-items-center justify-content-between">
                      <span>
                        <i class="bi bi-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d M Y') }}
                      </span>
                      <span class="text-primary fw-semibold fs-8">
                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                      </span>
                    </small>
                  </div>

                </div>
              </a>
            </div>
          @empty
            <!-- Empty State -->
            <div class="col-12 py-5 text-center text-muted-custom">
              <div class="glass-card p-5 rounded-4 d-inline-block">
                <i class="bi bi-newspaper fs-1 opacity-50 d-block mb-3"></i>
                <h5 class="fw-bold mb-1">Belum Ada Berita</h5>
                <p class="fs-8 mb-0">Informasi dan berita terbaru belum dipublikasikan.</p>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Pagination Navigasi -->
        @if($beritas->hasPages())
          <div class="mt-5 d-flex justify-content-center pagination-wrapper">
            {{ $beritas->links('pagination::bootstrap-5') }}
          </div>
        @endif
      </div>

      <!-- Kolom Kanan: Sidebar Berita Terpopuler (col-lg-4) -->
      <div class="col-lg-4">
        <div class="glass-card p-4 rounded-4 shadow-sm bg-body border-0 sticky-top" style="top: 100px;">
          
          <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
            <div class="d-flex align-items-center gap-2">
              <div class="p-2 rounded-3 text-warning bg-warning-subtle">
                <i class="bi bi-fire fs-5"></i>
              </div>
              <div>
                <h5 class="fw-bold text-main mb-0 fs-6">Berita Terpopuler</h5>
                <small class="text-muted-custom fs-8">Berdasarkan total klik & pembaca</small>
              </div>
            </div>
          </div>

          @if(isset($beritaTerpopuler) && $beritaTerpopuler->count())
            <div class="d-flex flex-column gap-3">
              @foreach($beritaTerpopuler as $rank => $populer)
                <a href="{{ route('frontend.berita.detail', $populer->slug) }}" class="text-decoration-none text-reset group">
                  <div class="d-flex gap-3 align-items-start p-2 rounded-3 transition-all hover-bg-subtle">
                    <!-- Rank & Thumbnail -->
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

                    <!-- Article Info -->
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
              <p class="fs-8 mb-0">Belum ada berita terpopuler.</p>
            </div>
          @endif

        </div>
      </div>

    </div>
  </div>
@endsection