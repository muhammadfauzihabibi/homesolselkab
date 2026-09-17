@extends('layouts.admin')

@section('title', 'Manajemen Agenda Kegiatan')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Agenda Kegiatan</h1>
        <span class="badge badge-solsel fs-8">Jadwal</span>
      </div>
      <p class="admin-page-subtitle">Kelola jadwal kegiatan, rapat, dan acara resmi Pemda Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('agenda.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Agenda
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('agenda.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul atau deskripsi agenda..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif / Dipublikasikan</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft / Nonaktif</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || (request('status') !== null && request('status') !== ''))
          <a href="{{ route('agenda.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Judul Agenda</th>
            <th>Tanggal Pelaksanaan</th>
            <th class="text-center">Durasi</th>
            <th class="text-center">Status</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($agendas as $index => $agenda)
            @php
              $today      = now()->startOfDay();
              $startDate  = $agenda->start_date;
              $endDate    = $agenda->end_date;
              $isOngoing  = $today->between($startDate, $endDate);
              $isUpcoming = $today->lt($startDate);
              $isPast     = $today->gt($endDate);
              $duration   = $startDate->diffInDays($endDate) + 1;
            @endphp
            <tr>
              <td class="text-muted">{{ $agendas->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                       style="width: 40px; height: 40px; background: {{ $isOngoing ? 'rgba(16, 185, 129, 0.15)' : ($isUpcoming ? 'rgba(76, 135, 186, 0.15)' : 'var(--card-sub-bg)') }}; color: {{ $isOngoing ? '#10b981' : ($isUpcoming ? 'var(--solsel-primary)' : 'var(--text-muted)') }};">
                    <i class="bi bi-calendar-event-fill fs-6"></i>
                  </div>
                  <div>
                    <span class="fw-bold d-block text-truncate " style="max-width: 280px;" title="{{ $agenda->title }}">
                      {{ $agenda->title }}
                    </span>
                    @if($agenda->description)
                      <small class="text-muted d-block text-truncate" style="max-width: 280px;">
                        {{ $agenda->description }}
                      </small>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                <div class="fw-bold ">
                  <i class="bi bi-calendar3 me-1 text-muted"></i>
                  {{ $agenda->start_date->format('d M Y') }}
                </div>
                @if(!$agenda->start_date->eq($agenda->end_date))
                  <small class="text-muted d-block mt-0.5">
                    <i class="bi bi-arrow-right me-1"></i>{{ $agenda->end_date->format('d M Y') }}
                  </small>
                @endif
              </td>
              <td class="text-center">
                <span class="badge badge-solsel">
                  {{ $duration }} hari
                </span>
              </td>
              <td class="text-center">
                @if(!$agenda->aktif)
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-eye-slash-fill me-1"></i> Draft
                  </span>
                @elseif($isOngoing)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-broadcast me-1"></i> Berlangsung
                  </span>
                @elseif($isUpcoming)
                  <span class="badge badge-solsel px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-clock me-1"></i> Akan Datang
                  </span>
                @else
                  <span class="badge bg-light text-muted rounded-pill px-3 py-1 fs-8 fw-bold border">
                    <i class="bi bi-check2-circle me-1"></i> Selesai
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('agenda.edit', ['agenda' => $agenda->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Agenda">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('agenda.destroy', ['agenda' => $agenda->id]) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Agenda">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Agenda. Klik <strong>Tambah Agenda</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($agendas->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }} dari {{ $agendas->total() }} Agenda</small>
        <div>{{ $agendas->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
