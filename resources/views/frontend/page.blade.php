@extends('layouts.frontend')

@section('title', $page->judul)

@section('content')

  <!-- 1. HERO BANNER SECTION (BAGIAN ATAS GELAP DENGAN SLIDER BACKGROUND) -->
  <section class="page-hero-banner position-relative">
    
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

    <!-- Content Container (Di atas background slider) -->
    <div class="container position-relative" style="z-index: 5;">
      
      <!-- Breadcrumb Navigation -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          @if($page->menu)
            <li class="breadcrumb-item">
              <a href="#">{{ $page->menu->nama }}</a>
            </li>
          @endif
          <li class="breadcrumb-item active" aria-current="page">
            {{ $page->judul }}
          </li>
        </ol>
      </nav>

      <!-- Judul Utama -->
      <h1 class="page-title">
        {{ $page->judul }}
      </h1>

      <!-- Deskripsi Singkat Hero -->
      @if($page->deskripsi)
        <p class="page-description">
          {{ $page->deskripsi }}
        </p>
      @endif

    </div>
  </section>

  <!-- 2. FLOATING CARD CONTENT SECTION (KARTU MENUMPUK) -->
  <div class="container pb-5">
    <div class="row g-4 align-items-start">
      
      <!-- Kolom Kiri: Konten Page (lg-8) -->
      <div class="col-lg-8">
        <div class="page-floating-card">
          
          <!-- Thumbnail Gambar Utama -->
          @if($page->thumbnail)
            <img src="{{ asset('storage/' . $page->thumbnail) }}" 
                 alt="{{ $page->judul }}" 
                 class="page-featured-image rounded-4 mb-4 w-100 object-fit-cover shadow-sm" style="max-height: 420px;">
          @endif

          <!-- Konten Utama (Render dari CKEditor) -->
          <div class="page-detail-body ck-content mb-4 leading-relaxed">
            {!! $page->konten !!}
          </div>

          <!-- Action Footer: Tombol Kembali -->
          <div class="pt-4 mt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-3">
            <a href="javascript:history.back()" class="btn btn-outline-primary rounded-pill px-4 py-2 fs-7 fw-semibold d-inline-flex align-items-center gap-2">
              <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <a href="{{ url('/') }}" class="btn btn-glass-pill px-4 py-2 fs-7 fw-semibold d-inline-flex align-items-center gap-2">
              <i class="bi bi-house-door"></i> Ke Beranda
            </a>
          </div>

        </div>
      </div>

      <!-- Kolom Kanan: Widget Agenda (lg-4) -->
      <div class="col-lg-4">
        <div class="glass-card p-4 rounded-4 shadow-sm bg-body border-0 mb-4 sticky-top" style="top: 100px;">
          @php
            $agendas = \App\Models\Agenda::where('aktif', true)
                ->where('end_date', '>=', now()->toDateString())
                ->orderBy('start_date', 'asc')
                ->take(4)
                ->get();
          @endphp
          
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
              {{ $agendas->count() }} Agenda
            </span>
          </div>

          @if($agendas->count())
            <div class="d-flex flex-column gap-3">
              @foreach($agendas as $agenda)
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
                    <h6 class="fw-bold text-body-emphasis fs-7 mb-1 line-clamp-2 leading-snug group-hover-primary transition-all">
                      {{ $agenda->title }}
                    </h6>
                  </div>
                </a>
              @endforeach
            </div>
          @else
            <div class="text-center py-4 text-muted-custom">
              <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
              <p class="fs-8 mb-0">Belum ada agenda terbaru.</p>
            </div>
          @endif
          
          <div class="pt-3 mt-4 border-top border-subtle text-center">
            <a href="{{ route('frontend.agenda.index') }}" class="btn btn-outline-primary rounded-pill w-100 py-2 fs-8 fw-semibold">
              Lihat Semua Agenda
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection