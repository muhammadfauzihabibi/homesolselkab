@extends('layouts.frontend')

@section('title', $poster->judul)

@section('content')
<section class="bento-page-banner position-relative text-white overflow-hidden">
  <x-frontend-hero-background />
  <div class="hero-bento-overlay"></div>

  <div class="container position-relative" style="z-index: 5;">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.poster.index') }}">Poster Digital</a></li>
        <li class="breadcrumb-item active text-truncate max-w-xs" aria-current="page">{{ $poster->judul }}</li>
      </ol>
    </nav>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
      <span class="bento-badge bento-badge-primary">Poster Digital</span>
      <span class="bento-badge">
        <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($poster->tanggal_publikasi)->translatedFormat('d F Y') }}
      </span>
      <span class="bento-badge">
        <i class="bi bi-eye me-1"></i> {{ number_format($poster->views_count ?? 0) }} Kali Dilihat
      </span>
    </div>

    <h1 class="bento-page-title mb-2">{{ $poster->judul }}</h1>
  </div>
</section>

<div class="container bento-overlap-container pb-5">
  <!-- Top Quick Back Button -->
  <div class="mb-3">
    <a href="{{ route('frontend.poster.index') }}" class="btn-bento-back">
      <i class="bi bi-arrow-left"></i> <span>Kembali ke Poster</span>
    </a>
  </div>

  <div class="bento-grid align-items-start">
    <div class="bento-col-8">
      <div class="bento-card p-4 p-md-5">
        @if($poster->foto_poster)
          <div class="mb-4 rounded-4 overflow-hidden shadow-sm border border-subtle text-center bg-dark bg-opacity-10">
            <img src="{{ asset('storage/' . $poster->foto_poster) }}"
                 class="w-100 h-auto rounded-4 d-block mx-auto"
                 style="max-width: 100%; height: auto; object-fit: contain;"
                 alt="{{ $poster->judul }}"
                 onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
          </div>
        @endif

        <div class="page-detail-body mb-4 fs-7" style="line-height: 1.8;">
          {!! nl2br(e($poster->deskripsi)) !!}
        </div>

        <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
          <a href="{{ route('frontend.poster.index') }}" class="btn-bento btn-bento-outline">
            <i class="bi bi-arrow-left"></i> Kembali ke Poster
          </a>
          <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
              <i class="bi bi-house-door"></i> Ke Beranda
            </a>
            @if($poster->foto_poster)
              <a href="{{ asset('storage/' . $poster->foto_poster) }}" download class="btn-bento btn-bento-primary">
                <i class="bi bi-download"></i> Unduh Poster
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="bento-col-4">
      <div class="bento-card p-4 sticky-top" style="top: 100px;">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-subtle">
          <div class="d-flex align-items-center gap-2.5">
            <div class="p-2 rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
              <i class="bi bi-fire fs-5 text-warning"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-0 fs-6 text-body-emphasis">Poster Terpopuler</h5>
              <small class="text-muted-custom fs-8 opacity-75">Paling banyak dilihat</small>
            </div>
          </div>
        </div>

        @if(isset($posterTerpopuler) && $posterTerpopuler->count())
          <div class="d-flex flex-column gap-2">
            @foreach($posterTerpopuler as $rank => $populer)
              <a href="{{ route('frontend.poster.detail', $populer->slug) }}" class="bento-ranked-item">
                <div class="bento-ranked-thumb">
                  @if($populer->foto_poster)
                    <img src="{{ asset('storage/' . $populer->foto_poster) }}" alt="{{ $populer->judul }}" onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                  @else
                    <div class="w-100 h-100 bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center text-muted">
                      <i class="bi bi-image fs-5"></i>
                    </div>
                  @endif
                  <span class="bento-rank-badge {{ $rank === 0 ? 'bg-danger text-white' : ($rank === 1 ? 'bg-warning text-dark' : 'bg-primary text-white') }}">
                    #{{ $rank + 1 }}
                  </span>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <h6 class="fw-bold fs-7.5 line-clamp-2 mb-1 text-body-emphasis group-hover-primary leading-snug">{{ $populer->judul }}</h6>
                  <div class="d-flex align-items-center justify-content-between text-muted-custom fs-8">
                    <span><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($populer->tanggal_publikasi)->translatedFormat('d M') }}</span>
                    <span><i class="bi bi-eye me-1"></i> {{ number_format($populer->views_count) }}</span>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="text-center py-4 text-muted-custom fs-7 opacity-75">
            <i class="bi bi-image-alt display-6 opacity-40 d-block mb-2"></i>
            Belum ada poster terpopuler lainnya.
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
