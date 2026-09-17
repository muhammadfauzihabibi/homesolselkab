@extends('layouts.frontend')

@section('title', $item->nama . ' - Sarana dan Prasarana Solok Selatan')

@section('content')
  <!-- Bento Hero Banner -->
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <!-- Top Navigation: Breadcrumb + Hero Back Button -->
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.sarana_prasarana.index') }}">Sarana & Prasarana</a></li>
            <li class="breadcrumb-item active text-truncate max-w-xs" aria-current="page">{{ Str::limit($item->nama, 35) }}</li>
          </ol>
        </nav>

        <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn-bento-hero-back">
          <i class="bi bi-arrow-left"></i> <span>Kembali ke Sarana & Prasarana</span>
        </a>
      </div>

      <div class="d-flex flex-wrap align-items-center gap-2 mb-2.5">
        <span class="bento-badge bento-badge-primary">
          <i class="bi bi-tag-fill me-1"></i> {{ $item->kategori }}
        </span>
        @if($item->sub_kategori)
          <span class="bento-badge">
            {{ $item->sub_kategori }}
          </span>
        @endif
        <span class="bento-badge {{ $item->kondisi == 'Baik' ? 'bento-badge-success' : ($item->kondisi == 'Rusak Ringan' ? 'bento-badge-warning' : 'bento-badge-danger') }}">
          <i class="bi bi-shield-check me-1"></i> Kondisi: {{ $item->kondisi }}
        </span>
        <span class="bento-badge">
          <i class="bi bi-activity me-1"></i> Status: {{ $item->status_operasional }}
        </span>
      </div>

      <h1 class="bento-page-title mb-2">{{ $item->nama }}</h1>
      <p class="bento-page-subtitle mb-0">
        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->kecamatan }}@if($item->nagari), Nagari {{ $item->nagari }}@endif
      </p>
    </div>
  </section>

  <!-- Main Bento Detail Container -->
  <div class="container bento-overlap-container pb-5">
    <div class="bento-grid align-items-start">

      <!-- Left Column (Bento Span 8): Unified Facility Showcase & Specifications -->
      <div class="bento-col-8">
        <div class="bento-card p-4 p-md-5 mb-4">
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

          <!-- Main Facility Photo Showcase -->
          <div class="bento-media mb-4 rounded-4 overflow-hidden position-relative shadow-sm" style="aspect-ratio: 16/9; max-height: 480px;">
            <img src="{{ $item->foto_utama ? asset('storage/' . $item->foto_utama) : $fallbackImgMain }}" alt="{{ $item->nama }}" class="w-100 h-100 object-fit-cover">
          </div>

          <!-- Additional Photo Gallery (if available) -->
          @if(!empty($item->galeri_foto) && is_array($item->galeri_foto) && count($item->galeri_foto) > 0)
            <div class="mb-4 pb-4 border-bottom border-subtle">
              <h6 class="fw-bold mb-3 fs-7 text-uppercase text-muted-custom d-flex align-items-center gap-2" style="letter-spacing: 0.05em;">
                <i class="bi bi-images text-primary"></i> Galeri Dokumentasi Foto ({{ count($item->galeri_foto) }})
              </h6>
              <div class="row g-2.5">
                @foreach($item->galeri_foto as $gPath)
                  <div class="col-4 col-sm-3">
                    <a href="{{ asset('storage/' . $gPath) }}" target="_blank" class="bento-card p-0 overflow-hidden bento-card-interactive d-block rounded-3 border border-subtle shadow-xs" style="aspect-ratio: 4/3;">
                      <img src="{{ asset('storage/' . $gPath) }}" alt="Galeri {{ $item->nama }}" class="w-100 h-100 object-fit-cover">
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Specifications Header -->
          <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary" style="width: 44px; height: 44px; flex-shrink: 0;">
              <i class="bi bi-info-circle-fill fs-4"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-0.5 fs-5 text-body-emphasis">Spesifikasi & Informasi Fasilitas</h5>
              <small class="text-muted-custom fs-7">Rincian data teknis, tarif layanan, rute, dan alamat sarana</small>
            </div>
          </div>

          <div class="d-flex flex-column gap-4">
            @if($item->jenis_kendaraan)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-1.5" style="letter-spacing: 0.05em;">Jenis / Tipe Unit:</span>
                <p class="fs-6 fw-bold text-body-emphasis mb-0">{{ $item->jenis_kendaraan }}</p>
              </div>
            @endif

            @if($item->spesifikasi)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-2" style="letter-spacing: 0.05em;">Spesifikasi Teknis:</span>
                <p class="fs-6 text-body-emphasis mb-0 leading-relaxed" style="white-space: pre-line;">{{ $item->spesifikasi }}</p>
              </div>
            @endif

            @if($item->tarif_retribusi)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-2" style="letter-spacing: 0.05em;">Tarif & Retribusi:</span>
                <div class="p-3.5 rounded-3 bg-body-tertiary border border-subtle border-start border-4 border-primary" style="padding: 1rem 1.25rem;">
                  <p class="fs-6 fw-semibold text-body-emphasis mb-0 leading-relaxed" style="white-space: pre-line;">{{ $item->tarif_retribusi }}</p>
                </div>
              </div>
            @endif

            @if($item->rute_layanan)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-2" style="letter-spacing: 0.05em;">Rute Layanan:</span>
                <div class="p-3.5 rounded-3 bg-body-tertiary border border-subtle" style="padding: 1rem 1.25rem;">
                  <p class="fs-6 text-body-emphasis mb-0 leading-relaxed" style="white-space: pre-line;">{{ $item->rute_layanan }}</p>
                </div>
              </div>
            @endif

            <div class="pt-1">
              <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-2" style="letter-spacing: 0.05em;">Alamat Lengkap:</span>
              <div class="d-flex align-items-start gap-3 p-3.5 rounded-3 bg-body-tertiary border border-subtle" style="padding: 1rem 1.25rem;">
                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center mt-0.5" style="width: 32px; height: 32px; flex-shrink: 0;">
                  <i class="bi bi-geo-alt-fill fs-6"></i>
                </div>
                <p class="fs-6 text-body-emphasis mb-0 leading-relaxed">{{ $item->alamat_lengkap }}</p>
              </div>
            </div>
          </div>

          <!-- Bottom Navigation inside the Main Card -->
          <div class="pt-4 mt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn-bento btn-bento-outline">
              <i class="bi bi-arrow-left"></i> Kembali ke Sarana & Prasarana
            </a>
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
              <i class="bi bi-house-door"></i> Ke Beranda
            </a>
          </div>
        </div>
      </div>

      <!-- Right Column: Location & Contact Bento (Bento Span 4) -->
      <div class="bento-col-4">
        <div class="bento-card p-4 p-md-4.5 sticky-top mb-4" style="top: 100px;">
          <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary" style="width: 40px; height: 40px; flex-shrink: 0;">
              <i class="bi bi-person-badge-fill fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-0.5 fs-6 text-body-emphasis">Pengelola & Lokasi</h5>
              <small class="text-muted-custom fs-8">Informasi penanggung jawab</small>
            </div>
          </div>

          <div class="d-flex flex-column gap-3.5 mb-4">
            <div class="pb-3 border-bottom border-subtle">
              <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-1.5" style="letter-spacing: 0.05em;">Instansi Pengelola</span>
              <strong class="fs-6 d-block text-primary fw-bold">{{ $item->pengelola }}</strong>
            </div>

            @if($item->kontak_pengelola)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-2" style="letter-spacing: 0.05em;">Kontak Layanan</span>
                <a href="tel:{{ $item->kontak_pengelola }}" class="btn-bento btn-bento-outline w-100 justify-content-center py-2.5">
                  <i class="bi bi-telephone-fill text-success me-2"></i> {{ $item->kontak_pengelola }}
                </a>
              </div>
            @endif

            <div class="pb-3 border-bottom border-subtle">
              <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-1.5" style="letter-spacing: 0.05em;">Wilayah Kecamatan</span>
              <div class="fs-6 fw-semibold text-body-emphasis d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-danger fs-6"></i>
                <span>{{ $item->kecamatan }}</span>
              </div>
            </div>

            @if($item->nagari)
              <div class="pb-3 border-bottom border-subtle">
                <span class="text-muted-custom fs-8 fw-semibold text-uppercase d-block mb-1.5" style="letter-spacing: 0.05em;">Nagari</span>
                <span class="fs-6 fw-semibold text-body-emphasis d-block">{{ $item->nagari }}</span>
              </div>
            @endif
          </div>

          @if($item->google_maps_url)
            <div class="mb-4">
              <a href="{{ $item->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="btn-bento btn-bento-primary w-100 justify-content-center py-2.5 shadow-sm">
                <i class="bi bi-map-fill me-2"></i> Buka Google Maps
              </a>
            </div>
          @endif

          <div class="pt-3 border-top border-subtle d-flex flex-column gap-2.5">
            <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn-bento btn-bento-outline w-100 justify-content-center py-2.5 fs-7">
              <i class="bi bi-arrow-left me-1.5"></i> Kembali ke Sarana & Prasarana
            </a>
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost w-100 justify-content-center py-2 fs-7">
              <i class="bi bi-house-door me-1.5"></i> Ke Beranda
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- Related Facilities Bento Grid -->
    @if(isset($relatedItems) && count($relatedItems) > 0)
      <div class="mt-5 pt-4 border-top border-subtle">
        <h4 class="fw-bold mb-4">Sarana & Prasarana Terkait</h4>
        <div class="bento-grid">
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
            <div class="bento-col-3">
              <a href="{{ route('frontend.sarana_prasarana.detail', $rel->slug) }}" class="bento-card bento-card-interactive p-0 h-100 text-decoration-none">
                <div class="bento-media" style="aspect-ratio: 16/10;">
                  <img src="{{ $rel->foto_utama ? asset('storage/' . $rel->foto_utama) : $fallbackImgRel }}" alt="{{ $rel->nama }}">
                  <span class="position-absolute top-0 start-0 m-2 bento-badge bento-badge-primary">
                    {{ $rel->kategori }}
                  </span>
                </div>
                <div class="p-3">
                  <h6 class="fw-bold line-clamp-2 fs-8 mb-1">{{ $rel->nama }}</h6>
                  <small class="text-muted-custom fs-9"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $rel->kecamatan }}</small>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
@endsection
