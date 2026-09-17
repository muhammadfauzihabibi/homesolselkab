@extends('layouts.frontend')

@section('title', $agenda->title)

@section('content')
<section class="bento-page-banner position-relative text-white overflow-hidden">
  <x-frontend-hero-background />
  <div class="hero-bento-overlay"></div>

  <div class="container position-relative" style="z-index: 5;">
    @php
      $isOngoing = $agenda->status === 'ongoing';
      $isUpcoming = $agenda->status === 'upcoming';
    @endphp

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.agenda.index') }}">Agenda</a></li>
        <li class="breadcrumb-item active text-truncate max-w-xs" aria-current="page">{{ $agenda->title }}</li>
      </ol>
    </nav>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
      @if($isOngoing)
        <span class="bento-badge bento-badge-success">
          <span class="spinner-grow spinner-grow-sm text-success me-1" style="width: 6px; height: 6px;" role="status"></span>
          Sedang Berlangsung
        </span>
      @elseif($isUpcoming)
        <span class="bento-badge bento-badge-primary">
          <i class="bi bi-clock me-1"></i> Agenda Mendatang
        </span>
      @else
        <span class="bento-badge">
          <i class="bi bi-check-circle me-1"></i> Agenda Selesai
        </span>
      @endif

      <span class="bento-badge">
        <i class="bi bi-calendar3 me-1"></i>
        {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}
        @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
          - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}
        @endif
      </span>
    </div>

    <h1 class="bento-page-title mb-2">{{ $agenda->title }}</h1>
  </div>
</section>

<div class="container bento-overlap-container pb-5">
  <!-- Top Quick Back Button -->
  <div class="mb-3">
    <a href="{{ route('frontend.agenda.index') }}" class="btn-bento-back">
      <i class="bi bi-arrow-left"></i> <span>Kembali ke Agenda</span>
    </a>
  </div>

  <div class="bento-card p-4 p-md-5">
    <div class="p-3 px-4 rounded-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2 bg-body-tertiary border border-subtle">
      <div class="d-flex align-items-center gap-2 text-primary fw-bold fs-7">
        <i class="bi bi-calendar-check fs-5"></i>
        <span>
          {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}
          @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
            - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}
          @endif
        </span>
      </div>

      <span class="bento-badge {{ $isOngoing ? 'bento-badge-success' : ($isUpcoming ? 'bento-badge-primary' : 'bento-badge') }}">
        Status: {{ $agenda->status_label }}
      </span>
    </div>

    <div class="page-detail-body mb-4 fs-7" style="line-height: 1.8;">
      {!! $agenda->description !!}
    </div>

    <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
      <a href="{{ route('frontend.agenda.index') }}" class="btn-bento btn-bento-outline">
        <i class="bi bi-arrow-left"></i> Kembali ke Agenda
      </a>
      <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
        <i class="bi bi-house-door"></i> Ke Beranda
      </a>
    </div>
  </div>
</div>
@endsection
