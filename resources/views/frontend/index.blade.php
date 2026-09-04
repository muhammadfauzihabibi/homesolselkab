@extends('layouts.frontend')

@section('title', 'Portal Resmi Pemerintah Kabupaten Solok Selatan')

@section('content')

  <!-- HERO SECTION WITH SLIDER -->
  <section class="hero-jds-wrapper position-relative text-white overflow-hidden">
    <!-- Hero Background Image Slider (Ganti-ganti Otomatis) -->
    <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">

      <!-- Container Slide Gambar -->
      <div class="hero-bg-slider w-100 h-100">
        <div class="hero-bg-slide active">
          <img src="{{ asset('images/bg1.jpeg') }}" alt="Gedung Pemkab 1" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="hero-bg-slide">
          <img src="{{ asset('images/bg2.jpeg') }}" alt="Gedung Pemkab 2" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="hero-bg-slide">
          <img src="{{ asset('images/bg3.jpeg') }}" alt="Gedung Pemkab 3" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="hero-bg-slide">
          <img src="{{ asset('images/bg4.jpeg') }}" alt="Gedung Pemkab 4" class="w-100 h-100 object-fit-cover">
        </div>
      </div>

      <!-- Overlay Gradient di Atas Gambar -->
      <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
    </div>

    <div class="container position-relative z-2 pt-5 pb-5 hero-content-container">

      <!-- Headline Text Center -->
      <div class="text-center max-w-3xl mx-auto mt-5 pt-5 mb-5">
        <h1 class="display-4 fw-bold text-white mb-3">
          PESONA ALAM SARANTAU SASURAMBI
        </h1>
        <p class="lead text-white-50 fs-6 fw-normal max-w-2xl mx-auto">
          Wujudkan transformasi digital di Kabupaten Solok Selatan lewat kolaborasi bersama kami menuju daerah yang maju, humanis, dan berkelanjutan.
        </p>
      </div>

      <!-- Swiper Hero Cards Slider (5 Berita Terbaru) -->
      <div class="row align-items-center g-4 position-relative">
        <div class="col-lg-11">
          <div class="swiper heroSwiper overflow-hidden rounded-4">
            <div class="swiper-wrapper">

              @forelse(collect($beritas ?? [])->take(5) as $index => $item)
                @php
                  // Handle Gambar (storage path, URL eksternal, atau fallback gambar daerah)
                  $fallbackImages = [
                    asset('images/rth.png'),
                    asset('images/menara-songket.png'),
                    asset('images/saribu-rumah-gadang.png'),
                  ];

                  $imageSrc = !empty($item->image)
                    ? (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset('storage/' . $item->image))
                    : $fallbackImages[$index % count($fallbackImages)];

                  $badgeColors = ['bg-primary', 'bg-warning text-dark', 'bg-success', 'bg-danger', 'bg-info text-dark'];
                  $badgeColor = $badgeColors[$index % count($badgeColors)];

                  $tanggalFormatted = !empty($item->tanggal_terbit)
                    ? \Carbon\Carbon::parse($item->tanggal_terbit)->translatedFormat('d F Y')
                    : ($item->created_at ? $item->created_at->translatedFormat('d F Y') : date('d F Y'));
                @endphp

                <!-- Slide {{ $index + 1 }} -->
                <div class="swiper-slide">
                  <a href="{{ route('frontend.berita.detail', $item->slug) }}" class="text-decoration-none d-block h-100">
                    <div class="card border-0 rounded-4 overflow-hidden hero-card-slide text-white position-relative shadow">
                      <img src="{{ $imageSrc }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                      <div class="hero-card-overlay position-absolute bottom-0 start-0 end-0 p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                          <span class="badge {{ $badgeColor }} rounded-pill fs-8">
                            {{ strtoupper($item->kategori ?? 'BERITA UTAMA') }}
                          </span>
                          <span class="text-white-50 fs-8">
                            <i class="bi bi-calendar3 me-1"></i>{{ $tanggalFormatted }}
                          </span>
                        </div>
                        <h4 class="fw-extrabold text-white mb-1 line-clamp-2">{{ $item->judul }}</h4>
                        <p class="text-white-50 fs-7 mb-0 line-clamp-2">
                          {{ \Illuminate\Support\Str::limit(strip_tags($item->ringkas ?? $item->konten ?? ''), 110) }}
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
              @empty
                <!-- Fallback jika belum ada berita -->
                <div class="swiper-slide">
                  <div class="card border-0 rounded-4 overflow-hidden hero-card-slide text-white position-relative shadow">
                    <img src="{{ asset('images/rth.png') }}" alt="RTH Solok Selatan" class="w-100 h-100 object-fit-cover">
                    <div class="hero-card-overlay position-absolute bottom-0 start-0 end-0 p-4">
                      <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary rounded-pill fs-8">BERITA UTAMA</span>
                        <span class="text-white-50 fs-8"><i class="bi bi-calendar3 me-1"></i>{{ date('d F Y') }}</span>
                      </div>
                      <h4 class="fw-extrabold text-white mb-1">Portal Resmi Kabupaten Solok Selatan</h4>
                      <p class="text-white-50 fs-7 mb-0">Informasi publik dan layanan terpadu masyarakat Solok Selatan.</p>
                    </div>
                  </div>
                </div>
              @endforelse

            </div>
          </div>

          <!-- Custom Navigation Arrows Below Carousel -->
          <div class="d-flex align-items-center gap-2 mt-3">
            <button class="btn btn-hero-prev rounded-circle d-flex align-items-center justify-content-center shadow-sm">
              <i class="bi bi-chevron-left"></i>
            </button>
            <button class="btn btn-hero-next rounded-circle d-flex align-items-center justify-content-center shadow-sm">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>

        <!-- Vertical Page Indicator (Nomor Halaman Kanan) -->
        <div class="col-lg-1 d-none d-lg-flex flex-column align-items-center justify-content-center hero-page-indicator">
          <span class="fw-bold fs-4 text-white opacity-100" id="hero-current-slide">01</span>
          <div class="hero-indicator-line my-2"></div>
          <span class="fw-bold fs-4 text-white-50" id="hero-total-slides">05</span>
        </div>
      </div>

    </div>
  </section>

  <!-- SECTION 2: ARTIKEL & BERITA (TERBARU & TERPOPULER) -->
  <section class="py-5 bg-section-curved">
    <div class="container">

      <!-- Section Header: Judul & Tombol Lihat Semua Berita -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <h2 class="fw-bold text-body-emphasis display-6 mb-2">Artikel & Berita Daerah</h2>
          <p class="text-body-secondary mb-0">
            Dapatkan informasi terbaru dan kabar terpopuler seputar pemerintahan dan pembangunan Kabupaten Solok Selatan.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.berita.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold fs-7 d-inline-flex align-items-center gap-2">
            Lihat Semua Berita <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="row g-4">
        <!-- Grid Berita Terbaru (col-lg-8) -->
        <div class="col-lg-8">
          <div class="row g-4">
            @forelse(collect($beritas ?? [])->take(4) as $berita)
              <div class="col-md-6">
                <a href="{{ route('frontend.berita.detail', $berita->slug) }}" class="text-decoration-none h-100 d-block">
                  <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 card-jds-hover bg-body">

                    <!-- Thumbnail Gambar -->
                    <div class="ratio ratio-16x9">
                      @if($berita->image)
                        <img src="{{ asset('storage/' . $berita->image) }}" class="object-fit-cover w-100 h-100" alt="{{ $berita->judul }}">
                      @else
                        <div class="bg-secondary bg-opacity-15 d-flex align-items-center justify-content-center text-body-tertiary">
                          <i class="bi bi-newspaper fs-2"></i>
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
                          <span class="text-body-secondary fs-8">
                            <i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count ?? 0) }}
                          </span>
                        </div>
                        <h5 class="fw-bold text-body-emphasis line-clamp-2 fs-7 mb-2">{{ $berita->judul }}</h5>
                        <p class="text-body-secondary fs-8 line-clamp-2 mb-3">
                          {{ Str::limit(strip_tags($berita->ringkas ?? $berita->konten), 80) }}
                        </p>
                      </div>
                      <small class="text-body-secondary fs-8 pt-2 border-top border-subtle">
                        <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d M Y') }}
                      </small>
                    </div>

                  </div>
                </a>
              </div>
            @empty
              <div class="col-12 py-4 text-center text-body-secondary">
                Belum ada data berita yang tersedia.
              </div>
            @endforelse
          </div>
        </div>

        <!-- Widget Berita Terpopuler (col-lg-4) -->
        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-sm bg-body border-0 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
                <div class="d-flex align-items-center gap-2">
                  <div class="p-2 rounded-3 text-warning bg-warning-subtle">
                    <i class="bi bi-fire fs-5"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-main mb-0 fs-6">Berita Terpopuler</h5>
                    <small class="text-muted-custom fs-8">Paling banyak dibaca pembaca</small>
                  </div>
                </div>
              </div>

              @if(isset($beritaTerpopuler) && $beritaTerpopuler->count())
                <div class="d-flex flex-column gap-3">
                  @foreach($beritaTerpopuler as $rank => $populer)
                    <a href="{{ route('frontend.berita.detail', $populer->slug) }}" class="text-decoration-none text-reset group">
                      <div class="d-flex gap-3 align-items-start p-2 rounded-3 transition-all hover-bg-subtle">
                        <div class="position-relative flex-shrink-0" style="width: 70px; height: 52px;">
                          @if($populer->image)
                            <img src="{{ asset('storage/' . $populer->image) }}" class="w-100 h-100 rounded-3 object-fit-cover shadow-sm" alt="{{ $populer->judul }}">
                          @else
                            <div class="w-100 h-100 rounded-3 bg-secondary bg-opacity-15 d-flex align-items-center justify-content-center text-muted">
                              <i class="bi bi-newspaper fs-5"></i>
                            </div>
                          @endif
                          <span class="position-absolute top-0 start-0 badge {{ $rank == 0 ? 'bg-danger' : ($rank == 1 ? 'bg-warning text-dark' : 'bg-primary') }} rounded-bottom-end rounded-top-start fs-8 shadow-sm">
                            #{{ $rank + 1 }}
                          </span>
                        </div>

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

    </div>
  </section>

  <!-- SECTION 1: LAYANAN PUBLIK DIGITAL (STYLE APLIKASI DINAS) -->
  <section class="py-5">
    <div class="container py-4">
      
      <!-- Section Header -->
      <div class="text-center max-w-2xl mx-auto mb-5">
        <h2 class="fw-bold text-main display-6 mb-2">Layanan Publik Digital</h2>
        <p class="text-muted-custom fs-6">Portal ekosistem pelayanan publik terpadu masyarakat Kabupaten Solok Selatan</p>
      </div>

      <!-- Horizontal Application List -->
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
          <!-- Fallback Circle Icons Jika Data Kosong -->
          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-database-check fs-3 text-primary"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Ekosistem Data Solsel</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-headset fs-3 text-success"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Hotline Pengaduan Warga</h6>
            </a>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- SECTION 3: SARANA & PRASARANA (STYLE CUSTOM EXCLUSIVE & PROPORSIOANAL) -->
  <section class="py-5">
    <div class="container">

      <!-- Section Header -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-info-subtle text-info fw-semibold rounded-pill px-3 py-1 fs-8">
              <i class="bi bi-building me-1"></i> FASILITAS DAERAH
            </span>
          </div>
          <h2 class="fw-bold text-body-emphasis display-6 mb-2">Sarana & Prasarana Publik</h2>
          <p class="text-body-secondary mb-0">
            Fasilitas umum, gedung publik, sarana olahraga, dan prasarana penunjang Kabupaten Solok Selatan.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.sarana_prasarana.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
            Katalog Prasarana Lengkap <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Vertical Card Grid for Sarana Prasarana -->
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
                  <img src="{{ $sp->foto_utama ? asset('storage/' . $sp->foto_utama) : $fallbackImg }}" class="sp-thumb-img" alt="{{ $sp->nama }}">
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
          <!-- Fallback Cards -->
          <div class="col-md-6 col-lg-4">
            <div class="sp-card-custom">
              <div class="sp-thumb-wrapper">
                <img src="{{ asset('images/bg2.jpeg') }}" class="sp-thumb-img" alt="Gelanggang Olahraga">
                <div class="sp-overlay-gradient"></div>
                <span class="sp-badge-category">Fasilitas Olahraga</span>
                <span class="sp-badge-status baik"><i class="bi bi-shield-check me-1"></i>Baik</span>
              </div>
              <div class="sp-card-body">
                <h5 class="sp-card-title">Gelanggang Olahraga Solok Selatan</h5>
                <div class="sp-info-chip mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> Kec. Sangir</div>
                <div class="sp-info-chip"><i class="bi bi-building-gear text-primary"></i> Pengelola: Dispora</div>
              </div>
              <div class="px-4 pb-4 pt-0">
                <span class="sp-action-btn">Lihat Detail Prasarana <i class="bi bi-arrow-right-short fs-5"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="sp-card-custom">
              <div class="sp-thumb-wrapper">
                <img src="{{ asset('images/rth.png') }}" class="sp-thumb-img" alt="RTH Muaralabuh">
                <div class="sp-overlay-gradient"></div>
                <span class="sp-badge-category">Taman & RTH</span>
                <span class="sp-badge-status baik"><i class="bi bi-shield-check me-1"></i>Baik</span>
              </div>
              <div class="sp-card-body">
                <h5 class="sp-card-title">Ruang Terbuka Hijau Muaralabuh</h5>
                <div class="sp-info-chip mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> Kec. Sungai Pagu</div>
                <div class="sp-info-chip"><i class="bi bi-building-gear text-primary"></i> Pengelola: DLH</div>
              </div>
              <div class="px-4 pb-4 pt-0">
                <span class="sp-action-btn">Lihat Detail Prasarana <i class="bi bi-arrow-right-short fs-5"></i></span>
              </div>
            </div>
          </div>
        @endforelse
      </div>

    </div>
  </section>

  <!-- SECTION 4: DOKUMENTASI VIDEO, SIMSALABIM & AGENDA KEGIATAN -->
  <section class="py-5">
    <div class="container">

      <!-- Section Header (Full Width) -->
      <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-8">
          <h2 class="fw-bold text-body-emphasis display-6 mb-1">Dokumentasi Video & Informasi</h2>
          <p class="text-body-secondary fs-7 mb-0">Rekam jejak audio-visual kegiatan dan agenda mendatang Pemerintah Kabupaten Solok Selatan</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('frontend.video.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-semibold fs-7 d-inline-flex align-items-center gap-2">
            Lihat Semua Video <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Content Row: Video Cards (lg-8) + Widget Right Sidebar (lg-4) -->
      <div class="row g-4 align-items-stretch">

        <!-- Kolom Kiri (lg-8): Grid Video Dokumentasi -->
        <div class="col-lg-8">
          <div class="row g-3">
            @forelse($videos as $video)
              <div class="col-md-6">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100">
                  <div class="ratio ratio-16x9">
                    <iframe src="{{ $video->youtube_embed }}" title="{{ $video->judul }}" allowfullscreen></iframe>
                  </div>
                  <div class="card-body p-3 d-flex flex-column justify-content-between bg-body">
                    <div>
                      <span class="badge bg-danger-subtle text-danger fw-semibold mb-2 fs-8">
                        <i class="bi bi-youtube me-1"></i> YouTube
                      </span>
                      <h6 class="fw-bold text-body-emphasis line-clamp-2 mb-2 fs-7">{{ $video->judul }}</h6>
                    </div>
                    <small class="text-body-secondary fs-8 mt-2">
                      <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($video->tanggal ?? now())->translatedFormat('d F Y') }}
                    </small>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-md-6">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100">
                  <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Dokumentasi Solok Selatan" allowfullscreen></iframe>
                  </div>
                  <div class="card-body p-3 d-flex flex-column justify-content-between bg-body">
                    <div>
                      <span class="badge bg-danger-subtle text-danger fw-semibold mb-2 fs-8">
                        <i class="bi bi-youtube me-1"></i> YouTube
                      </span>
                      <h6 class="fw-bold text-body-emphasis line-clamp-2 mb-2 fs-7">Dokumentasi Portal Resmi Kabupaten Solok Selatan</h6>
                    </div>
                    <small class="text-body-secondary fs-8 mt-2"><i class="bi bi-calendar3 me-1"></i> 10 Agustus 2026</small>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm card-jds-hover h-100">
                  <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Inovasi Layanan Publik" allowfullscreen></iframe>
                  </div>
                  <div class="card-body p-3 d-flex flex-column justify-content-between bg-body">
                    <div>
                      <span class="badge bg-danger-subtle text-danger fw-semibold mb-2 fs-8">
                        <i class="bi bi-youtube me-1"></i> YouTube
                      </span>
                      <h6 class="fw-bold text-body-emphasis line-clamp-2 mb-2 fs-7">Peluncuran Layanan Publik Digital Terpadu Solsel</h6>
                    </div>
                    <small class="text-body-secondary fs-8 mt-2"><i class="bi bi-calendar3 me-1"></i> 05 Agustus 2026</small>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        </div>

        <!-- Kolom Kanan (lg-4): SIMSALABIM & Widget Berita Komdigi -->
        <div class="col-lg-4 d-flex flex-column gap-4">

          {{-- Widget SIMSALABIM PKK Solok Selatan (Clickable Direct Link with Desktop View Scaling) --}}
          <a href="https://simsalabim.solselkab.go.id/" target="_blank" rel="noopener noreferrer"
             class="d-block text-decoration-none rounded-4 overflow-hidden position-relative card-simsalabim-hover shadow-sm"
             style="border: 3px solid #eab308; background-color: #ebbc22; height: 320px;"
             title="Klik untuk membuka Website SIMSALABIM PKK Solok Selatan">

            {{-- Desktop View Scaled Preview — full fill card --}}
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

            {{-- Click Interceptor Overlay (di atas iframe agar link bisa diklik) --}}
            <div class="position-absolute top-0 start-0 w-100 h-100" style="cursor: pointer; z-index: 10;"></div>
          </a>

          {{-- Widget Berita Komdigi --}}
          <x-berita-komdigi-widget :limit="10" />

        </div>

      </div>

    </div>
  </section>


  <!-- SECTION: GALERI FOTO & AGENDA KEGIATAN -->
  <section class="py-5">
    <div class="container">
      
      <div class="row g-4 align-items-stretch">
        
        <!-- Kolom Kiri (lg-8): Galeri Foto -->
        <div class="col-lg-8">
          
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h2 class="fw-bold text-body-emphasis display-6 mb-2">Galery Foto</h2>
              <p class="text-body-secondary fs-7 mb-0">Kumpulan rekam jejak foto kegiatan Pemerintah</p>
            </div>
            <a href="{{ route('frontend.galeri.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold fs-7 d-none d-md-inline-flex align-items-center gap-2">
              Lihat Semua Foto <i class="bi bi-arrow-right"></i>
            </a>
          </div>

          <div class="row g-3">
            @forelse($galeris as $foto)
              <div class="col-md-4 col-6">
                <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm card-jds-hover" style="height: 220px;">
                  <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->judul }}" class="w-100 h-100 object-fit-cover">
                  <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white bg-gradient-dark">
                    <h6 class="fw-bold mb-0 fs-7 line-clamp-1">{{ $foto->judul }}</h6>
                    <small class="text-white-50 fs-8">{{ \Carbon\Carbon::parse($foto->tanggal)->translatedFormat('d M Y') }}</small>
                  </div>
                </div>
              </div>
            @empty
              <!-- Default Gallery Placeholders -->
              <div class="col-md-4 col-6">
                <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm card-jds-hover" style="height: 200px;">
                  <img src="{{ asset('images/rth.png') }}" class="w-100 h-100 object-fit-cover" alt="Galeri RTH">
                  <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white bg-gradient-dark">
                    <h6 class="fw-bold mb-0 fs-7 line-clamp-1">Kawasan RTH Muaralabuh</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm card-jds-hover" style="height: 200px;">
                  <img src="{{ asset('images/menara-songket.png') }}" class="w-100 h-100 object-fit-cover" alt="Menara Songket">
                  <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white bg-gradient-dark">
                    <h6 class="fw-bold mb-0 fs-7 line-clamp-1">Ikon Menara Songket</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm card-jds-hover" style="height: 200px;">
                  <img src="{{ asset('images/kanbup.png') }}" class="w-100 h-100 object-fit-cover" alt="Kantor Bupati">
                  <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white bg-gradient-dark">
                    <h6 class="fw-bold mb-0 fs-7 line-clamp-1">Kompleks Kantor Bupati</h6>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
          
          <div class="mt-4 text-center d-md-none">
            <a href="{{ route('frontend.galeri.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold fs-7 d-inline-flex align-items-center gap-2">
              Lihat Semua Foto <i class="bi bi-arrow-right"></i>
            </a>
          </div>

        </div>

        <!-- Kolom Kanan (lg-4): Widget Agenda Kegiatan -->
        <div class="col-lg-4">
          <div class="glass-card p-4 shadow-sm h-100 d-flex flex-column justify-content-between rounded-4 bg-body border-0">
            <div>
              <!-- Widget Header -->
              <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-subtle">
                <div class="d-flex align-items-center gap-2">
                  <div class="p-2 rounded-3 text-primary bg-primary-subtle">
                    <i class="bi bi-calendar-event fs-5"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-main mb-0 fs-6">Agenda Kegiatan</h5>
                    <small class="text-muted-custom fs-8">Kegiatan mendatang Pemda</small>
                  </div>
                </div>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fs-8 fw-semibold">
                  {{ isset($agendas) ? $agendas->count() : 0 }} Agenda
                </span>
              </div>

              <!-- List Agenda Items -->
              @if(isset($agendas) && $agendas->count())
                <div class="d-flex flex-column gap-3">
                  @foreach($agendas as $agenda)
                    @php
                      $isOngoing = $agenda->status === 'ongoing';
                      $isUpcoming = $agenda->status === 'upcoming';
                    @endphp
                    <a href="{{ route('frontend.agenda.detail', $agenda->slug) }}" class="text-decoration-none group">
                      <div class="p-3 rounded-4 transition-all card-jds-hover border border-subtle {{ $isOngoing ? 'border-success border-opacity-75 bg-success-subtle bg-opacity-20' : 'bg-body-tertiary' }}">
                        <!-- Status Badge & Date -->
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                          @if($isOngoing)
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1 fs-8 fw-bold d-inline-flex align-items-center shadow-sm">
                              <span class="spinner-grow spinner-grow-sm text-light me-1.5" style="width: 6px; height: 6px;" role="status"></span>
                              Sedang Berlangsung
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
                            {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d M') }}
                            @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                              - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d M') }}
                            @endif
                          </span>
                        </div>
                        <!-- Judul Agenda -->
                        <h6 class="fw-bold text-body-emphasis fs-7 mb-1 line-clamp-2 leading-snug group-hover-primary transition-all">
                          {{ $agenda->title }}
                        </h6>
                      </div>
                    </a>
                  @endforeach
                </div>
              @else
                <!-- Fallback Data Kosong -->
                <div class="text-center py-5 my-auto text-muted-custom">
                  <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i>
                  <p class="fs-8 mb-0">Belum ada agenda kegiatan terbaru.</p>
                </div>
              @endif
            </div>

            <!-- Footer Action Link -->
            <div class="pt-3 mt-4 border-top border-subtle text-end">
              <a href="{{ route('frontend.agenda.index') }}" class="btn btn-glass-pill px-3 py-1.5 fs-8 fw-semibold d-inline-flex align-items-center gap-2">
                Lihat Semua Agenda <i class="bi bi-arrow-right"></i>
              </a>
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </section>

  <!-- SECTION: APLIKASI DINAS -->
  <section class="py-5">
    <div class="container py-4">
      <!-- Section Header -->
      <div class="text-center max-w-2xl mx-auto mb-5">
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
          <!-- Fallback Circle Icons Jika Data Kosong -->
          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-database-check fs-3 text-primary"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Ekosistem Data Solsel</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-laptop fs-3 text-primary"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Solsel Digital Academy</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-headset fs-3 text-success"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Hotline Warga</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-card-checklist fs-3 text-warning"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">E-Kinerja Pegawai</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-building-check fs-3 text-info"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">Perizinan SIPD</h6>
            </a>
          </div>

          <div class="app-horizontal-item flex-shrink-0">
            <a href="#" class="app-circle-item text-decoration-none d-flex flex-column align-items-center text-center">
              <div class="app-circle-icon mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-cash-stack fs-3 text-danger"></i>
              </div>
              <h6 class="fw-bold text-main fs-7 mb-0 app-circle-title line-clamp-2">SiPBB Pajak</h6>
            </a>
          </div>
        @endforelse
      </div>
    </div>
  </section>

@endsection

@section('scripts')
  <!-- Swiper Carousel & Auto Scroll Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const autoScrollElems = document.querySelectorAll('[data-auto-scroll]');

      autoScrollElems.forEach((appScroll) => {
        let isPaused = false;
        let lastTimestamp = 0;

        const autoScroll = (timestamp) => {
          if (!lastTimestamp) {
            lastTimestamp = timestamp;
          }

          if (!isPaused && appScroll.scrollWidth > appScroll.clientWidth) {
            const elapsed = timestamp - lastTimestamp;
            appScroll.scrollLeft += elapsed * 0.035;

            if (appScroll.scrollLeft >= appScroll.scrollWidth - appScroll.clientWidth - 1) {
              appScroll.scrollLeft = 0;
            }
          }

          lastTimestamp = timestamp;
          window.requestAnimationFrame(autoScroll);
        };

        ['mouseenter', 'focusin', 'touchstart', 'pointerdown'].forEach((eventName) => {
          appScroll.addEventListener(eventName, () => {
            isPaused = true;
          }, { passive: true });
        });

        ['mouseleave', 'focusout', 'touchend', 'pointerup'].forEach((eventName) => {
          appScroll.addEventListener(eventName, () => {
            isPaused = false;
          }, { passive: true });
        });

        window.requestAnimationFrame(autoScroll);
      });

      const heroSwiper = new Swiper('.heroSwiper', {
        slidesPerView: 'auto', /* Menggunakan ukuran auto dari width CSS */
        spaceBetween: 16,     /* Jarak antar kartu lebih rapat */
        loop: true,
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.btn-hero-next',
          prevEl: '.btn-hero-prev',
        },
        on: {
          init: function (swiper) {
            updateSlideIndicator(swiper);
          },
          slideChange: function (swiper) {
            updateSlideIndicator(swiper);
          }
        }
      });

      function updateSlideIndicator(swiper) {
        const currentEl = document.getElementById('hero-current-slide');
        const totalEl = document.getElementById('hero-total-slides');
        if (currentEl && totalEl) {
          const current = (swiper.realIndex + 1).toString().padStart(2, '0');
          const total = swiper.slides.length.toString().padStart(2, '0');
          currentEl.textContent = current;
          totalEl.textContent = total;
        }
      }
    });
  </script>
@endsection
