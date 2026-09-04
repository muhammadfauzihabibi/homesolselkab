@extends('layouts.frontend')

@section('title', 'Daftar Sarana dan Prasarana')

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
          <li class="breadcrumb-item active" aria-current="page">Sarana & Prasarana</li>
        </ol>
      </nav>

      <h1 class="page-title">Sarana dan Prasarana</h1>
      <p class="page-description">Direktori gedung publik, fasilitas olahraga, kendaraan operasional, dan infrastruktur Kabupaten Solok Selatan</p>
    </div>
  </section>

  <!-- 2. SEARCH & FILTER BAR + DAFTAR KARTU SARANA PRASARANA -->
  <div class="container pb-5 container-overlap" style="margin-top: -50px;">
    
    <!-- Filter Card -->
    <div class="card border-0 rounded-4 shadow-sm p-4 mb-4 bg-body">
      <form action="{{ route('frontend.sarana_prasarana.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
          <label class="form-label fs-8 fw-bold text-secondary">Pencarian</label>
          <div class="input-group">
            <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="search" class="form-control bg-body-tertiary border-start-0 rounded-end-3 fs-7" placeholder="Cari nama, fasilitas, pengelola..." value="{{ request('search') }}">
          </div>
        </div>

        <div class="col-md-3">
          <label class="form-label fs-8 fw-bold text-secondary">Kategori</label>
          <select name="kategori" class="form-select bg-body-tertiary rounded-3 fs-7" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            @foreach($kategoris as $kat)
              <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fs-8 fw-bold text-secondary">Kecamatan</label>
          <select name="kecamatan" class="form-select bg-body-tertiary rounded-3 fs-7" onchange="this.form.submit()">
            <option value="">-- Semua Kecamatan --</option>
            @foreach($kecamatans as $kec)
              <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2 d-flex align-items-end gap-2">
          <button type="submit" class="btn btn-primary rounded-3 w-100 fs-7 fw-semibold py-2">
            Filter
          </button>
          @if(request('search') || request('kategori') || request('kecamatan'))
            <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn btn-outline-secondary rounded-3 py-2 px-3 fs-7" title="Reset">
              <i class="bi bi-x-lg"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Grid Kartu Sarana Prasarana -->
    <div class="row g-4">
      @forelse($items as $item)
        @php
          $fallbackImg = asset('images/bg1.jpeg');
          $katLower = strtolower($item->kategori);
          if(str_contains($katLower, 'olahraga')) {
              $fallbackImg = asset('images/bg2.jpeg');
          } elseif(str_contains($katLower, 'taman') || str_contains($katLower, 'rth')) {
              $fallbackImg = asset('images/rth.png');
          } elseif(str_contains($katLower, 'kendaraan') || str_contains($katLower, 'transportasi')) {
              $fallbackImg = asset('images/bg3.jpeg');
          } elseif(str_contains($katLower, 'gedung')) {
              $fallbackImg = asset('images/menara-songket.png');
          }
        @endphp
        <div class="col-md-6 col-lg-4">
          <a href="{{ route('frontend.sarana_prasarana.detail', $item->slug) }}" class="text-decoration-none h-100 d-block">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 card-jds-hover bg-body d-flex flex-column justify-content-between">
              
              <div>
                <!-- Thumbnail Gambar dengan Non-overlapping Top Bar Overlay -->
                <div class="ratio ratio-16x9 position-relative">
                  <img src="{{ $item->foto_utama ? asset('storage/' . $item->foto_utama) : $fallbackImg }}" class="object-fit-cover w-100 h-100" alt="{{ $item->nama }}">
                  
                  <div class="position-absolute top-0 start-0 w-100 p-2.5 px-3 d-flex justify-content-between align-items-center gap-2" style="z-index: 2; background: linear-gradient(to bottom, rgba(0,0,0,0.65), transparent);">
                    <span class="badge bg-primary text-white rounded-pill fs-8 text-truncate shadow-sm" style="max-width: 65%;" title="{{ $item->kategori }}">
                      {{ $item->kategori }}
                    </span>
                    <span class="badge {{ $item->kondisi == 'Baik' ? 'bg-success text-white' : ($item->kondisi == 'Rusak Ringan' ? 'bg-warning text-dark' : 'bg-danger text-white') }} rounded-pill fs-8 flex-shrink-0 shadow-sm">
                      {{ $item->kondisi }}
                    </span>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                  @if($item->sub_kategori)
                    <small class="text-primary fw-semibold fs-8 d-block mb-1">{{ $item->sub_kategori }}</small>
                  @endif

                  <h5 class="fw-bold text-main line-clamp-2 fs-7 mb-2">
                    {{ $item->nama }}
                  </h5>

                  <p class="text-muted-custom fs-8 line-clamp-2 mb-3">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->kecamatan }}@if($item->nagari), Nagari {{ $item->nagari }}@endif
                  </p>

                  <div class="fs-8 text-secondary mb-2">
                    <i class="bi bi-building me-1"></i> <strong>Pengelola:</strong> {{ $item->pengelola }}
                  </div>
                </div>
              </div>

              <!-- Card Footer Info -->
              <div class="card-footer bg-transparent border-top border-subtle px-4 py-3 d-flex align-items-center justify-content-between">
                <span class="badge {{ $item->status_operasional == 'Aktif' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-dark' }} rounded-pill fs-8">
                  {{ $item->status_operasional }}
                </span>
                <span class="text-primary fw-semibold fs-8">
                  Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                </span>
              </div>

            </div>
          </a>
        </div>
      @empty
        <!-- Empty State -->
        <div class="col-12 py-5 text-center text-muted-custom">
          <div class="glass-card p-5 rounded-4 d-inline-block">
            <i class="bi bi-building-x fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Belum Ada Data Sarana & Prasarana</h5>
            <p class="fs-8 mb-0">Tidak ada data sarana prasarana yang sesuai dengan pencarian Anda.</p>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination Navigasi -->
    @if($items->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $items->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection
