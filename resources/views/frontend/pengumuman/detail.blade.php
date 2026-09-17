@extends('layouts.frontend')

@section('title', $pengumuman->title)

@section('content')
<section class="bento-page-banner position-relative text-white overflow-hidden">
    <x-frontend-hero-background />
    <div class="hero-bento-overlay"></div>

    <div class="container position-relative" style="z-index: 5;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.pengumuman.index') }}">Pengumuman</a></li>
                <li class="breadcrumb-item active text-truncate max-w-xs" aria-current="page">{{ $pengumuman->title }}</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="bento-badge bento-badge-primary">
                <i class="bi bi-megaphone me-1"></i> Pengumuman Resmi
            </span>
            <span class="bento-badge">
                <i class="bi bi-calendar3 me-1"></i> {{ $pengumuman->created_at?->translatedFormat('d F Y') }}
            </span>
        </div>

        <h1 class="bento-page-title mb-2">{{ $pengumuman->title }}</h1>
    </div>
</section>

<div class="container bento-overlap-container pb-5">
    <!-- Top Quick Back Button -->
    <div class="mb-3">
        <a href="{{ route('frontend.pengumuman.index') }}" class="btn-bento-back">
            <i class="bi bi-arrow-left"></i> <span>Kembali ke Pengumuman</span>
        </a>
    </div>

    <div class="bento-card p-4 p-md-5">
        <article class="page-detail-body mb-4 fs-7" style="line-height: 1.8;">
            {!! $pengumuman->content !!}
        </article>

        <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('frontend.pengumuman.index') }}" class="btn-bento btn-bento-outline">
                <i class="bi bi-arrow-left"></i> Kembali ke Pengumuman
            </a>
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
                <i class="bi bi-house-door"></i> Ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
