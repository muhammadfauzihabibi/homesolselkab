@extends('layouts.frontend')

@section('title', 'Daftar Sarana dan Prasarana')

@section('content')
  <!-- Bento Banner -->
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Sarana & Prasarana</li>
        </ol>
      </nav>

      <span class="bento-eyebrow bento-eyebrow-success mb-2">FASILITAS PUBLIK</span>
      <h1 class="bento-page-title">Sarana & Prasarana Publik</h1>
      <p class="bento-page-subtitle">Direktori gedung publik, fasilitas olahraga, ruang terbuka hijau, dan infrastruktur penunjang Kabupaten Solok Selatan</p>
    </div>
  </section>

  <!-- Filter & Grid Container -->
  <div class="container bento-overlap-container pb-5">

    <!-- Bento Filter Card -->
    <div class="bento-card mb-4 p-4">
      <form action="{{ route('frontend.sarana_prasarana.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label fs-8 fw-bold text-muted-custom mb-1">Cari Fasilitas</label>
          <div class="input-group">
            <span class="input-group-text bg-body border-end-0 rounded-start-pill">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 rounded-end-pill fs-7" placeholder="Nama gedung, pengelola..." value="{{ request('search') }}">
          </div>
        </div>

        <div class="col-md-3">
          <label class="form-label fs-8 fw-bold text-muted-custom mb-1">Kategori</label>
          <select name="kategori" class="form-select rounded-pill fs-7" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            @foreach($kategoris as $kat)
              <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fs-8 fw-bold text-muted-custom mb-1">Kecamatan</label>
          <select name="kecamatan" class="form-select rounded-pill fs-7" onchange="this.form.submit()">
            <option value="">-- Semua Kecamatan --</option>
            @foreach($kecamatans as $kec)
              <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn-bento btn-bento-primary w-100">
            Filter
          </button>
          @if(request('search') || request('kategori') || request('kecamatan'))
            <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn-bento btn-bento-outline px-3" title="Reset Filter">
              <i class="bi bi-x-lg"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Bento Grid Sarana Prasarana -->
    <div class="bento-grid">
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

          $isBaik = $item->kondisi === 'Baik';
          $isRusakRingan = $item->kondisi === 'Rusak Ringan';
        @endphp
        <div class="bento-col-4">
          <a href="{{ route('frontend.sarana_prasarana.detail', $item->slug) }}" class="bento-sp-card">
            <span class="bento-accent-line"></span>

            <div class="bento-sp-media">
              <img src="{{ $item->foto_utama ? asset('storage/' . $item->foto_utama) : $fallbackImg }}" alt="{{ $item->nama }}">
              <div class="bento-sp-badges">
                <span class="bento-badge bento-badge-primary">
                  {{ $item->kategori }}
                </span>
                <span class="bento-badge {{ $isBaik ? 'bento-badge-success' : ($isRusakRingan ? 'bento-badge-warning' : 'bento-badge-danger') }}">
                  <i class="bi bi-shield-check me-1"></i>{{ $item->kondisi }}
                </span>
              </div>
            </div>

            <div class="bento-sp-content">
              <div>
                <h5 class="bento-sp-title">{{ $item->nama }}</h5>
                <div class="bento-sp-info">
                  <i class="bi bi-geo-alt-fill text-danger flex-shrink-0"></i>
                  <span class="text-truncate">
                    {{ $item->kecamatan }}@if($item->nagari), Nagari {{ $item->nagari }}@endif
                  </span>
                </div>
                <div class="bento-sp-info">
                  <i class="bi bi-building-gear text-primary flex-shrink-0"></i>
                  <span class="text-truncate">Pengelola: <strong>{{ $item->pengelola }}</strong></span>
                </div>
              </div>

              <div class="pt-3 mt-3 border-top border-subtle d-flex align-items-center justify-content-between fs-8">
                <span class="text-muted-custom">Status: {{ $item->status_operasional ?? 'Aktif' }}</span>
                <span class="text-primary fw-semibold">Detail Fasilitas <i class="bi bi-arrow-right ms-1"></i></span>
              </div>
            </div>

          </a>
        </div>
      @empty
        <div class="bento-col-12 text-center py-5">
          <div class="bento-card p-5 d-inline-block text-muted-custom">
            <i class="bi bi-building fs-1 opacity-50 d-block mb-3"></i>
            <h5 class="fw-bold mb-1">Data Tidak Ditemukan</h5>
            <p class="fs-8 mb-0">Tidak ada sarana atau prasarana yang sesuai dengan filter pencarian.</p>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($items->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $items->links('pagination::bootstrap-5') }}
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
