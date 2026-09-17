@extends('layouts.frontend')

@section('title', 'Daftar Berita & Artikel')

@section('content')
  <!-- Bento Subpage Banner -->
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Berita & Artikel</li>
        </ol>
      </nav>

      <span class="bento-eyebrow bento-eyebrow-accent mb-2">PORTAL INFORMASI</span>
      <h1 class="bento-page-title">Berita & Kabar Daerah</h1>
      <p class="bento-page-subtitle">Informasi dan kabar terkini seputar pemerintahan dan pembangunan Kabupaten Solok Selatan</p>
    </div>
  </section>

  <!-- Daftar Berita Grid -->
  <div class="container bento-overlap-container pb-5">
    <div class="row g-4">
      @forelse($beritas as $berita)
        @php
          $imgSrc = asset('images/rth.png');
          if(!empty($berita->image)) {
            if(\Illuminate\Support\Str::startsWith($berita->image, ['http://', 'https://'])) {
              $imgSrc = $berita->image;
            } elseif(\Illuminate\Support\Str::startsWith($berita->image, 'storage/')) {
              $imgSrc = asset($berita->image);
            } else {
              $imgSrc = asset('storage/' . $berita->image);
            }
          }
          $tglBerita = !empty($berita->tanggal_terbit) ? \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d M Y') : date('d M Y');
        @endphp
        <div class="col-lg-4 col-md-6">
          <a href="{{ route('frontend.berita.detail', $berita->slug) }}" class="text-decoration-none d-block h-100 group">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100 bg-body">
              <!-- Thumbnail Berita Image (Agak Lonjong / Portrait 365px) -->
              <div class="position-relative overflow-hidden" style="height: 365px; background-color: #0f172a;">
                <img src="{{ $imgSrc }}"
                     alt="{{ $berita->judul }}"
                     class="w-100 h-100 object-fit-contain transition-all"
                     onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                <div class="position-absolute top-0 start-0 p-3 w-100 d-flex align-items-center justify-content-between z-2">
                  <span class="badge bg-primary rounded-pill px-3 py-1.5 fs-8 fw-semibold shadow-sm">
                    {{ $berita->kategori ?? 'Berita Daerah' }}
                  </span>
                  <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 fs-8">
                    <i class="bi bi-eye-fill me-1"></i> {{ number_format($berita->views_count ?? 0) }}
                  </span>
                </div>
              </div>

              <!-- Card Body -->
              <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-bold text-body-emphasis fs-6 line-clamp-2 mb-2 group-hover-primary transition-all leading-snug">
                    {{ $berita->judul }}
                  </h5>
                  @if(isset($berita->ringkas) || isset($berita->konten))
                    <p class="text-body-secondary fs-8 line-clamp-2 mb-3">
                      {{ Str::limit(strip_tags($berita->ringkas ?? $berita->konten), 95) }}
                    </p>
                  @endif
                </div>

                <div class="pt-3 border-top border-subtle d-flex align-items-center justify-content-between fs-8 text-body-secondary">
                  <span>
                    <i class="bi bi-clock me-1 text-primary"></i> {{ $tglBerita }}
                  </span>
                  <span class="text-primary fw-semibold group-hover-primary">
                    Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                  </span>
                </div>
              </div>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <div class="card border-0 rounded-4 p-5 d-inline-block text-muted shadow-sm bg-body">
            <i class="bi bi-newspaper fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Belum Ada Berita</h5>
            <p class="fs-8 mb-0">Informasi dan berita terbaru belum dipublikasikan saat ini.</p>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($beritas->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $beritas->links('pagination::bootstrap-5') }}
      </div>
    @endif

    <div class="mt-5 pt-4 border-top border-subtle d-flex justify-content-center">
      <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
        <i class="bi bi-house-door"></i> Kembali ke Beranda
      </a>
    </div>
  </div>
@endsection
