@extends('layouts.frontend')

@section('title', 'Portal Resmi Pemerintah Kabupaten Solok Selatan')

@section('content')

  @php
    if (!isset($settings)) {
        try {
            $settings = \App\Models\Setting::pluck('value', 'key')->all();
        } catch (\Throwable $e) {
            $settings = [];
        }
    }
    $settingHeroImages = !empty($settings['hero_images']) ? json_decode($settings['hero_images'], true) : [];
    $validHeroImages = [];

    if (is_array($settingHeroImages) && count($settingHeroImages) > 0) {
        foreach ($settingHeroImages as $img) {
            if (!empty($img) && file_exists(public_path($img))) {
                $validHeroImages[] = asset($img);
            }
        }
    }

    $defaultHeroImages = [
        asset('images/bg1.jpeg'),
        asset('images/bg2.jpeg'),
        asset('images/bg3.jpeg'),
        asset('images/bg4.jpeg'),
    ];

    $heroSlides = !empty($validHeroImages) ? $validHeroImages : $defaultHeroImages;
  @endphp

  <!-- Hero Section -->
  <section class="hero-jds-wrapper position-relative text-white overflow-hidden">
    
    <!-- Hero Background Slider -->
    <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
      <div class="hero-bg-slider w-100 h-100">
        @foreach($heroSlides as $index => $heroImg)
          <div class="hero-bg-slide {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ $heroImg }}" alt="Background {{ $index + 1 }}" class="w-100 h-100 object-fit-cover" onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
          </div>
        @endforeach
      </div>
      <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
    </div>

    <!-- Hero Content Container -->
    <div class="container position-relative z-2 hero-content-container d-flex flex-column justify-content-between align-items-center">

      <!-- Hero Headline & Glowing Badge -->
      <div class="text-center mx-auto my-auto py-2 hero-text-box w-100">

        <h1 class="fw-extrabold text-white mb-3 tracking-tight hero-main-title text-center">
          <span class="d-block">MEWUJUDKAN SOLOK SELATAN</span>
          <span class="d-block">LEBIH MAJU DAN SEJAHTERA</span>
        </h1>
        <p class="lead text-white-75 fs-6 max-w-2xl mx-auto mb-0 text-center">
          Transformasi digital Kabupaten Solok Selatan<br>
          menuju daerah yang maju, humanis, dan berkelanjutan.
        </p>
      </div>

      <!-- Hero Stats Bar (Pinned at Bottom — Glass Blur matching reference) -->
      <div class="hero-stats-wrapper w-100 mt-auto pb-2">
        <div class="hero-stats-container">
          <!-- Item 1: Kecamatan -->
          <div class="hero-stat-pill">
            <div class="hero-stat-circle icon-blue">
              <i class="bi bi-hand-thumbs-up-fill"></i>
            </div>
            <div class="hero-stat-info">
              <span class="hero-stat-num">7</span>
              <span class="hero-stat-text">Total Kecamatan</span>
            </div>
          </div>

          <!-- Item 2: OPD Terdaftar -->
          <div class="hero-stat-pill">
            <div class="hero-stat-circle icon-amber">
              <i class="bi bi-bank"></i>
            </div>
            <div class="hero-stat-info">
              <span class="hero-stat-num">{{ isset($opds) ? $opds->count() : 0 }}</span>
              <span class="hero-stat-text">OPD Terdaftar</span>
            </div>
          </div>

          <!-- Item 3: Layanan Publik -->
          <div class="hero-stat-pill">
            <div class="hero-stat-circle icon-blue">
              <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="hero-stat-info">
              <span class="hero-stat-num">{{ isset($layanans) ? $layanans->count() : 0 }}</span>
              <span class="hero-stat-text">Total Layanan Publik</span>
            </div>
          </div>

          <!-- Item 4: Sarana & Prasarana -->
          <div class="hero-stat-pill">
            <div class="hero-stat-circle icon-amber">
              <i class="bi bi-award-fill"></i>
            </div>
            <div class="hero-stat-info">
              <span class="hero-stat-num">{{ isset($saranaPrasaranas) ? $saranaPrasaranas->count() : 0 }}+</span>
              <span class="hero-stat-text">Sarana & Prasarana</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- SECTION 1: ARTIKEL & BERITA (Left Featured News + Right Terpopuler) -->
  <section class="py-5 ">
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-center mb-4">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              WARTA & INFORMASI
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Warta Solok Selatan</h2>
          <p class="text-body-secondary mb-0 fs-7">
            Informasi terbaru seputar pemerintahan dan pembangunan Kabupaten Solok Selatan.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end d-none d-lg-block">
          <a href="{{ route('frontend.berita.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold fs-7">
            Lihat Semua Berita <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>
      </div>

      <div class="row g-4">
        <!-- Featured News Slider Card (col-lg-8 - 5 Berita + Pagination Dots + Nav Buttons) -->
        <div class="col-lg-8">
          <div class="position-relative h-100 min-h-400">
            <div class="swiper featuredNewsSwiper rounded-4 overflow-hidden shadow-sm h-100 position-relative" style="min-height: 420px;">
              <div class="swiper-wrapper">

                @forelse(collect($beritas ?? [])->take(5) as $index => $berita)
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
                    $tanggal = !empty($berita->tanggal_terbit) ? \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d M Y') : date('d M Y');
                  @endphp
                  <div class="swiper-slide h-100">
                    <a href="{{ route('frontend.berita.detail', $berita->slug) }}" class="text-decoration-none d-block h-100 position-relative">
                      <div class="w-100 h-100 position-relative overflow-hidden rounded-4 bg-dark">
                        <!-- Background Image -->
                        <img src="{{ $imgSrc }}"
                             alt="{{ $berita->judul }}"
                             class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                             style="min-height: 420px;"
                             onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">

                        <!-- Dark Overlay for High Contrast Text -->
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                             style="background: rgba(15, 23, 42, 0.7);"></div>

                        <!-- Card Body at Bottom Left -->
                        <div class="position-absolute bottom-0 start-0 end-0 p-4 p-md-5 z-2 text-white pb-5">
                          <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary rounded-pill px-3 py-1.5 fs-8 fw-semibold text-uppercase">
                              {{ $berita->kategori ?? 'kategori berita' }}
                            </span>
                            <span class="text-white-75 fs-8">
                              <i class="bi bi-calendar3 me-1"></i> {{ $tanggal }}
                            </span>
                          </div>

                          <h3 class="fw-extrabold text-white mb-2 line-clamp-2 fs-4 leading-snug">
                            {{ $berita->judul }}
                          </h3>

                          <p class="text-white-75 mb-0 line-clamp-2 fs-7 max-w-2xl">
                            {{ Str::limit(strip_tags($berita->ringkas ?? $berita->konten), 140) }}
                          </p>
                        </div>
                      </div>
                    </a>
                  </div>
                @empty
                  <!-- Empty State Slide -->
                  <div class="swiper-slide h-100">
                    <div class="w-100 h-100 position-relative overflow-hidden rounded-4 bg-body-tertiary d-flex flex-column align-items-center justify-content-center p-5 text-center border border-subtle" style="min-height: 420px;">
                      <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-newspaper fs-1"></i>
                      </div>
                      <h4 class="fw-bold text-main mb-1 fs-5">Belum Ada Berita Utama</h4>
                      <p class="text-muted-custom fs-7 mb-0 max-w-md">Informasi berita daerah terbaru akan ditampilkan di sini setelah dipublikasikan.</p>
                    </div>
                  </div>
                @endforelse

              </div>

              <!-- Pagination Dots (Titik Indikator) -->
              <div class="swiper-pagination featured-news-pagination mb-2"></div>
            </div>

            <!-- Navigation Arrow Buttons (Tombol Geser < >) -->
            <button class="btn btn-news-prev position-absolute start-0 top-50 translate-middle-y ms-2 ms-md-3 z-3 rounded-circle shadow d-flex align-items-center justify-content-center" type="button" aria-label="Sebelumnya" title="Sebelumnya">
              <i class="bi bi-chevron-left fs-5 text-white"></i>
            </button>
            <button class="btn btn-news-next position-absolute end-0 top-50 translate-middle-y me-2 me-md-3 z-3 rounded-circle shadow d-flex align-items-center justify-content-center" type="button" aria-label="Berikutnya" title="Berikutnya">
              <i class="bi bi-chevron-right fs-5 text-white"></i>
            </button>
          </div>
        </div>

        <!-- Widget Berita Terpopuler (col-lg-4) -->
        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-sm bg-body border border-subtle h-100 d-flex flex-column justify-content-between">
            <div>
              <!-- Header Berita Terpopuler (Golden Icon + Title + Subtitle) -->
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-4 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.18); color: #d97706;">
                  <i class="bi bi-fire fs-4"></i>
                </div>
                <div>
                  <h5 class="fw-bold text-main mb-0 fs-5">Berita Terpopuler</h5>
                  <small class="text-muted-custom fs-7">Berita Paling banyak dibaca pembaca</small>
                </div>
              </div>

              <hr class="border-subtle my-3 opacity-25">

              @if(isset($beritaTerpopuler) && $beritaTerpopuler->count())
                <div class="d-flex flex-column gap-2.5">
                  @foreach(collect($beritaTerpopuler)->take(5) as $rank => $populer)
                    @php
                      $popImg = asset('images/rth.png');
                      if(!empty($populer->image)) {
                        if(\Illuminate\Support\Str::startsWith($populer->image, ['http://', 'https://'])) {
                          $popImg = $populer->image;
                        } elseif(\Illuminate\Support\Str::startsWith($populer->image, 'storage/')) {
                          $popImg = asset($populer->image);
                        } else {
                          $popImg = asset('storage/' . $populer->image);
                        }
                      }
                      $popDate = !empty($populer->tanggal_terbit) ? \Carbon\Carbon::parse($populer->tanggal_terbit)->translatedFormat('d M Y') : date('d M Y');
                    @endphp
                    <a href="{{ route('frontend.berita.detail', $populer->slug) }}" class="popular-news-item group">
                      <!-- Image Thumbnail -->
                      <div class="position-relative flex-shrink-0" style="width: 64px; height: 50px;">
                        <img src="{{ $popImg }}"
                             class="w-100 h-100 rounded-3 object-fit-cover shadow-sm"
                             alt="{{ $populer->judul }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                      </div>

                      <!-- Title + Date -->
                      <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-bold fs-7 text-main line-clamp-2 mb-1 group-hover-primary leading-tight">
                          {{ $populer->judul }}
                        </h6>
                        <span class="text-muted-custom fs-8 d-inline-flex align-items-center">
                          <i class="bi bi-journal-text me-1 opacity-75"></i> {{ $popDate }}
                        </span>
                      </div>

                      <!-- View Count Pill Badge -->
                      <div class="flex-shrink-0">
                        <span class="popular-view-badge">
                          <i class="bi bi-eye-fill"></i> {{ number_format($populer->views_count ?? ($rank + 1) * 3) }}
                        </span>
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

    </div>
  </section>


  <!-- SECTION: POSTER DIGITAL & INFOGRAFIS (3 Terbaru) -->
  <section class="py-5">
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              PUBLIKASI VISUAL
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Poster Digital & Infografis</h2>
          <p class="text-body-secondary mb-0 fs-7">
            Informasi visual, sosialisasi, dan poster resmi Pemerintah Kabupaten Solok Selatan.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.poster.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Lihat Semua Poster <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- 3 Poster Grid -->
      <div class="row g-4">
        @forelse(collect($posters ?? [])->take(3) as $poster)
          @php
            $posterImg = !empty($poster->foto_poster) ? asset('storage/' . $poster->foto_poster) : asset('images/rth.png');
            $tglPoster = !empty($poster->tanggal_publikasi) ? \Carbon\Carbon::parse($poster->tanggal_publikasi)->translatedFormat('d M Y') : date('d M Y');
          @endphp
          <div class="col-md-4">
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
                </div>

                <!-- Poster Card Body -->
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="fw-bold text-body-emphasis fs-6 line-clamp-2 mb-2 group-hover-primary transition-all leading-snug">
                      {{ $poster->judul }}
                    </h5>
                    <p class="text-body-secondary fs-8 line-clamp-2 mb-3">
                      {{ Str::limit(strip_tags($poster->deskripsi ?? ''), 90) }}
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
          <!-- Empty State Poster Digital -->
          <div class="col-12">
            <div class="p-5 text-center rounded-4 border border-subtle bg-body">
              <i class="bi bi-image fs-1 text-primary opacity-50 mb-3 d-block"></i>
              <h5 class="fw-bold text-main mb-1 fs-6">Belum Ada Poster Digital</h5>
              <p class="text-muted-custom fs-7 mb-0">Infografis dan poster publikasi visual belum dipublikasikan saat ini.</p>
            </div>
          </div>
        @endforelse
      </div>

    </div>
  </section>


  <!-- SECTION 2: LAYANAN PUBLIC -->
  <section class="py-5" id="layanan-publik">
    <div class="container">
      
      <!-- Section Header -->
      <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
            LAYANAN DIGITAL
          </span>
        </div>
        <h2 class="fw-bold text-main display-6 mb-2">Layanan Public</h2>
        <p class="text-muted-custom">Portal layanan publik terpadu pemerintah daerah</p>
      </div>

      <!-- Horizontal Application Circle List -->
      <div class="app-horizontal-scroll d-flex flex-nowrap gap-4 overflow-x-auto pb-3 px-1" data-auto-scroll>
        @forelse($layanans as $index => $layanan)
          @php
            $icons = ['bi-app-indicator', 'bi-database-check', 'bi-shield-check', 'bi-headset', 'bi-globe2', 'bi-award', 'bi-diagram-3'];
            $iconClass = $icons[$index % count($icons)];
          @endphp
          <div class="app-horizontal-item flex-shrink-0">
            <a href="{{ $layanan->url }}" target="_blank" rel="noopener noreferrer" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center group">

              <!-- Lingkaran Icon -->
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi {{ $iconClass }} fs-3 text-primary"></i>
              </div>

              <!-- Nama Aplikasi di Bawah -->
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2" title="{{ $layanan->nama }}">
                {{ $layanan->nama }}
              </h6>

            </a>
          </div>
        @empty
          <!-- Empty State Layanan Publik -->
          <div class="w-100 text-center py-4 my-2">
            <div class="d-inline-flex flex-column align-items-center p-4 rounded-4 bg-body-tertiary border border-subtle">
              <i class="bi bi-grid-3x3-gap fs-1 text-muted opacity-50 mb-2"></i>
              <h6 class="fw-bold text-main mb-1 fs-7">Belum Ada Layanan Publik</h6>
              <p class="text-muted-custom fs-8 mb-0">Daftar layanan publik akan ditampilkan di sini saat data telah diinput.</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </section>


  <!-- SECTION 3: SARANA & PRASARANA PUBLIK -->
  <section class="py-5">
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              FASILITAS DAERAH
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Sarana dan Prasarana Daerah</h2>
          <p class="text-body-secondary mb-0 fs-7">
            Fasilitas umum, gedung publik, sarana olahraga, dan prasarana penunjang daerah.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Katalog Prasarana Lengkap <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Vertical Card Grid for Sarana Prasarana (3 columns) -->
      <div class="row g-4">
        @forelse(collect($saranaPrasaranas ?? [])->take(3) as $sp)
          @php
            $fallbackImg = asset('images/bg1.jpeg');
            $katLower = strtolower($sp->kategori);
            if(str_contains($katLower, 'olahraga')) {
                $fallbackImg = asset('images/bg2.jpeg');
            } elseif(str_contains($katLower, 'taman') || str_contains($katLower, 'rth')) {
                $fallbackImg = asset('images/rth.png');
            } elseif(str_contains($katLower, 'kendaraan') || str_contains($katLower, 'transportasi')) {
                $fallbackImg = asset('images/bg3.jpeg');
            } elseif(str_contains($katLower, 'gedung')) {
                $fallbackImg = asset('images/menara-songket.png');
            }

            $spImg = $sp->foto_utama ? asset('storage/' . $sp->foto_utama) : $fallbackImg;

            $kondisiClass = 'baik';
            if ($sp->kondisi == 'Rusak Ringan') {
                $kondisiClass = 'rusak-ringan';
            } elseif ($sp->kondisi == 'Rusak Berat' || $sp->kondisi == 'Tidak Beroperasi') {
                $kondisiClass = 'rusak-berat';
            }
          @endphp
          <div class="col-md-6 col-lg-4">
            <a href="{{ route('frontend.sarana_prasarana.detail', $sp->slug) }}" class="text-decoration-none d-block h-100">
              <div class="sp-card-custom">
                <div class="sp-thumb-wrapper">
                  <img src="{{ $spImg }}"
                       class="sp-thumb-img"
                       alt="{{ $sp->nama }}"
                       onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                  <div class="sp-overlay-gradient"></div>
                  <span class="sp-badge-category">
                    {{ $sp->kategori }}
                  </span>
                  <span class="sp-badge-status {{ $kondisiClass }}">
                    <i class="bi bi-shield-check me-1"></i>{{ $sp->kondisi }}
                  </span>
                </div>

                <div class="sp-card-body">
                  <h5 class="sp-card-title line-clamp-2">{{ $sp->nama }}</h5>
                  <div class="sp-info-chip mb-2">
                    <i class="bi bi-geo-alt-fill text-danger"></i>
                    <span class="text-truncate">{{ $sp->kecamatan }}@if($sp->nagari), Nagari {{ $sp->nagari }}@endif</span>
                  </div>
                  <div class="sp-info-chip">
                    <i class="bi bi-building-gear text-primary"></i>
                    <span>Pengelola: <strong>{{ $sp->pengelola }}</strong></span>
                  </div>
                </div>

                <div class="px-4 pb-4 pt-0">
                  <span class="sp-action-btn">
                    Lihat Detail Prasarana <i class="bi bi-arrow-right-short fs-5"></i>
                  </span>
                </div>
              </div>
            </a>
          </div>
        @empty
          <!-- Empty State Sarana & Prasarana -->
          <div class="col-12">
            <div class="p-5 text-center rounded-4 border border-subtle bg-body-tertiary">
              <i class="bi bi-building-x fs-1 text-muted opacity-50 mb-3 d-block"></i>
              <h5 class="fw-bold text-main mb-1 fs-6">Belum Ada Sarana & Prasarana</h5>
              <p class="text-muted-custom fs-7 mb-0">Data fasilitas publik daerah belum tersedia saat ini.</p>
            </div>
          </div>
        @endforelse
      </div>

    </div>
  </section>


  <!-- SECTION: EKSPLORASI WILAYAH & DEMOGRAFI (SIMSALABIM) -->
  <section class="py-5" id="eksplorasi-wilayah">
    <div class="container py-2">

      <!-- Section Header -->
      <div class="row align-items-end mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              PETA & DEMOGRAFI
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Eksplorasi Wilayah Solok Selatan</h2>
          <p class="text-body-secondary mb-0 fs-7">
            Peta interaktif 7 kecamatan dengan indikator kependudukan, rasio keluarga, dan dasawisma terintegrasi SIMSALABIM.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <!-- Kecamatan Dropdown Selector Pill -->
          <div class="position-relative d-inline-block">
            <select id="kecamatan-selector" class="demografi-select-pill" aria-label="Pilih Kecamatan">
              <option value="all">Seluruh Solok Selatan</option>
              <option value="1">Kec. Sangir</option>
              <option value="5">Kec. Sungai Pagu</option>
              <option value="7">Kec. Koto Parik Gadang Diateh</option>
              <option value="2">Kec. Sangir Jujuan</option>
              <option value="4">Kec. Sangir Batang Hari</option>
              <option value="6">Kec. Pauh Duo</option>
              <option value="3">Kec. Sangir Balai Janggo</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Main Explorer Layout -->
      <div class="row g-4 align-items-center">

        <!-- Left Column: Interactive Map Card -->
        <div class="col-lg-7">
          <div class="solsel-map-card">
            <div class="solsel-map-watermark"></div>

            <!-- Reset Button -->
            <button type="button" class="solsel-reset-btn" id="btn-reset-map" title="Tampilkan Seluruh Wilayah Solok Selatan">
              <i class="bi bi-arrow-counterclockwise"></i> Seluruh Wilayah
            </button>

            <!-- Vector Map SVG -->
            <svg class="solsel-map-svg" viewBox="0 0 800 680" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <filter id="map-glow" x="-10%" y="-10%" width="120%" height="120%">
                  <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#000000" flood-opacity="0.35" />
                </filter>
              </defs>

              <!-- 7 Kecamatan Paths -->
              <g filter="url(#map-glow)" id="solsel-kec-paths-group">
                <path class="solsel-kec-path" id="kec-path-1" data-id="1" data-name="Sangir" d="M347.2,383.2 L383.2,396.6 L408.1,416.3 L409.0,440.0 L415.8,448.8 L433.8,457.9 L440.6,452.8 L453.2,460.4 L465.2,459.1 L473.8,467.4 L476.6,462.0 L483.2,464.1 L487.8,474.9 L509.3,480.4 L482.2,547.5 L486.0,582.0 L500.9,597.2 L497.7,604.9 L476.5,594.1 L446.3,598.6 L441.5,610.5 L423.7,615.2 L389.0,610.9 L369.0,631.7 L355.8,629.5 L347.3,635.0 L331.6,622.7 L326.9,594.7 L308.9,623.1 L283.7,602.4 L290.6,586.5 L291.8,540.1 L301.3,523.6 L295.6,514.5 L299.4,496.2 L308.3,475.8 L327.4,462.1 L320.6,443.5 L335.2,431.3 L318.5,417.3 L333.7,399.7 L331.6,393.6 L347.2,383.2 Z" />
                <path class="solsel-kec-path" id="kec-path-5" data-id="5" data-name="Sungai Pagu" d="M324.7,341.0 L336.0,343.2 L333.7,363.5 L343.3,375.2 L302.8,426.9 L305.4,435.2 L279.4,430.0 L273.6,441.0 L245.5,459.2 L225.7,458.1 L203.3,480.0 L198.6,502.4 L181.5,524.6 L186.7,503.9 L156.2,473.0 L150.0,436.0 L182.5,412.2 L195.5,410.2 L212.6,372.7 L232.4,372.9 L229.6,356.1 L234.9,346.3 L295.2,337.2 L324.7,341.0 Z" />
                <path class="solsel-kec-path" id="kec-path-7" data-id="7" data-name="Koto Parik Gadang Diateh" d="M192.4,265.7 L221.5,268.6 L247.7,287.3 L270.0,280.5 L308.4,289.5 L318.0,285.0 L318.8,290.1 L295.2,337.2 L232.3,347.8 L232.4,372.9 L211.3,373.8 L195.5,410.2 L182.5,412.2 L150.0,436.0 L135.6,433.6 L116.6,418.7 L117.7,387.4 L101.6,369.2 L92.1,369.4 L81.9,360.1 L93.2,343.9 L78.2,317.0 L83.5,312.8 L83.5,289.2 L96.3,278.1 L119.7,272.4 L147.9,284.7 L156.5,296.6 L174.2,285.8 L172.8,252.6 L192.4,265.7 Z" />
                <path class="solsel-kec-path" id="kec-path-2" data-id="2" data-name="Sangir Jujuan" d="M466.3,357.9 L509.3,366.2 L513.3,374.5 L495.9,388.8 L497.9,400.0 L509.6,402.2 L522.8,395.4 L518.7,444.4 L527.1,460.9 L510.0,470.5 L508.5,479.5 L487.8,474.9 L483.2,464.1 L476.6,462.0 L473.8,467.4 L465.2,459.1 L453.2,460.4 L440.6,452.8 L433.8,457.9 L415.8,448.8 L409.0,440.0 L409.2,417.8 L389.0,405.7 L388.4,399.8 L349.1,382.8 L335.7,388.8 L343.3,375.2 L333.7,363.5 L336.0,343.2 L295.2,337.2 L310.3,301.6 L412.9,330.3 L466.3,357.9 Z" />
                <path class="solsel-kec-path" id="kec-path-4" data-id="4" data-name="Sangir Batang Hari" d="M530.8,45.8 L542.5,48.6 L547.8,64.7 L532.2,86.6 L532.3,110.6 L509.6,141.2 L501.0,170.9 L515.3,199.5 L539.7,212.8 L537.2,237.7 L554.1,252.2 L554.8,270.6 L601.7,289.4 L592.3,319.0 L581.3,321.6 L564.0,312.3 L549.2,332.7 L529.4,344.2 L519.7,363.7 L502.6,366.2 L473.5,361.6 L412.9,330.3 L310.3,301.6 L326.2,271.0 L338.9,280.1 L346.9,270.9 L369.1,281.9 L381.9,274.2 L385.6,255.6 L360.0,244.0 L371.3,214.8 L343.8,174.7 L332.3,172.6 L315.3,150.6 L306.8,124.0 L332.6,127.5 L360.8,163.6 L381.6,157.1 L386.2,176.5 L410.4,182.5 L415.9,157.5 L458.0,147.5 L449.2,105.6 L456.3,89.0 L452.8,75.4 L492.5,74.3 L512.3,62.4 L518.2,45.0 L530.8,45.8 Z" />
                <path class="solsel-kec-path" id="kec-path-6" data-id="6" data-name="Pauh Duo" d="M336.9,392.3 L318.5,417.3 L335.2,431.3 L320.6,443.5 L327.4,462.1 L308.3,475.8 L299.4,496.2 L295.6,514.5 L301.3,523.6 L291.8,540.1 L285.4,600.0 L223.7,579.8 L218.7,567.9 L223.6,561.3 L187.6,541.0 L180.6,528.2 L198.6,502.4 L203.3,480.0 L225.7,458.1 L242.9,460.2 L273.6,441.0 L279.4,430.0 L305.4,435.2 L302.8,426.9 L325.2,397.7 L336.9,392.3 Z" />
                <path class="solsel-kec-path" id="kec-path-3" data-id="3" data-name="Sangir Balai Janggo" d="M635.0,306.8 L652.0,306.7 L660.1,326.1 L700.9,341.3 L721.8,360.0 L709.6,360.9 L706.7,368.2 L684.4,378.5 L670.4,398.7 L648.1,407.2 L630.4,404.4 L627.7,419.3 L602.8,438.5 L614.2,461.8 L601.8,473.9 L588.6,510.1 L570.0,515.9 L532.1,554.4 L524.3,566.4 L520.4,595.9 L508.3,591.9 L500.9,597.2 L486.0,582.0 L483.6,535.6 L500.3,512.0 L509.5,471.2 L527.1,460.9 L518.7,444.4 L522.8,395.4 L506.2,402.3 L494.1,392.3 L513.3,374.5 L509.1,366.0 L519.7,363.7 L529.4,344.2 L549.2,332.7 L564.0,312.3 L585.0,321.6 L591.7,315.0 L635.0,306.8 Z" />
              </g>

              <!-- Labels -->
              <g id="solsel-kec-labels-group">
                <text class="solsel-kec-label" id="kec-label-1" x="400" y="550">Sangir</text>
                <text class="solsel-kec-label" id="kec-label-5" x="250" y="415">Sungai Pagu</text>
                <text class="solsel-kec-label" id="kec-label-7" x="180" y="345">KPGD</text>
                <text class="solsel-kec-label" id="kec-label-2" x="420" y="405">Sangir Jujuan</text>
                <text class="solsel-kec-label" id="kec-label-4" x="470" y="250">Sangir Batang Hari</text>
                <text class="solsel-kec-label" id="kec-label-6" x="255" y="525">Pauh Duo</text>
                <text class="solsel-kec-label" id="kec-label-3" x="575" y="420">Sangir Balai Janggo</text>
              </g>
            </svg>

            <!-- Floating Info Badge at Bottom-Left -->
            <div class="solsel-floating-badge" id="solsel-floating-badge">
              <div class="text-body-tertiary fs-8 fw-semibold mb-0 text-uppercase letter-spacing-1" id="badge-title">Keseluruhan Wilayah</div>
              <div class="fw-bold fs-7 text-body-emphasis mb-1" id="badge-subtitle">Solok Selatan</div>
              <div class="fw-bold fs-6 text-primary" id="badge-stat">3.346 hingga 3.346 km²</div>
            </div>

            <!-- Subtle Caption at Bottom-Center -->
            <div class="solsel-map-caption">
              <i class="bi bi-cursor-fill me-1"></i> Klik wilayah kecamatan pada peta untuk memfilter data demografi
            </div>
          </div>
        </div>

        <!-- Right Column: Demographic Cards -->
        <div class="col-lg-5">
          <div class="d-flex flex-column gap-3">

            <!-- Card 1: Kepadatan Penduduk -->
            <div class="solsel-stat-card">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="solsel-stat-title">Kepadatan Penduduk</span>
                <div class="solsel-stat-icon-badge solsel-stat-icon-primary">
                  <i class="bi bi-buildings-fill"></i>
                </div>
              </div>
              <div class="solsel-stat-num" id="stat-warga">160.468</div>
              <div class="solsel-stat-sub mb-3" id="stat-warga-sub">Jiwa/km² (SIMSALABIM 2024)</div>
              <div class="solsel-progress-bar">
                <div class="solsel-progress-fill" id="stat-warga-bar" style="width: 100%;"></div>
              </div>
            </div>

            <!-- Card 2: Rasio Gender / Rumah vs KK -->
            <div class="solsel-stat-card">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="solsel-stat-title">Rasio Hunian & Keluarga</span>
                <div class="solsel-stat-icon-badge solsel-stat-icon-indigo">
                  <i class="bi bi-people-fill"></i>
                </div>
              </div>
              <div class="solsel-ratio-container mb-2">
                <div class="solsel-ratio-segment-left" id="stat-ratio-rumah" style="width: 50.1%;">
                  <i class="bi bi-house-door-fill me-1"></i> <span id="stat-ratio-rumah-text">50.1%</span>
                </div>
                <div class="solsel-ratio-segment-right" id="stat-ratio-kk" style="width: 49.9%;">
                  <span id="stat-ratio-kk-text">49.9%</span> <i class="bi bi-person-vcard-fill ms-1"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between solsel-stat-sub fw-medium">
                <span id="stat-rumah-count"><i class="bi bi-house me-1 text-primary"></i> 47.617 Rumah</span>
                <span id="stat-kk-count"><i class="bi bi-person-vcard me-1" style="color: #8b5cf6;"></i> 47.363 KK</span>
              </div>
            </div>

            <!-- Card 3: Usia Produktif / Kelompok Dasawisma -->
            <div class="solsel-stat-card">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="solsel-stat-title">Kelompok Dasawisma</span>
                <div class="solsel-stat-icon-badge solsel-stat-icon-emerald">
                  <i class="bi bi-mortarboard-fill"></i>
                </div>
              </div>
              <div class="solsel-stat-num" id="stat-dasawisma">2.695</div>
              <div class="solsel-stat-sub mb-3" id="stat-dasawisma-sub">Kelompok Dasawisma Aktif (PKK)</div>
              <div class="solsel-progress-bar mb-2">
                <div class="solsel-progress-fill solsel-progress-fill-emerald" id="stat-dasawisma-bar" style="width: 100%;"></div>
              </div>
              <div class="d-flex align-items-center justify-content-between pt-1">
                <span class="text-body-tertiary fs-8">Status Keaktifan:</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fs-8 fw-semibold" id="stat-kategori-text">Kategori Sangat Tinggi</span>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- SECTION 4: DOKUMENTASI VIDEO & ARTIKEL KOMDIGI -->
  <section class="py-5" id="video-dokumentasi">
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-end mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              MULTIMEDIA & DOKUMENTASI
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Video Dokumentasi Dan Liputan Resmi</h2>
          <p class="text-body-secondary fs-7 mb-0">Rekam jejak audio-visual kegiatan Pemerintah Daerah</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.video.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Lihat Semua Video <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Content Row: Video Cards (lg-8) + Widgets Right Sidebar (lg-4) SEJAJAR -->
      <div class="row g-4 align-items-stretch">

        <!-- Kolom Kiri (lg-8): Video Terbaru Otomatis Besar (Atas) + 3 Video Kecil (Bawah) -->
        <div class="col-lg-8 d-flex flex-column gap-3">
          @php
            $allVideos = collect($videos ?? []);
            $latestVideo = $allVideos->first();
            $otherVideos = $allVideos->skip(1)->take(3);
          @endphp

          @if($latestVideo)
            <!-- Video Utama / Terbaru (Otomatis Tampil Besar) -->
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover">
              <div class="ratio ratio-16x9" style="background-color: #000;">
                <iframe src="{{ $latestVideo->youtube_embed }}" title="{{ $latestVideo->judul }}" allowfullscreen loading="lazy"></iframe>
              </div>
              <div class="card-body p-3 bg-body d-flex flex-wrap align-items-center justify-content-between gap-2 border-top border-subtle">
                <div class="min-w-0 flex-grow-1">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-danger rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                      <i class="bi bi-youtube me-1"></i> Video Terbaru
                    </span>
                    <small class="text-body-secondary fs-8">
                      <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($latestVideo->tanggal ?? now())->translatedFormat('d F Y') }}
                    </small>
                  </div>
                  <h5 class="fw-bold text-body-emphasis line-clamp-1 mb-0 fs-6 fs-md-5" title="{{ $latestVideo->judul }}">
                    {{ $latestVideo->judul }}
                  </h5>
                </div>
              </div>
            </div>

            <!-- 3 Video Kecil di Bawahnya -->
            @if($otherVideos->count() > 0)
              <div class="row g-3">
                @foreach($otherVideos as $video)
                  <div class="col-md-4 col-sm-6 col-12">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100">
                      <div class="ratio ratio-16x9">
                        <iframe src="{{ $video->youtube_embed }}" title="{{ $video->judul }}" allowfullscreen loading="lazy"></iframe>
                      </div>
                      <div class="card-body p-2.5 d-flex flex-column justify-content-between bg-body">
                        <div>
                          <h6 class="fw-bold text-body-emphasis line-clamp-2 mb-1.5 fs-8" title="{{ $video->judul }}">
                            {{ $video->judul }}
                          </h6>
                        </div>
                        <small class="text-body-secondary fs-8 mt-1">
                          <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($video->tanggal ?? now())->translatedFormat('d M Y') }}
                        </small>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          @else
            <!-- Empty State Dokumentasi Video -->
            <div class="p-5 text-center rounded-4 border border-subtle bg-body-tertiary">
              <i class="bi bi-play-btn fs-1 text-danger opacity-50 mb-3 d-block"></i>
              <h5 class="fw-bold text-main mb-1 fs-6">Belum Ada Dokumentasi Video</h5>
              <p class="text-muted-custom fs-7 mb-0">Video kegiatan pemerintah daerah akan dipublikasikan di sini.</p>
            </div>
          @endif
        </div>

        <!-- Kolom Kanan (lg-4): SIMSALABIM di Atas & Widget Berita Komdigi di Bawah -->
        <div class="col-lg-4 d-flex flex-column gap-3">

          {{-- Widget SIMSALABIM PKK Solok Selatan --}}
          <a href="https://simsalabim.solselkab.go.id/" target="_blank" rel="noopener noreferrer"
             class="d-block text-decoration-none rounded-4 overflow-hidden position-relative card-simsalabim-hover shadow-sm flex-shrink-0"
             style="border: 3px solid #eab308; background-color: #ebbc22; height: 230px;"
             title="Klik untuk membuka Website SIMSALABIM PKK Solok Selatan">

            <div class="simsalabim-card-wrapper">
              <div class="simsalabim-iframe-scaler">
                <iframe
                  src="https://simsalabim.solselkab.go.id/"
                  title="SIMSALABIM PKK Solok Selatan"
                  loading="lazy"
                  scrolling="no">
                </iframe>
              </div>
            </div>

            <div class="position-absolute top-0 start-0 w-100 h-100" style="cursor: pointer; z-index: 10;"></div>
          </a>

          {{-- Widget Berita Komdigi (Mengisi Penuh Sisa Kolom agar Sejajar) --}}
          <div class="flex-grow-1 d-flex flex-column" style="min-height: 0;">
            <x-berita-komdigi-widget :limit="10" />
          </div>

        </div>

      </div>

    </div>
  </section>


  <!-- SECTION 5: DOKUMENTASI FOTO (GALERI FOTO - 3x2 Grid) -->
  <section class="py-5">
    <div class="container">
      
      <!-- Section Header -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              GALERI KEGIATAN
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Dokumentasi Foto</h2>
          <p class="text-body-secondary fs-7 mb-0">Kumpulan rekam jejak foto kegiatan Pemerintah</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.galeri.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Lihat Semua Foto <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- 6 Photo Cards Grid (3x2) -->
      <div class="row g-3">
        @forelse(collect($galeris ?? [])->take(6) as $foto)
          @php
            $galeriImg = asset('storage/' . $foto->file_path);
            $fotoDate = \Carbon\Carbon::parse($foto->tanggal)->translatedFormat('d M Y');
          @endphp
          <div class="col-md-4 col-6">
            <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm gallery-photo-card h-100"
                 style="height: 220px;"
                 role="button"
                 tabindex="0"
                 aria-label="Lihat detail foto {{ $foto->judul }}"
                 data-gallery-idx="{{ $loop->index }}"
                 onclick="openGalleryModal({{ $loop->index }})"
                 onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openGalleryModal({{ $loop->index }}); }">
              <img src="{{ $galeriImg }}"
                   alt="{{ $foto->judul }}"
                   class="w-100 h-100 object-fit-cover gallery-card-img"
                   onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">

              <!-- Hover Zoom Overlay Badge -->
              <div class="gallery-hover-overlay">
                <div class="gallery-zoom-badge">
                  <i class="bi bi-arrows-fullscreen"></i>
                  <span>Perbesar Foto</span>
                </div>
              </div>

              <!-- Caption Gradient Overlay -->
              <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white bg-gradient-dark z-2">
                <h6 class="fw-bold mb-0 fs-7 line-clamp-1">{{ $foto->judul }}</h6>
                <small class="text-white-50 fs-8"><i class="bi bi-calendar3 me-1"></i>{{ $fotoDate }}</small>
              </div>
            </div>
          </div>
        @empty
          <!-- Empty State Dokumentasi Foto -->
          <div class="col-12">
            <div class="p-5 text-center rounded-4 border border-subtle bg-body-tertiary">
              <i class="bi bi-images fs-1 text-primary opacity-50 mb-3 d-block"></i>
              <h5 class="fw-bold text-main mb-1 fs-6">Belum Ada Dokumentasi Foto</h5>
              <p class="text-muted-custom fs-7 mb-0">Galeri rekam jejak foto kegiatan pemerintah akan ditampilkan di sini.</p>
            </div>
          </div>
        @endforelse
      </div>

    </div>
  </section>

  <!-- SECTION: UNDUHAN & TRANSPARANSI PUBLIK -->
  <section class="py-5" id="transparansi" style="scroll-margin-top: 100px;">
    <span id="unduhan" style="scroll-margin-top: 100px;"></span>
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
              TRANSPARANSI PUBLIK
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Keterbukaan Informasi Dan Transparansi</h2>
          <p class="text-body-secondary mb-0 fs-7">
            Akses terbuka dokumen regulasi, Laporan Keuangan, LKPJ, Peraturan Daerah, dan Transparansi Tata Kelola.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.unduhan.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Pusat Unduhan Dokumen <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Small Cards Grid (Matching User Mockup) -->
      @php
        $jenisesList = isset($unduhanJenises) && count($unduhanJenises) > 0 
          ? collect($unduhanJenises) 
          : (isset($unduhanKategoris) ? collect($unduhanKategoris) : collect());
          
        $jenisesList = $jenisesList->filter(function($item) {
            return ($item->unduhans_count ?? 0) > 0;
        });
      @endphp

      <div class="row g-4">
        @forelse($jenisesList as $item)
          @php
            $isJenis = isset($item->kategori_unduhan_id) || isset($item->kategori);
            $itemUrl = $isJenis 
              ? route('frontend.unduhan.index', ['jenis' => $item->slug]) 
              : route('frontend.unduhan.index', ['kategori' => $item->slug]);
            $parentKatName = $isJenis && isset($item->kategoriUnduhan) ? $item->kategoriUnduhan->nama : ($item->nama ?? 'Dokumen');
          @endphp
          <div class="col-xl-3 col-lg-4 col-md-6 col-6">
            <a href="{{ $itemUrl }}" class="text-decoration-none d-block h-100 group">
              <div class="p-4 rounded-4 bg-body-tertiary border border-subtle h-100 transition-all card-jds-hover d-flex flex-column justify-content-between shadow-xs" style="min-height: 145px;">
                <!-- Upper Row (Icon + Count Badge) -->
                <div class="d-flex align-items-center justify-content-between mb-3.5">
                  <div class="p-2.5 rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-file-earmark-text-fill fs-3 text-primary"></i>
                  </div>
                </div>

                <!-- Content Title & Subtitle -->
                <div>
                  <h5 class="fw-extrabold text-body-emphasis fs-6 mb-1.5 line-clamp-1 group-hover-primary transition-all leading-snug" title="{{ $item->nama }}">
                    {{ $item->nama }}
                  </h5>
                  <p class="text-muted-custom fs-7 mb-0 line-clamp-1 opacity-75">
                    {{ $parentKatName }}
                  </p>
                </div>
              </div>
            </a>
          </div>
        @empty
          <!-- Empty State Grid -->
          <div class="col-12 text-center py-5">
            <div class="p-5 rounded-4 border border-subtle bg-body-tertiary d-inline-block">
              <i class="bi bi-folder-x display-4 text-muted opacity-50 mb-3 d-block"></i>
              <h5 class="fw-bold text-main mb-1 fs-6">Belum Ada Jenis / Kategori Unduhan</h5>
              <p class="text-muted-custom fs-7 mb-0">Dokumen transparansi publik belum dikategorikan saat ini.</p>
            </div>
          </div>
        @endforelse
      </div>

    </div>
  </section>


  <!-- SECTION 6: AGENDA KEGIATAN, KALENDER, & PENGUMUMAN (3-Column Layout) -->
  <section class="py-5">
    <div class="container">
      <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
            AGENDA & PENGUMUMAN
          </span>
        </div>
        <h2 class="fw-bold text-main mb-1 display-6">Kegiatan Daerah & Pengumuman Resmi</h2>
        <p class="text-body-secondary mb-0 fs-7">
          Informasi kegiatan dan pengumuman resmi pemerintah daerah Solok Selatan.
        </p>
      </div>

      <div class="row g-4">
        
        <!-- Left Side (col-lg-4): Agenda Kegiatan -->
        <div class="col-lg-4">
          <div class="glass-card p-4 shadow-sm h-100 d-flex flex-column justify-content-between rounded-4 bg-body border-0">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
                <div class="d-flex align-items-center gap-2">
                  <div class="p-2 rounded-3 text-primary bg-primary-subtle">
                    <i class="bi bi-calendar-event fs-5"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-main mb-0 fs-6">Agenda Kegiatan</h5>
                    <small class="text-muted-custom fs-8">Jadwal kegiatan mendatang</small>
                  </div>
                </div>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                  {{ isset($agendas) ? $agendas->count() : 0 }} Agenda
                </span>
              </div>

              @if(isset($agendas) && $agendas->count())
                <div class="d-flex flex-column gap-3">
                  @foreach(collect($agendas)->take(3) as $agenda)
                    @php
                      $isOngoing = $agenda->status === 'ongoing';
                      $isUpcoming = $agenda->status === 'upcoming';
                    @endphp
                    <a href="{{ route('frontend.agenda.detail', $agenda->slug) }}" class="text-decoration-none group">
                      <div class="p-3 rounded-4 transition-all card-jds-hover border border-subtle {{ $isOngoing ? 'border-success border-opacity-75 bg-success-subtle bg-opacity-20' : 'bg-body-tertiary' }}">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                          @if($isOngoing)
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1 fs-8 fw-bold d-inline-flex align-items-center shadow-sm">
                              <span class="spinner-grow spinner-grow-sm text-light me-1.5" style="width: 6px; height: 6px;" role="status"></span>
                              Berlangsung
                            </span>
                          @elseif($isUpcoming)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                              <i class="bi bi-clock me-1"></i> Akan Datang
                            </span>
                          @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                              <i class="bi bi-check-circle me-1"></i> Selesai
                            </span>
                          @endif
                          <span class="text-body-secondary fs-8 fw-semibold">
                            <i class="bi bi-calendar3 me-1 text-primary"></i>
                            {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d M Y') }}
                          </span>
                        </div>
                        <h6 class="fw-bold text-body-emphasis fs-7 mb-1 line-clamp-2 leading-snug group-hover-primary transition-all">
                          {{ $agenda->title }}
                        </h6>
                      </div>
                    </a>
                  @endforeach
                </div>
              @else
                <div class="text-center py-4 my-auto text-muted-custom">
                  <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i>
                  <p class="fs-8 mb-0">Belum ada agenda kegiatan terbaru.</p>
                </div>
              @endif
            </div>

            <div class="pt-3 mt-4 border-top border-subtle text-end">
              <a href="{{ route('frontend.agenda.index') }}" class="btn btn-glass-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-2">
                Lihat Semua Agenda <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Center Side (col-lg-4): Kalender Kegiatan -->
        <div class="col-lg-4">
          <div class="glass-card p-4 shadow-sm h-100 d-flex flex-column justify-content-between rounded-4 bg-body border-0">
            <div>
              <!-- Calendar Header -->
              <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-subtle">
                <div class="d-flex align-items-center gap-2">
                  <div class="p-2 rounded-3 text-info bg-info-subtle">
                    <i class="bi bi-calendar3 fs-5"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-main mb-0 fs-6">Kalender</h5>
                    <small class="text-muted-custom fs-8" id="calendar-month-year">Kalender Kegiatan</small>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-1">
                  <button type="button" id="cal-prev-btn" class="btn btn-sm btn-glass-icon p-1" title="Bulan Sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                  </button>
                  <button type="button" id="cal-next-btn" class="btn btn-sm btn-glass-icon p-1" title="Bulan Berikutnya">
                    <i class="bi bi-chevron-right"></i>
                  </button>
                </div>
              </div>

              <!-- Day Names -->
              <div style="display: grid; grid-template-columns: repeat(7, 1fr);" class="text-center fw-bold fs-8 text-body-secondary mb-2 py-1 bg-body-tertiary rounded-3">
                <span class="text-danger">Min</span>
                <span>Sen</span>
                <span>Sel</span>
                <span>Rab</span>
                <span>Kam</span>
                <span>Jum</span>
                <span class="text-primary">Sab</span>
              </div>

              <!-- Days Grid -->
              <div id="calendar-days-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px;">
                <!-- JS Populated -->
              </div>

              <!-- Event Details Card -->
              <div id="calendar-event-detail" class="mt-3.5 mb-3 p-3 rounded-3 bg-body-tertiary border border-subtle d-none">
                <small class="fw-bold text-primary d-block fs-8 mb-1.5" id="cal-detail-date"></small>
                <div class="fs-8 text-body-emphasis line-clamp-3 lh-base" id="cal-detail-title"></div>
              </div>
            </div>

            <!-- Calendar Footer Legend -->
            <div class="pt-3 mt-3 border-top border-subtle d-flex align-items-center justify-content-between fs-8 text-muted-custom">
              <span class="d-inline-flex align-items-center gap-1.5">
                <span class="rounded-circle bg-warning" style="width: 7px; height: 7px; display: inline-block;"></span> Agenda
              </span>
              <span class="d-inline-flex align-items-center gap-1.5">
                <span class="rounded-circle bg-primary" style="width: 7px; height: 7px; display: inline-block;"></span> Hari Ini
              </span>
            </div>
          </div>
        </div>

        <!-- Right Side (col-lg-4): Pengumuman -->
        <div class="col-lg-4">
          <div class="glass-card p-4 shadow-sm h-100 d-flex flex-column justify-content-between rounded-4 bg-body border-0">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
                <div class="d-flex align-items-center gap-2">
                  <div class="p-2 rounded-3 text-warning bg-warning-subtle">
                    <i class="bi bi-megaphone fs-5"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-main mb-0 fs-6">Pengumuman</h5>
                    <small class="text-muted-custom fs-8">Informasi resmi Pemda</small>
                  </div>
                </div>
                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                  {{ isset($pengumumen) ? $pengumumen->count() : 0 }} Pengumuman
                </span>
              </div>

              @if(isset($pengumumen) && $pengumumen->count())
                <div class="d-flex flex-column gap-3">
                  @foreach(collect($pengumumen)->take(3) as $pengumuman)
                    <a href="{{ route('frontend.pengumuman.detail', $pengumuman->slug) }}" class="text-decoration-none group">
                      <div class="p-3 rounded-4 transition-all card-jds-hover border border-subtle bg-body-tertiary">
                        <div class="d-flex align-items-start gap-3">
                          <div class="rounded-3 flex-shrink-0 overflow-hidden bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-megaphone fs-5 text-warning"></i>
                          </div>
                          <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold text-body-emphasis fs-7 mb-1 line-clamp-2 leading-snug group-hover-primary transition-all">
                              {{ $pengumuman->title }}
                            </h6>
                            <small class="text-body-secondary fs-8">
                              <i class="bi bi-clock me-1"></i> {{ $pengumuman->created_at ? $pengumuman->created_at->translatedFormat('d M Y') : date('d M Y') }}
                            </small>
                          </div>
                        </div>
                      </div>
                    </a>
                  @endforeach
                </div>
              @else
                <div class="text-center py-4 my-auto text-muted-custom">
                  <i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i>
                  <p class="fs-8 mb-0">Belum ada pengumuman terbaru.</p>
                </div>
              @endif
            </div>

            <div class="pt-3 mt-4 border-top border-subtle text-end">
              <a href="{{ route('frontend.pengumuman.index') }}" class="btn btn-glass-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-2">
                Lihat Semua Pengumuman <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- SECTION 7: APLIKASI DINAS -->
  <section class="py-5">
    <div class="container py-4">
      <!-- Section Header -->
      <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-1.5">
            EKOSISTEM DIGITAL
          </span>
        </div>
        <h2 class="fw-bold text-main display-6 mb-2">Aplikasi Dinas</h2>
        <p class="text-muted-custom fs-6">Inovasi dan ekosistem digital terpadu untuk efisiensi pelayanan masyarakat</p>
      </div>

      <!-- Horizontal Application List -->
      <div class="app-horizontal-scroll d-flex flex-nowrap gap-4 overflow-x-auto pb-3 px-1" data-auto-scroll>
        @forelse($aplikasis as $aplikasi)
          <div class="app-horizontal-item flex-shrink-0">
            <a href="{{ $aplikasi->url }}" target="_blank" rel="noopener noreferrer" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center group">

              <!-- Lingkaran Icon -->
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-grid-fill fs-3 text-primary"></i>
              </div>

              <!-- Nama Aplikasi di Bawah -->
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">
                {{ $aplikasi->nama }}
              </h6>

            </a>
          </div>
        @empty
          <!-- Empty State Aplikasi Dinas -->
          <div class="w-100 text-center py-4 my-2">
            <div class="d-inline-flex flex-column align-items-center p-4 rounded-4 bg-body-tertiary border border-subtle">
              <i class="bi bi-grid-fill fs-1 text-muted opacity-50 mb-2"></i>
              <h6 class="fw-bold text-main mb-1 fs-7">Belum Ada Aplikasi Dinas</h6>
              <p class="text-muted-custom fs-8 mb-0">Inovasi dan ekosistem aplikasi dinas akan ditampilkan di sini saat data telah diinput.</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </section>

@endsection

@section('scripts')
  <!-- Featured News Swiper & Auto Scroll Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Initialize Featured News Swiper Slider
      const featuredNewsSwiper = new Swiper('.featuredNewsSwiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.btn-news-next',
          prevEl: '.btn-news-prev',
        },
        pagination: {
          el: '.featured-news-pagination',
          clickable: true,
        },
      });

      // Seamless Infinite Auto Scroll for Circular App Lists (Layanan Publik & Aplikasi Dinas)
      const autoScrollElems = document.querySelectorAll('[data-auto-scroll]');

      autoScrollElems.forEach((appScroll) => {
        const originalItems = Array.from(appScroll.querySelectorAll('.app-horizontal-item'));
        if (originalItems.length === 0) return;

        const originalCount = originalItems.length;

        // Gandakan (clone) item untuk menciptakan loop tanpa ujung yang sempurna
        const cloneSet = () => {
          originalItems.forEach((item) => {
            const clone = item.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true');
            appScroll.appendChild(clone);
          });
        };

        // Clone set pertama
        cloneSet();

        // Jika lebar total belum mencukupi 2.5x lebar container, gandakan lagi
        if (appScroll.scrollWidth < appScroll.clientWidth * 2.5) {
          cloneSet();
        }

        let singleSetWidth = 0;
        const calculateSetWidth = () => {
          const firstItem = originalItems[0];
          const firstClone = appScroll.children[originalCount];
          if (firstItem && firstClone) {
            singleSetWidth = firstClone.offsetLeft - firstItem.offsetLeft;
          }
        };

        calculateSetWidth();
        window.addEventListener('resize', calculateSetWidth, { passive: true });
        window.addEventListener('load', calculateSetWidth, { passive: true });

        let isPaused = false;
        let lastTimestamp = 0;
        let scrollPos = appScroll.scrollLeft;
        const speed = 0.04; // pixel per ms (~40px/detik, halus & nyaman dibaca)

        const autoScroll = (timestamp) => {
          if (!lastTimestamp) {
            lastTimestamp = timestamp;
          }

          const elapsed = timestamp - lastTimestamp;
          lastTimestamp = timestamp;

          if (!isPaused && singleSetWidth > 0) {
            scrollPos += elapsed * speed;

            // Reset mulus: saat telah berjalan sepanjang 1 set item, kurangi dengan singleSetWidth
            // Karena item di posisi clone identik dengan item awal, transisinya 100% tanpa jeda/lompatan
            if (scrollPos >= singleSetWidth) {
              scrollPos -= singleSetWidth;
            }

            appScroll.scrollLeft = scrollPos;
          }

          window.requestAnimationFrame(autoScroll);
        };

        // Pause saat kursor hover atau jari menyentuh
        ['mouseenter', 'touchstart', 'pointerdown'].forEach((eventName) => {
          appScroll.addEventListener(eventName, () => {
            isPaused = true;
          }, { passive: true });
        });

        ['mouseleave', 'touchend', 'pointerup', 'pointercancel'].forEach((eventName) => {
          appScroll.addEventListener(eventName, () => {
            if (singleSetWidth > 0) {
              scrollPos = appScroll.scrollLeft % singleSetWidth;
            }
            isPaused = false;
            lastTimestamp = 0;
          }, { passive: true });
        });

        // Sinkronkan posisi scroll saat pengguna melakukan swipe manual
        appScroll.addEventListener('scroll', () => {
          if (isPaused && singleSetWidth > 0) {
            scrollPos = appScroll.scrollLeft % singleSetWidth;
          }
        }, { passive: true });

        window.requestAnimationFrame(autoScroll);
      });
    });
  </script>

  <!-- Interactive Calendar Controller Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const rawAgendas = @json($agendas ?? []);

      // Format events map by YYYY-MM-DD
      const eventsMap = {};
      if (Array.isArray(rawAgendas)) {
        rawAgendas.forEach(item => {
          if (item.start_date) {
            const dateStr = item.start_date.split('T')[0].split(' ')[0];
            if (!eventsMap[dateStr]) eventsMap[dateStr] = [];
            eventsMap[dateStr].push(item);
          }
        });
      }

      let currentDate = new Date();
      let currentMonth = currentDate.getMonth();
      let currentYear = currentDate.getFullYear();

      const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];

      const monthYearElem = document.getElementById('calendar-month-year');
      const daysGridElem = document.getElementById('calendar-days-grid');
      const prevBtn = document.getElementById('cal-prev-btn');
      const nextBtn = document.getElementById('cal-next-btn');
      const eventDetailElem = document.getElementById('calendar-event-detail');
      const detailDateElem = document.getElementById('cal-detail-date');
      const detailTitleElem = document.getElementById('cal-detail-title');

      if (!daysGridElem) return;

      function renderCalendar(month, year) {
        if (monthYearElem) monthYearElem.textContent = `${monthNames[month]} ${year}`;
        daysGridElem.innerHTML = '';

        const firstDay = new Date(year, month, 1).getDay(); // 0 = Sun
        const totalDays = new Date(year, month + 1, 0).getDate();

        const today = new Date();
        const isCurrentMonthYear = today.getMonth() === month && today.getFullYear() === year;
        const todayDate = today.getDate();

        // Empty cells before day 1
        for (let i = 0; i < firstDay; i++) {
          const emptyCell = document.createElement('div');
          emptyCell.className = 'cal-day-cell empty';
          daysGridElem.appendChild(emptyCell);
        }

        // Days 1..totalDays
        for (let day = 1; day <= totalDays; day++) {
          const dayCell = document.createElement('div');
          dayCell.className = 'cal-day-cell';
          dayCell.textContent = day;

          const monthStr = String(month + 1).padStart(2, '0');
          const dayStr = String(day).padStart(2, '0');
          const formattedDate = `${year}-${monthStr}-${dayStr}`;

          if (isCurrentMonthYear && day === todayDate) {
            dayCell.classList.add('today');
          }

          if (eventsMap[formattedDate]) {
            dayCell.classList.add('has-event');
            dayCell.title = `${eventsMap[formattedDate].length} Agenda: ${eventsMap[formattedDate][0].title}`;
          }

          dayCell.addEventListener('click', () => {
            document.querySelectorAll('.cal-day-cell').forEach(c => c.classList.remove('selected'));
            dayCell.classList.add('selected');

            if (eventsMap[formattedDate]) {
              eventDetailElem.classList.remove('d-none');
              detailDateElem.textContent = `📅 ${day} ${monthNames[month]} ${year}`;
              detailTitleElem.innerHTML = eventsMap[formattedDate].map(e => `
                <div class="mb-1 fw-semibold">
                  <a href="/detail/agenda/${e.slug}" class="text-decoration-none text-primary">
                    <i class="bi bi-calendar-event me-1"></i> ${e.title}
                  </a>
                </div>
              `).join('');
            } else {
              eventDetailElem.classList.remove('d-none');
              detailDateElem.textContent = `📅 ${day} ${monthNames[month]} ${year}`;
              detailTitleElem.innerHTML = '<span class="text-muted-custom">Tidak ada agenda kegiatan pada tanggal ini.</span>';
            }
          });

          daysGridElem.appendChild(dayCell);
        }
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', () => {
          currentMonth--;
          if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
          }
          renderCalendar(currentMonth, currentYear);
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', () => {
          currentMonth++;
          if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
          }
          renderCalendar(currentMonth, currentYear);
        });
      }

      renderCalendar(currentMonth, currentYear);
    });
  </script>

  <!-- Solok Selatan Interactive Regional Explorer Script (SIMSALABIM Real-time) -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Server-rendered Initial SIMSALABIM Data
      let solselData = @json($simsalabimData ?? []);

      // Number formatting helper
      const formatNum = (num) => new Intl.NumberFormat('id-ID').format(num || 0);

      // DOM Elements
      const selector = document.getElementById('kecamatan-selector');
      const resetBtn = document.getElementById('btn-reset-map');

      const paths = document.querySelectorAll('.solsel-kec-path');
      const labels = document.querySelectorAll('.solsel-kec-label');

      const badgeTitle = document.getElementById('badge-title');
      const badgeSubtitle = document.getElementById('badge-subtitle');
      const badgeStat = document.getElementById('badge-stat');

      const statWarga = document.getElementById('stat-warga');
      const statWargaSub = document.getElementById('stat-warga-sub');
      const statWargaBar = document.getElementById('stat-warga-bar');

      const statRatioRumah = document.getElementById('stat-ratio-rumah');
      const statRatioRumahText = document.getElementById('stat-ratio-rumah-text');
      const statRatioKk = document.getElementById('stat-ratio-kk');
      const statRatioKkText = document.getElementById('stat-ratio-kk-text');
      const statRumahCount = document.getElementById('stat-rumah-count');
      const statKkCount = document.getElementById('stat-kk-count');

      const statDasawisma = document.getElementById('stat-dasawisma');
      const statDasawismaSub = document.getElementById('stat-dasawisma-sub');
      const statDasawismaBar = document.getElementById('stat-dasawisma-bar');
      const statKategoriText = document.getElementById('stat-kategori-text');

      // Update UI Function
      function updateDisplay(key, animate = true) {
        if (!solselData || !solselData['all']) return;

        const item = solselData[key] || solselData['all'];
        const isAll = key === 'all';

        // Update Bottom-Left Floating Badge
        if (badgeTitle) badgeTitle.textContent = isAll ? 'Keseluruhan Wilayah' : 'Kecamatan';
        if (badgeSubtitle) badgeSubtitle.textContent = isAll ? 'Solok Selatan' : item.name.replace('Kecamatan ', '');
        if (badgeStat) badgeStat.textContent = item.area;

        // Card 1: Warga / Penduduk
        if (statWarga) {
          if (animate) {
            statWarga.style.transition = 'opacity 0.2s ease';
            statWarga.style.opacity = '0.35';
            setTimeout(() => {
              statWarga.textContent = formatNum(item.warga);
              statWarga.style.opacity = '1';
            }, 120);
          } else {
            statWarga.textContent = formatNum(item.warga);
          }
        }
        if (statWargaSub) {
          statWargaSub.textContent = isAll 
            ? `Jiwa (Kepadatan: ${item.density})` 
            : `Jiwa/km² (${item.density} • Luas: ${item.area})`;
        }
        if (statWargaBar) {
          const totalWarga = solselData['all'] ? solselData['all'].warga : 160468;
          const pct = isAll ? 100 : Math.min(100, Math.round((item.warga / totalWarga) * 100 * 2.5));
          statWargaBar.style.width = pct + '%';
        }

        // Card 2: Rasio Rumah vs KK
        const totalUnit = (item.rumah || 0) + (item.kk || 0);
        const rumahPct = totalUnit > 0 ? ((item.rumah / totalUnit) * 100).toFixed(1) : '50.1';
        const kkPct = (100 - parseFloat(rumahPct)).toFixed(1);

        if (statRatioRumah) statRatioRumah.style.width = rumahPct + '%';
        if (statRatioRumahText) statRatioRumahText.textContent = `${rumahPct}%`;
        if (statRatioKk) statRatioKk.style.width = kkPct + '%';
        if (statRatioKkText) statRatioKkText.textContent = `${kkPct}%`;

        if (statRumahCount) statRumahCount.innerHTML = `<i class="bi bi-house me-1 text-primary"></i> ${formatNum(item.rumah)} Rumah`;
        if (statKkCount) statKkCount.innerHTML = `<i class="bi bi-person-vcard me-1" style="color: #8b5cf6;"></i> ${formatNum(item.kk)} KK`;

        // Card 3: Dasawisma
        if (statDasawisma) {
          if (animate) {
            statDasawisma.style.transition = 'opacity 0.2s ease';
            statDasawisma.style.opacity = '0.35';
            setTimeout(() => {
              statDasawisma.textContent = formatNum(item.dasawisma);
              statDasawisma.style.opacity = '1';
            }, 120);
          } else {
            statDasawisma.textContent = formatNum(item.dasawisma);
          }
        }
        if (statDasawismaSub) statDasawismaSub.textContent = `Kelompok Dasawisma Aktif (PKK)`;
        if (statDasawismaBar) {
          const totalDasa = solselData['all'] ? solselData['all'].dasawisma : 2695;
          const dasaPct = isAll ? 100 : Math.min(100, Math.round((item.dasawisma / totalDasa) * 100 * 2.5));
          statDasawismaBar.style.width = dasaPct + '%';
        }
        if (statKategoriText) statKategoriText.textContent = item.kategori;

        // Map Highlights
        paths.forEach(p => {
          if (!isAll && p.getAttribute('data-id') === key) {
            p.classList.add('active');
          } else {
            p.classList.remove('active');
          }
        });

        labels.forEach(lbl => {
          if (!isAll && lbl.id === `kec-label-${key}`) {
            lbl.classList.add('active-label');
          } else {
            lbl.classList.remove('active-label');
          }
        });

        if (selector && selector.value !== key) {
          selector.value = key;
        }
      }

      // Real-time Fetch Function from server proxy
      async function syncSimsalabimRealtime(silent = true) {
        try {
          const url = '{{ route("api.simsalabim.data") }}?fresh=1';
          const res = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            cache: 'no-store'
          });

          if (res.ok) {
            const freshData = await res.json();
            if (freshData && freshData.all) {
              solselData = freshData;
              const currentVal = selector ? selector.value : 'all';
              updateDisplay(currentVal, !silent);
            }
          }
        } catch (err) {
          console.warn('Gagal sinkronisasi data real-time SIMSALABIM:', err);
        }
      }

      // Event listener: Dropdown selector
      if (selector) {
        selector.addEventListener('change', (e) => {
          updateDisplay(e.target.value);
        });
      }

      // Event listener: Map path clicks
      paths.forEach(path => {
        path.addEventListener('click', () => {
          const sid = path.getAttribute('data-id');
          if (selector) selector.value = sid;
          updateDisplay(sid);
        });
      });

      // Event listener: Reset button
      if (resetBtn) {
        resetBtn.addEventListener('click', () => {
          if (selector) selector.value = 'all';
          updateDisplay('all');
        });
      }

      // Initial view: default to all Solok Selatan
      updateDisplay('all', false);

      // Auto-sync fresh real-time data silently in background immediately on page load
      syncSimsalabimRealtime(true);

      // Periodic Real-Time Polling: Check every 25 seconds in background
      setInterval(() => {
        if (!document.hidden) {
          syncSimsalabimRealtime(true);
        }
      }, 25000);

      // Instant Re-sync when user returns to tab
      document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
          syncSimsalabimRealtime(true);
        }
      });
    });

    // =========================================================
    // IMAGE DETAIL LIGHTBOX MODAL SCRIPT
    // =========================================================
    const galleryItems = [
      @foreach(collect($galeris ?? [])->take(6) as $foto)
        {
          img: '{{ asset('storage/' . $foto->file_path) }}',
          title: @json($foto->judul),
          date: '{{ \Carbon\Carbon::parse($foto->tanggal)->translatedFormat('d F Y') }}',
          category: 'Dokumentasi Foto',
          link: '{{ route('frontend.galeri.index') }}'
        }@if(!$loop->last),@endif
      @endforeach
    ];

    let currentGalleryIdx = 0;
    let isGalleryMode = true;

    window.openGalleryModal = function(idx) {
      if (!galleryItems.length) return;
      isGalleryMode = true;
      currentGalleryIdx = idx;
      showModalItem(galleryItems[currentGalleryIdx]);

      const prevBtn = document.getElementById('btnModalPrev');
      const nextBtn = document.getElementById('btnModalNext');

      if (prevBtn) prevBtn.style.display = galleryItems.length > 1 ? 'flex' : 'none';
      if (nextBtn) nextBtn.style.display = galleryItems.length > 1 ? 'flex' : 'none';

      const modalEl = document.getElementById('imageDetailModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();
      }
    };

    window.openSingleImageModal = function(el) {
      isGalleryMode = false;
      const item = {
        img: el.getAttribute('data-img'),
        title: el.getAttribute('data-title'),
      };
      showModalItem(item);

      const prevBtn = document.getElementById('btnModalPrev');
      const nextBtn = document.getElementById('btnModalNext');

      if (prevBtn) prevBtn.style.display = 'none';
      if (nextBtn) nextBtn.style.display = 'none';

      const modalEl = document.getElementById('imageDetailModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();
      }
    };

    function showModalItem(item) {
      const displayImg = document.getElementById('imgModalDisplay');
      const modalTitle = document.getElementById('imgModalTitle');

      if (displayImg) {
        displayImg.style.opacity = '0.2';
        displayImg.style.transform = 'scale(0.98)';
        setTimeout(() => {
          displayImg.src = item.img;
          displayImg.alt = item.title;
          displayImg.style.opacity = '1';
          displayImg.style.transform = 'scale(1)';
        }, 100);
      }

      if (modalTitle) {
        modalTitle.textContent = item.title;
      }
    }

    window.navigateGallery = function(direction) {
      if (!isGalleryMode || !galleryItems.length) return;
      currentGalleryIdx = (currentGalleryIdx + direction + galleryItems.length) % galleryItems.length;
      showModalItem(galleryItems[currentGalleryIdx]);
    };

    // Tombol Perbesar (Toggle Fullscreen)
    window.togglePopupFullscreen = function() {
      const card = document.getElementById('popupSingleCard');
      const icon = document.getElementById('zoomIcon');
      if (!card) return;

      if (!document.fullscreenElement) {
        if (card.requestFullscreen) {
          card.requestFullscreen();
        } else if (card.webkitRequestFullscreen) {
          card.webkitRequestFullscreen();
        } else if (card.msRequestFullscreen) {
          card.msRequestFullscreen();
        }
        if (icon) {
          icon.classList.remove('bi-arrows-fullscreen');
          icon.classList.add('bi-fullscreen-exit');
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
        if (icon) {
          icon.classList.remove('bi-fullscreen-exit');
          icon.classList.add('bi-arrows-fullscreen');
        }
      }
    };

    document.addEventListener('fullscreenchange', function() {
      const icon = document.getElementById('zoomIcon');
      if (!document.fullscreenElement && icon) {
        icon.classList.remove('bi-fullscreen-exit');
        icon.classList.add('bi-arrows-fullscreen');
      }
    });

    // Keyboard navigation (ArrowLeft, ArrowRight)
    document.addEventListener('keydown', function(e) {
      const modalEl = document.getElementById('imageDetailModal');
      if (modalEl && modalEl.classList.contains('show')) {
        if (e.key === 'ArrowLeft') {
          navigateGallery(-1);
        } else if (e.key === 'ArrowRight') {
          navigateGallery(1);
        }
      }
    });
  </script>

  <!-- Modal Detail Gambar Pop-up (1 Card Bersama Gambar, Judul, Exit, dan Perbesar) -->
  <div class="modal fade image-lightbox-modal" id="imageDetailModal" tabindex="-1" aria-labelledby="imgModalTitle" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content; margin: 1.75rem auto;">
      <div class="modal-content bg-transparent border-0 shadow-none">
        <div class="popup-single-card" id="popupSingleCard">

          <!-- Area Gambar, Navigasi, Action Buttons, dan Judul Menyatu 1 Card -->
          <div class="popup-card-media position-relative text-center">
            <!-- Floating Action Buttons: Tombol Perbesar & Exit (Tepat di pojok kanan atas gambar) -->
            <div class="popup-card-actions">
              <!-- Tombol Perbesar (Fullscreen) -->
              <button type="button" class="btn-popup-ctrl" id="btnToggleZoom" title="Perbesar Layar Penuh" onclick="togglePopupFullscreen()">
                <i class="bi bi-arrows-fullscreen" id="zoomIcon"></i>
              </button>
              <!-- Tombol Exit -->
              <button type="button" class="btn-popup-ctrl btn-popup-exit" data-bs-dismiss="modal" aria-label="Tutup" title="Keluar / Tutup">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>

            <!-- Panah Navigasi Sebelumnya -->
            <button type="button" class="btn-modal-nav btn-modal-prev" id="btnModalPrev" aria-label="Foto Sebelumnya" onclick="navigateGallery(-1)">
              <i class="bi bi-chevron-left"></i>
            </button>

            <!-- Gambar Pop-up -->
            <img src="" id="imgModalDisplay" class="popup-img" alt="Detail Gambar" onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">

            <!-- Panah Navigasi Selanjutnya -->
            <button type="button" class="btn-modal-nav btn-modal-next" id="btnModalNext" aria-label="Foto Selanjutnya" onclick="navigateGallery(1)">
              <i class="bi bi-chevron-right"></i>
            </button>

            <!-- Judul Gambar (Overlay Menyatu di bagian bawah gambar) -->
            <div class="popup-card-caption">
              <h5 class="popup-title mb-0" id="imgModalTitle">Judul Foto</h5>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
