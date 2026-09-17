@extends('layouts.frontend')

@section('title', $berita->judul)

@section('content')
<section class="bento-page-banner position-relative text-white overflow-hidden">
  <x-frontend-hero-background />
  <div class="hero-bento-overlay"></div>

  <div class="container position-relative" style="z-index: 5;">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.berita.index') }}">Berita & Artikel</a></li>
        <li class="breadcrumb-item active text-truncate max-w-xs" aria-current="page">{{ $berita->judul }}</li>
      </ol>
    </nav>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
      <span class="bento-badge bento-badge-primary px-3 py-1">{{ $berita->kategori ?? 'Berita' }}</span>
      <span class="bento-badge">
        <i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count ?? 0) }} Kali Dibaca
      </span>
      <span class="bento-badge">
        <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d F Y') }}
      </span>
    </div>

    <h1 class="bento-page-title mb-2">{{ $berita->judul }}</h1>
  </div>
</section>

<div class="container bento-overlap-container pb-5">
  <!-- Top Quick Back Button -->
  <div class="mb-3">
    <a href="{{ route('frontend.berita.index') }}" class="btn-bento-back">
      <i class="bi bi-arrow-left"></i> <span>Kembali ke Berita</span>
    </a>
  </div>

  <div class="bento-grid align-items-start">
    <!-- Main Article Body (Bento Span 8) -->
    <div class="bento-col-8">
      <div class="bento-card p-4 p-md-5">
        @php
          $detailImg = asset('images/rth.png');
          if(!empty($berita->image)) {
            if(\Illuminate\Support\Str::startsWith($berita->image, ['http://', 'https://'])) {
              $detailImg = $berita->image;
            } elseif(\Illuminate\Support\Str::startsWith($berita->image, 'storage/')) {
              $detailImg = asset($berita->image);
            } else {
              $detailImg = asset('storage/' . $berita->image);
            }
          }
        @endphp

        <div class="mb-4 rounded-4 overflow-hidden shadow-sm border border-subtle text-center bg-dark bg-opacity-10">
          <img src="{{ $detailImg }}"
               class="w-100 h-auto rounded-4 d-block mx-auto"
               style="max-width: 100%; height: auto; object-fit: contain;"
               alt="{{ $berita->judul }}"
               onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
        </div>

        <div class="page-detail-body mb-4 leading-relaxed fs-7" style="line-height: 1.8;">
          {!! $berita->konten !!}
        </div>

        <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
          <a href="{{ route('frontend.berita.index') }}" class="btn-bento btn-bento-outline">
            <i class="bi bi-arrow-left"></i> Kembali ke Berita
          </a>
          <div class="d-flex align-items-center gap-2">
            <span class="text-muted-custom fs-8 d-none d-sm-inline me-2">
              <i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count ?? 0) }} Tayangan
            </span>
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
              <i class="bi bi-house-door"></i> Ke Beranda
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar: Berita Terpopuler (Bento Span 4) -->
    <div class="bento-col-4">
      <div class="bento-card sticky-top p-4" style="top: 100px;">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-subtle">
          <div class="d-flex align-items-center gap-2">
            <div class="p-2 rounded-3 bg-warning-subtle text-warning">
              <i class="bi bi-fire fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-0 fs-6">Berita Terpopuler</h5>
              <small class="text-muted-custom fs-8">Paling banyak dibaca</small>
            </div>
          </div>
        </div>

        @if(isset($beritaTerpopuler) && $beritaTerpopuler->count())
          <div class="d-flex flex-column gap-2">
            @foreach($beritaTerpopuler as $rank => $populer)
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
              @endphp
              <a href="{{ route('frontend.berita.detail', $populer->slug) }}" class="bento-ranked-item text-decoration-none">
                <div class="bento-ranked-thumb position-relative me-3 flex-shrink-0" style="width: 70px; height: 52px;">
                  <img src="{{ $popImg }}" class="w-100 h-100 rounded-3 object-fit-cover shadow-sm" alt="{{ $populer->judul }}" onerror="this.onerror=null; this.src='{{ asset('images/rth.png') }}';">
                  <span class="bento-rank-badge position-absolute top-0 start-0 badge {{ $rank === 0 ? 'bg-danger' : ($rank === 1 ? 'bg-warning text-dark' : 'bg-primary') }}">
                    #{{ $rank + 1 }}
                  </span>
                </div>

                <div class="flex-grow-1 min-w-0">
                  <h6 class="fw-bold fs-8 line-clamp-2 mb-1 text-main">
                    {{ $populer->judul }}
                  </h6>
                  <div class="d-flex align-items-center justify-content-between text-muted-custom fs-8">
                    <span><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($populer->tanggal_terbit)->translatedFormat('d M') }}</span>
                    <span><i class="bi bi-eye me-1"></i> {{ number_format($populer->views_count) }}</span>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="text-center py-4 text-muted-custom fs-8">
            Belum ada berita terpopuler.
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
