@extends('layouts.admin')

@section('title', 'Manajemen Aplikasi Dinas')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Aplikasi Dinas</h1>
        <span class="badge badge-solsel fs-8">Integrasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola daftar dan tautan aplikasi internal/eksternal milik Dinas Pemda Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('aplikasi-dinas.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Aplikasi Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('aplikasi-dinas.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama aplikasi atau URL..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif / Pending</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('status') !== null)
          <a href="{{ route('aplikasi-dinas.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Aplikasi</th>
            <th>URL Tautan</th>
            <th class="text-center">Status</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($aplikasiDinasList as $index => $aplikasi)
            <tr>
              <td class="text-muted">{{ $aplikasiDinasList->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: rgba(76, 135, 186, 0.15); color: var(--solsel-primary);">
                    <i class="bi bi-grid-3x3-gap-fill fs-6"></i>
                  </div>
                  <div>
                    <span class="fw-bold d-block ">{{ $aplikasi->nama }}</span>
                    <small class="text-muted fs-8">Aplikasi Dinas Solsel</small>
                  </div>
                </div>
              </td>
              <td>
                <a href="{{ $aplikasi->url }}" target="_blank" class="text-decoration-none fw-semibold" style="color: var(--solsel-primary);">
                  <i class="bi bi-box-arrow-up-right me-1"></i>{{ $aplikasi->url }}
                </a>
              </td>
              <td class="text-center">
                @if($aplikasi->aktif)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('aplikasi-dinas.edit', ['aplikasiDinas' => $aplikasi->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Aplikasi">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('aplikasi-dinas.destroy', ['aplikasiDinas' => $aplikasi->id]) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Aplikasi">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                <i class="bi bi-app-indicator fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Aplikasi Dinas. Klik <strong>Tambah Aplikasi Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($aplikasiDinasList->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $aplikasiDinasList->firstItem() }} - {{ $aplikasiDinasList->lastItem() }} dari {{ $aplikasiDinasList->total() }} Aplikasi Dinas</small>
        <div>{{ $aplikasiDinasList->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
