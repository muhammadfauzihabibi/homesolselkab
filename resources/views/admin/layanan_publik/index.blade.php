@extends('layouts.admin')

@section('title', 'Manajemen Layanan Publik')

@section('content')
  <!-- Flash Message Success -->


  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Layanan Publik</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola daftar dan link layanan publik milik Dinas Pemda Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('layanan-publik.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Layanan Publik Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('layanan-publik.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama Layanan Publik atau URL..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif / Pending</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('status') !== null)
          <a href="{{ route('layanan-publik.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Layanan Publik Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 60px;">#</th>
            <th class="border-0">Nama Layanan Publik</th>
            <th class="border-0">Deskripsi</th>
            <th class="border-0">URL Layanan Publik</th>
            <th class="border-0 text-center">Urutan</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0 text-end" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($layananPublikList as $index => $layananPublik)
            <tr>
              <td class="text-muted-custom">{{ $layananPublikList->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(6, 182, 212, 0.15); color: #06b6d4;">
                    <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                  </div>
                  <div>
                    <span class="fw-bold fs-6 d-block text-main">{{ $layananPublik->nama }}</span>
                    <small class="text-muted-custom">Layanan Publik</small>
                  </div>
                </div>
              </td>
              <td style="max-width: 170px;">
                <div class="text-truncate">
                  {{ $layananPublik->deskripsi }}
                </div>
              </td>
              <td>
                <a href="{{ $layananPublik->url }}" target="_blank" class="text-decoration-none fw-semibold" style="color: #38bdf8;">
                  <i class="bi bi-box-arrow-up-right me-1"></i>{{ $layananPublik->url }}
                </a>
              </td>
              <td class="text-center">
                <span class="badge glass-badge" style="background: var(--card-sub-bg); color: var(--text-dark);">
                  {{ $layananPublik->urutan }}
                </span>
              </td>
              <td class="text-center">
                @if($layananPublik->aktif)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(100, 116, 139, 0.15); color: #64748b;">
                    <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('layanan-publik.edit', $layananPublik) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Layanan Publik">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('layanan-publik.destroy', $layananPublik) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Layanan Publik">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted-custom">
                <i class="bi bi-app-indicator fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Layanan Publik. Klik <strong>Tambah Layanan Publik</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($layananPublikList->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $layananPublikList->firstItem() }} - {{ $layananPublikList->lastItem() }} dari {{ $layananPublikList->total() }} Layanan Publik</small>
        <div>{{ $layananPublikList->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection