@extends('layouts.frontend')

@section('title', $item->nama . ' - Sarana dan Prasarana Solok Selatan')

@section('content')
  <!-- 1. HERO BANNER SECTION WITH BACKGROUND SLIDER -->
  <section class="page-hero-banner position-relative">
    <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
      <div class="hero-bg-slider w-100 h-100">
        <div class="hero-bg-slide active">
          @if($item->foto_utama)
            <img src="{{ asset('storage/' . $item->foto_utama) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama }}">
          @else
            <img src="{{ asset('images/bg1.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Header Background">
          @endif
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
          <li class="breadcrumb-item">
            <a href="{{ route('frontend.sarana_prasarana.index') }}">Sarana & Prasarana</a>
          </li>
          <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($item->nama, 30) }}</li>
        </ol>
      </nav>

      <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <span class="badge bg-primary rounded-pill px-3 py-1.5 fs-8">
          {{ $item->kategori }}
        </span>
        @if($item->sub_kategori)
          <span class="badge bg-secondary rounded-pill px-3 py-1.5 fs-8">
            {{ $item->sub_kategori }}
          </span>
        @endif
        <span class="badge {{ $item->kondisi == 'Baik' ? 'bg-success' : ($item->kondisi == 'Rusak Ringan' ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-3 py-1.5 fs-8">
          Kondisi: {{ $item->kondisi }}
        </span>
        <span class="badge {{ $item->status_operasional == 'Aktif' ? 'bg-info text-dark' : 'bg-secondary' }} rounded-pill px-3 py-1.5 fs-8">
          Status: {{ $item->status_operasional }}
        </span>
      </div>

      <h1 class="page-title text-white fw-bold mb-2">{{ $item->nama }}</h1>
      <p class="page-description text-white-50">
        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->kecamatan }}@if($item->nagari), Nagari {{ $item->nagari }}@endif
      </p>
    </div>
  </section>

  <!-- 2. MAIN CONTENT SECTION -->
  <div class="container pb-5 container-overlap" style="margin-top: -40px;">
    <div class="row g-4">
      
      <!-- Left Column: Image Gallery & Specifications -->
      <div class="col-lg-8">
        
        <!-- Main Image Card -->
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm mb-4 bg-body">
          <div class="ratio ratio-16x9">
            @php
              $fallbackImgMain = asset('images/bg1.jpeg');
              $katLowerMain = strtolower($item->kategori);
              if(str_contains($katLowerMain, 'olahraga')) {
                  $fallbackImgMain = asset('images/bg2.jpeg');
              } elseif(str_contains($katLowerMain, 'taman') || str_contains($katLowerMain, 'rth')) {
                  $fallbackImgMain = asset('images/rth.png');
              } elseif(str_contains($katLowerMain, 'kendaraan') || str_contains($katLowerMain, 'transportasi')) {
                  $fallbackImgMain = asset('images/bg3.jpeg');
              } elseif(str_contains($katLowerMain, 'gedung')) {
                  $fallbackImgMain = asset('images/menara-songket.png');
              }
            @endphp
            <img src="{{ $item->foto_utama ? asset('storage/' . $item->foto_utama) : $fallbackImgMain }}" alt="{{ $item->nama }}" class="object-fit-cover w-100 h-100">
          </div>
        </div>

        <!-- Galeri Foto Tambahan -->
        @if(!empty($item->galeri_foto) && is_array($item->galeri_foto) && count($item->galeri_foto) > 0)
          <div class="card border-0 rounded-4 shadow-sm p-4 mb-4 bg-body">
            <h5 class="fw-bold text-main mb-3">
              <i class="bi bi-images text-primary me-2"></i> Galeri Foto
            </h5>
            <div class="row g-3">
              @foreach($item->galeri_foto as $gPath)
                <div class="col-6 col-md-4">
                  <a href="{{ asset('storage/' . $gPath) }}" target="_blank" class="d-block ratio ratio-4x3 rounded-3 overflow-hidden shadow-sm border card-jds-hover">
                    <img src="{{ asset('storage/' . $gPath) }}" alt="Galeri {{ $item->nama }}" class="object-fit-cover w-100 h-100">
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- Specifications & Details -->
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4 bg-body">
          <h5 class="fw-bold text-main mb-3 border-bottom pb-2">
            <i class="bi bi-info-circle text-primary me-2"></i> Detail & Spesifikasi Fasilitas
          </h5>

          @if($item->jenis_kendaraan)
            <div class="mb-4">
              <h6 class="fw-bold text-secondary fs-7 mb-1">Jenis / Merk Kendaraan:</h6>
              <p class="fs-7 text-main fw-semibold mb-0">{{ $item->jenis_kendaraan }}</p>
            </div>
          @endif

          @if($item->spesifikasi)
            <div class="mb-4">
              <h6 class="fw-bold text-secondary fs-7 mb-1">Spesifikasi Teknis:</h6>
              <p class="fs-7 text-main leading-relaxed mb-0" style="white-space: pre-line;">{{ $item->spesifikasi }}</p>
            </div>
          @endif

          @if($item->tarif_retribusi)
            <div class="mb-4">
              <h6 class="fw-bold text-secondary fs-7 mb-1">Tarif & Retribusi:</h6>
              <div class="p-3 bg-body-tertiary rounded-3 border-start border-primary border-4">
                <p class="fs-7 text-main leading-relaxed mb-0" style="white-space: pre-line;">{{ $item->tarif_retribusi }}</p>
              </div>
            </div>
          @endif

          @if($item->rute_layanan)
            <div class="mb-4">
              <h6 class="fw-bold text-secondary fs-7 mb-1">Rute Layanan & Operasional:</h6>
              <p class="fs-7 text-main leading-relaxed mb-0" style="white-space: pre-line;">{{ $item->rute_layanan }}</p>
            </div>
          @endif

          <div class="mb-0">
            <h6 class="fw-bold text-secondary fs-7 mb-1">Alamat Lengkap:</h6>
            <p class="fs-7 text-main leading-relaxed mb-0">{{ $item->alamat_lengkap }}</p>
          </div>
        </div>

      </div>

      <!-- Right Column: Location & Management Info Card -->
      <div class="col-lg-4">
        
        <!-- Info Card Pengelola -->
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4 bg-body">
          <h5 class="fw-bold text-main mb-3 border-bottom pb-2">
            <i class="bi bi-person-badge text-primary me-2"></i> Pengelola & Kontak
          </h5>

          <div class="mb-3">
            <small class="text-secondary d-block fs-8">Instansi Pengelola</small>
            <span class="fw-bold fs-7 text-main d-block">{{ $item->pengelola }}</span>
          </div>

          @if($item->kontak_pengelola)
            <div class="mb-3">
              <small class="text-secondary d-block fs-8">Kontak Layanan / Pengelola</small>
              <a href="tel:{{ $item->kontak_pengelola }}" class="btn btn-outline-success rounded-pill px-3 py-1.5 fs-7 fw-semibold mt-1 d-inline-flex align-items-center gap-2">
                <i class="bi bi-telephone-fill"></i> {{ $item->kontak_pengelola }}
              </a>
            </div>
          @endif

          <hr class="my-3">

          <div class="mb-3">
            <small class="text-secondary d-block fs-8">Lokasi Kecamatan</small>
            <span class="fw-semibold fs-7 text-main"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $item->kecamatan }}</span>
          </div>

          @if($item->nagari)
            <div class="mb-3">
              <small class="text-secondary d-block fs-8">Nagari</small>
              <span class="fw-semibold fs-7 text-main">{{ $item->nagari }}</span>
            </div>
          @endif

          @if($item->google_maps_url)
            <div class="mt-4">
              <a href="{{ $item->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary rounded-pill w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                <i class="bi bi-map-fill"></i> Buka Peta Google Maps
              </a>
            </div>
          @endif
        </div>

        <!-- Back Button Card -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-body">
          <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn btn-outline-secondary rounded-pill py-2 w-100 fw-semibold fs-7 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Prasarana
          </a>
        </div>

      </div>

    </div>

    <!-- Related Sarana & Prasarana -->
    @if(isset($relatedItems) && count($relatedItems) > 0)
      <div class="mt-5 pt-4 border-top">
        <h4 class="fw-bold text-main mb-4">Sarana & Prasarana Terkait</h4>
        <div class="row g-4">
          @foreach($relatedItems as $rel)
            @php
              $fallbackImgRel = asset('images/bg1.jpeg');
              $katLowerRel = strtolower($rel->kategori);
              if(str_contains($katLowerRel, 'olahraga')) {
                  $fallbackImgRel = asset('images/bg2.jpeg');
              } elseif(str_contains($katLowerRel, 'taman') || str_contains($katLowerRel, 'rth')) {
                  $fallbackImgRel = asset('images/rth.png');
              } elseif(str_contains($katLowerRel, 'kendaraan') || str_contains($katLowerRel, 'transportasi')) {
                  $fallbackImgRel = asset('images/bg3.jpeg');
              } elseif(str_contains($katLowerRel, 'gedung')) {
                  $fallbackImgRel = asset('images/menara-songket.png');
              }
            @endphp
            <div class="col-md-6 col-lg-3">
              <a href="{{ route('frontend.sarana_prasarana.detail', $rel->slug) }}" class="text-decoration-none h-100 d-block">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 card-jds-hover bg-body">
                  <div class="ratio ratio-16x9">
                    <img src="{{ $rel->foto_utama ? asset('storage/' . $rel->foto_utama) : $fallbackImgRel }}" class="object-fit-cover w-100 h-100" alt="{{ $rel->nama }}">
                  </div>
                  <div class="card-body p-3">
                    <span class="badge bg-primary-subtle text-primary fs-8 rounded-pill mb-1">{{ $rel->kategori }}</span>
                    <h6 class="fw-bold text-main line-clamp-2 fs-7 mb-1">{{ $rel->nama }}</h6>
                    <small class="text-muted-custom fs-8"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $rel->kecamatan }}</small>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
@endsection
