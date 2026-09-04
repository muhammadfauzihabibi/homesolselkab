@extends('layouts.frontend')

@section('title', 'Daftar Agenda Kegiatan')

@section('content')
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
            <li class="breadcrumb-item active" aria-current="page">Agenda Kegiatan</li>
            </ol>
        </nav>

        <h1 class="page-title">Agenda Kegiatan</h1>
        <p class="page-description">Jadwal agenda resmi Pemerintah Kabupaten Solok Selatan</p>
        </div>
    </section>

    <div class="container pb-5 container-overlap" style="margin-top: -60px;">
    <div class="p-4 rounded-4 shadow-sm border border-subtle bg-body">
        <div class="d-flex flex-column gap-3">
        @forelse($agendas as $agenda)
            @php
              $isOngoing = $agenda->status === 'ongoing';
              $isUpcoming = $agenda->status === 'upcoming';
            @endphp
            <a href="{{ route('frontend.agenda.detail', $agenda->slug) }}" class="text-decoration-none group">
            <div class="p-4 rounded-4 transition-all card-jds-hover border border-subtle {{ $isOngoing ? 'border-success border-opacity-75 bg-success-subtle bg-opacity-20' : 'bg-body-tertiary' }}">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div class="d-flex align-items-center gap-2">
                    @if($isOngoing)
                      <span class="badge bg-success text-white rounded-pill px-3 py-1.5 fs-8 fw-bold d-inline-flex align-items-center shadow-sm">
                        <span class="spinner-grow spinner-grow-sm text-light me-1.5" style="width: 6px; height: 6px;" role="status"></span>
                        Sedang Berlangsung
                      </span>
                    @elseif($isUpcoming)
                      <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold">
                        <i class="bi bi-clock me-1"></i> Akan Datang
                      </span>
                    @else
                      <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1.5 fs-8 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Selesai
                      </span>
                    @endif
                  </div>

                  <span class="text-body-secondary fs-8 fw-semibold bg-body rounded-pill px-3 py-1 border border-subtle shadow-sm">
                      <i class="bi bi-calendar3 me-1.5 text-primary"></i>
                      {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d M Y') }}
                      @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                      - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d M Y') }}
                      @endif
                  </span>
                </div>
                <h5 class="fw-bold text-body-emphasis fs-6 mb-2 group-hover-primary transition-all">{{ $agenda->title }}</h5>
                @if($agenda->description)
                <p class="text-body-secondary fs-7 mb-0 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($agenda->description), 140) }}</p>
                @endif
            </div>
            </a>
        @empty
            <div class="text-center py-5 text-muted-custom">Belum ada agenda kegiatan.</div>
        @endforelse
        </div>
        <!-- Pagination Navigasi -->
        @if($agendas->hasPages())
        <div class="mt-5 d-flex justify-content-center pagination-wrapper">
            {{ $agendas->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
    </div>
@endsection