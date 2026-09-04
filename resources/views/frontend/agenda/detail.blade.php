@extends('layouts.frontend')

@section('title', $agenda->title)

@section('content')
<section class="page-hero-banner position-relative">
  <div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
    <div class="hero-bg-slider w-100 h-100">
      <div class="hero-bg-slide active"><img src="{{ asset('images/bg4.jpeg') }}" class="w-100 h-100 object-fit-cover"></div>
    </div>
    <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
  </div>
  <div class="container position-relative" style="z-index: 5;">
    @php
      $isOngoing = $agenda->status === 'ongoing';
      $isUpcoming = $agenda->status === 'upcoming';
    @endphp
    @if($isOngoing)
      <span class="badge bg-success text-white rounded-pill mb-2 px-3 py-1 fs-8 fw-bold d-inline-flex align-items-center shadow-sm">
        <span class="spinner-grow spinner-grow-sm text-light me-1.5" style="width: 6px; height: 6px;" role="status"></span>
        Sedang Berlangsung Hari Ini
      </span>
    @elseif($isUpcoming)
      <span class="badge bg-primary text-white rounded-pill mb-2 px-3 py-1 fs-8 fw-semibold">
        <i class="bi bi-clock me-1"></i> Agenda Akan Datang
      </span>
    @else
      <span class="badge bg-secondary text-white rounded-pill mb-2 px-3 py-1 fs-8 fw-semibold">
        <i class="bi bi-check-circle me-1"></i> Agenda Selesai
      </span>
    @endif
    <h1 class="page-title">{{ $agenda->title }}</h1>
  </div>
</section>

<div class="container pb-5">
  <div class="page-floating-card">
    <div class="p-3.5 px-4 rounded-4 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2 bg-body-tertiary border border-subtle">
      <div class="d-flex align-items-center gap-2 text-primary fw-bold fs-7">
        <i class="bi bi-calendar3 fs-5 text-primary"></i>
        <span>
          {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}
          @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
            - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}
          @endif
        </span>
      </div>

      <span class="badge {{ $isOngoing ? 'bg-success text-white' : ($isUpcoming ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle') }} rounded-pill px-3 py-1.5 fs-8 fw-semibold">
        Status: {{ $agenda->status_label }}
      </span>
    </div>

    <div class="page-detail-body mb-4">
      {!! $agenda->description !!}
    </div>

    <div class="pt-4 border-top border-subtle d-flex justify-content-between align-items-center flex-wrap gap-3">
      <a href="{{ route('frontend.agenda.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fs-7 fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Semua Agenda
      </a>
      <a href="{{ url('/') }}" class="btn btn-glass-pill px-4 py-2 fs-7 fw-semibold">
        <i class="bi bi-house-door me-1"></i> Beranda
      </a>
    </div>
  </div>
</div>
@endsection