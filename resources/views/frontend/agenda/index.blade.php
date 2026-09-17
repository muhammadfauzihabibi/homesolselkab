@extends('layouts.frontend')

@section('title', 'Daftar Agenda Kegiatan')

@section('content')
    <section class="bento-page-banner position-relative text-white overflow-hidden">
        <x-frontend-hero-background />
        <div class="hero-bento-overlay"></div>

        <div class="container position-relative" style="z-index: 5;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Agenda Kegiatan</li>
                </ol>
            </nav>

            <span class="bento-eyebrow mb-2">JADWAL & KEGIATAN</span>
            <h1 class="bento-page-title">Agenda Kegiatan Daerah</h1>
            <p class="bento-page-subtitle">Jadwal resmi agenda dan kegiatan Pemerintah Kabupaten Solok Selatan</p>
        </div>
    </section>

    <div class="container bento-overlap-container pb-5">
        <div class="bento-card p-4 p-md-5">
            <div class="d-flex flex-column gap-3">
                @forelse($agendas as $agenda)
                    @php
                        $isOngoing = $agenda->status === 'ongoing';
                        $isUpcoming = $agenda->status === 'upcoming';
                    @endphp
                    <a href="{{ route('frontend.agenda.detail', $agenda->slug) }}" class="text-decoration-none">
                        <div class="p-3.5 p-md-4 rounded-4 transition-all bento-card bento-card-interactive border {{ $isOngoing ? 'border-success border-opacity-50' : 'border-subtle' }}">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div>
                                    @if($isOngoing)
                                        <span class="bento-badge bento-badge-success">
                                            <span class="spinner-grow spinner-grow-sm text-success me-1" style="width: 6px; height: 6px;" role="status"></span>
                                            Sedang Berlangsung Hari Ini
                                        </span>
                                    @elseif($isUpcoming)
                                        <span class="bento-badge bento-badge-primary">
                                            <i class="bi bi-clock me-1"></i> Akan Datang
                                        </span>
                                    @else
                                        <span class="bento-badge">
                                            <i class="bi bi-check-circle me-1"></i> Selesai
                                        </span>
                                    @endif
                                </div>

                                <span class="bento-badge">
                                    <i class="bi bi-calendar3 me-1.5 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d M Y') }}
                                    @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                        - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d M Y') }}
                                    @endif
                                </span>
                            </div>

                            <h5 class="fw-bold fs-6 mb-2">{{ $agenda->title }}</h5>
                            @if($agenda->description)
                                <p class="text-muted-custom fs-7 mb-0 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($agenda->description), 160) }}
                                </p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5 text-muted-custom">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada agenda kegiatan saat ini.
                    </div>
                @endforelse
            </div>

            <!-- Pagination Navigasi -->
            @if($agendas->hasPages())
                <div class="mt-5 d-flex justify-content-center pagination-wrapper">
                    {{ $agendas->links('pagination::bootstrap-5') }}
                </div>
            @endif

            <div class="mt-4 pt-4 border-top border-subtle d-flex justify-content-center">
                <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
                    <i class="bi bi-house-door"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
