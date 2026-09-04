@extends('layouts.frontend')

@section('title', 'Galeri Foto')

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
            <li class="breadcrumb-item active" aria-current="page">Galeri Foto</li>
            </ol>
        </nav>

        <h1 class="page-title">Galeri Foto</h1>
        <p class="page-description">Dokumentasi kegiatan Pemerintah Kabupaten Solok Selatan</p>
        </div>
    </section>

<div class="container pb-5 container-overlap" style="margin-top: -60px;">
  <div class="row g-4">
    @forelse($galeris as $galeri)
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 card-jds-hover bg-body">
          <div class="ratio ratio-1x1">
            <img src="{{ asset('storage/' . $galeri->file_path) }}" class="object-fit-cover w-100 h-100" alt="{{ $galeri->judul }}">
          </div>
          <div class="card-body p-3">
            <h6 class="fw-bold text-main fs-8 mb-0 line-clamp-2">{{ $galeri->judul }}</h6>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 py-5 text-center text-muted-custom">Belum ada galeri foto.</div>
    @endforelse
  </div>
  <!-- Pagination Navigasi -->
    @if($galeris->hasPages())
      <div class="mt-5 d-flex justify-content-center pagination-wrapper">
        {{ $galeris->links('pagination::bootstrap-5') }}
      </div>
    @endif
</div>
@endsection