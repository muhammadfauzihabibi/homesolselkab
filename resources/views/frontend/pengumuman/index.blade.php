@extends('layouts.frontend')

@section('title', 'Daftar Pengumuman')

@section('content')
    <section class="bento-page-banner position-relative text-white overflow-hidden">
        <x-frontend-hero-background />
        <div class="hero-bento-overlay"></div>

        <div class="container position-relative" style="z-index: 5;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
                </ol>
            </nav>

            <span class="bento-eyebrow mb-2">INFORMASI RESMI</span>
            <h1 class="bento-page-title">Pengumuman Resmi</h1>
            <p class="bento-page-subtitle">Pemberitahuan dan siaran resmi Pemerintah Kabupaten Solok Selatan untuk masyarakat</p>
        </div>
    </section>

    <div class="container bento-overlap-container pb-5">
        <div class="bento-card p-4 p-md-5">
            <div class="d-flex flex-column gap-3">
                @forelse($pengumumen as $pengumuman)
                    <a href="{{ route('frontend.pengumuman.detail', $pengumuman->slug) }}" class="text-decoration-none">
                        <div class="p-3.5 p-md-4 rounded-4 transition-all bento-card bento-card-interactive border border-subtle">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="rounded-3 overflow-hidden bg-body-tertiary d-flex align-items-center justify-content-center"
                                        style="width: 72px; height: 68px;">
                                        <i class="bi bi-megaphone fs-3 text-muted-custom"></i>
                                    </div>
                                </div>
                                <div class="col min-w-0">
                                    <div class="d-flex align-items-center gap-2 mb-1.5">
                                        <span class="bento-badge bento-badge-primary">
                                            <i class="bi bi-megaphone me-1"></i> Pengumuman
                                        </span>
                                        <span class="text-muted-custom fs-8">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $pengumuman->created_at?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <h5 class="fw-bold fs-6 mb-1 line-clamp-2">{{ $pengumuman->title }}</h5>
                                    <p class="text-muted-custom fs-7 mb-0 line-clamp-2">
                                        {{ Str::limit(strip_tags($pengumuman->content), 180) }}
                                    </p>
                                </div>
                                <div class="col-auto d-none d-md-block">
                                    <i class="bi bi-arrow-right text-primary fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5 text-muted-custom">
                        <i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada pengumuman resmi saat ini.
                    </div>
                @endforelse
            </div>

            @if($pengumumen->hasPages())
                <div class="mt-5 d-flex justify-content-center pagination-wrapper">
                    {{ $pengumumen->links('pagination::bootstrap-5') }}
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
