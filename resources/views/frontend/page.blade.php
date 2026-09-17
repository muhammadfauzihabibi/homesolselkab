@extends('layouts.frontend')

@section('title', $page->judul)

@section('content')

  <!-- Bento Subpage Banner -->
  <section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
      <!-- Breadcrumb Navigation -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
          </li>
          @if($page->menu)
            <li class="breadcrumb-item">
              <span>{{ $page->menu->nama }}</span>
            </li>
          @endif
          <li class="breadcrumb-item active" aria-current="page">
            {{ $page->judul }}
          </li>
        </ol>
      </nav>

      <h1 class="bento-page-title">{{ $page->judul }}</h1>

      @if($page->deskripsi)
        <p class="bento-page-subtitle">{{ $page->deskripsi }}</p>
      @endif
    </div>
  </section>

  <!-- Bento Content Container -->
  <div class="container bento-overlap-container pb-5">
    <!-- Top Quick Back Button -->
    <div class="mb-3">
      <a href="javascript:history.back()" class="btn-bento-back">
        <i class="bi bi-arrow-left"></i> <span>Kembali</span>
      </a>
    </div>

    <div class="bento-grid align-items-start">

      <!-- Main Content (Bento Span 8) -->
      <div class="bento-col-8">
        <div class="bento-card p-4 p-md-5">

          <!-- Body Content -->
          <div class="page-detail-body ck-content mb-4 fs-7" style="line-height: 1.85;">
            {!! $page->konten !!}
          </div>

          <!-- Actions -->
          <div class="pt-4 mt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="javascript:history.back()" class="btn-bento btn-bento-outline">
              <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
              <i class="bi bi-house-door"></i> Ke Beranda
            </a>
          </div>

        </div>
      </div>

      <!-- Sidebar Widgets (Bento Span 4) -->
      <div class="bento-col-4">
        <div class="d-flex flex-column gap-4 sticky-top" style="top: 100px;">

          <!-- Agenda Widget Bento Card -->
          <div class="bento-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-subtle">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-3 bg-primary-subtle text-primary"><i class="bi bi-calendar-event fs-5"></i></div>
                <div>
                  <h5 class="fw-bold mb-0 fs-6">Agenda Kegiatan</h5>
                  <small class="text-muted-custom fs-8">Kegiatan mendatang Pemda</small>
                </div>
              </div>
              <span class="bento-badge bento-badge-primary">{{ $agendas->count() }} Agenda</span>
            </div>

            @if ($agendas->count())
              <div class="d-flex flex-column gap-2">
                @foreach ($agendas as $agenda)
                  <a href="{{ route('frontend.agenda.detail', $agenda->slug) }}" class="text-decoration-none">
                    <div class="p-2.5 rounded-3 transition-all hover-bg-subtle border border-subtle">
                      <div class="d-flex align-items-center justify-content-between gap-2 mb-1.5">
                        <span class="bento-badge {{ $agenda->status === 'ongoing' ? 'bento-badge-success' : ($agenda->status === 'upcoming' ? 'bento-badge-primary' : 'bento-badge') }}">
                          {{ $agenda->statusLabel }}
                        </span>
                        <span class="text-muted-custom fs-8"><i class="bi bi-calendar3 me-1"></i>{{ $agenda->start_date->translatedFormat('d M') }}</span>
                      </div>
                      <h6 class="fw-bold fs-8 mb-0 line-clamp-2">{{ $agenda->title }}</h6>
                    </div>
                  </a>
                @endforeach
              </div>
            @else
              <div class="text-center py-4 text-muted-custom fs-8"><i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i><p class="mb-0">Belum ada agenda terbaru.</p></div>
            @endif

            <div class="pt-3 mt-3 border-top border-subtle text-end">
              <a href="{{ route('frontend.agenda.index') }}" class="btn-bento btn-bento-ghost btn-bento-sm">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <!-- Pengumuman Widget Bento Card -->
          <div class="bento-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-subtle">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-3 bg-primary-subtle text-primary"><i class="bi bi-megaphone fs-5"></i></div>
                <div>
                  <h5 class="fw-bold mb-0 fs-6">Pengumuman</h5>
                  <small class="text-muted-custom fs-8">Informasi resmi Pemda</small>
                </div>
              </div>
            </div>

            @if ($pengumumen->count())
              <div class="d-flex flex-column gap-2">
                @foreach ($pengumumen as $pengumuman)
                  <a href="{{ route('frontend.pengumuman.detail', $pengumuman->slug) }}" class="text-decoration-none">
                    <div class="p-2.5 rounded-3 transition-all hover-bg-subtle border border-subtle">
                      <div class="d-flex align-items-start gap-2">
                        <div class="rounded-2 flex-shrink-0 overflow-hidden bg-body-tertiary d-flex align-items-center justify-content-center" style="width: 48px; height: 38px;">
                          <i class="bi bi-megaphone text-muted-custom"></i>
                        </div>
                        <div class="min-w-0">
                          <h6 class="fw-bold fs-8 line-clamp-2 mb-1">{{ $pengumuman->title }}</h6>
                          <small class="text-muted-custom fs-9">{{ $pengumuman->created_at?->translatedFormat('d M Y') }}</small>
                        </div>
                      </div>
                    </div>
                  </a>
                @endforeach
              </div>
            @else
              <div class="text-center py-4 text-muted-custom fs-8"><i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i><p class="mb-0">Belum ada pengumuman.</p></div>
            @endif

            <div class="pt-3 mt-3 border-top border-subtle text-end">
              <a href="{{ route('frontend.pengumuman.index') }}" class="btn-bento btn-bento-ghost btn-bento-sm">
                Lihat Semua <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

@endsection
