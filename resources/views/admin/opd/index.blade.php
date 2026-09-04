@extends('layouts.admin')

@section('title', 'Manajemen OPD & Layanan')

@section('content')
  <!-- Flash Message Success -->


  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Organisasi Perangkat Daerah (OPD)</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola data OPD, website dinas/badan, dan portal layanan Kabupaten Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('opd.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah OPD Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('opd.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama OPD, subdomain, atau deskripsi..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="kategori" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          <option value="Dinas" {{ request('kategori') == 'Dinas' ? 'selected' : '' }}>Dinas</option>
          <option value="Badan" {{ request('kategori') == 'Badan' ? 'selected' : '' }}>Badan</option>
          <option value="Sekretariat" {{ request('kategori') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
          <option value="Layanan" {{ request('kategori') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('kategori'))
          <a href="{{ route('opd.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- OPD Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0">#</th>
            <th class="border-0">Nama OPD</th>
            <th class="border-0">Kategori</th>
            <th class="border-0">URL Website / Subdomain</th>
            <th class="border-0 text-center">Status Link</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($opds as $index => $opd)
            <tr>
              <td class="text-muted-custom">{{ $opds->firstItem() + $index }}</td>
              <td style="max-width: 280px;">
                <div class="fw-bold text-truncate text-main" title="{{ $opd->nama }}">{{ $opd->nama }}</div>
                <small class="text-muted-custom d-block text-truncate" style="max-width: 260px;">{{ $opd->deskripsi }}</small>
              </td>
              <td>
                <span class="badge glass-badge" style="background: rgba(0, 82, 255, 0.1); color: #0052ff;">
                  {{ $opd->kategori }}
                </span>
              </td>
              <td>
                <a href="{{ $opd->url }}" target="_blank" class="text-decoration-none fw-semibold" style="color: #38bdf8;">
                  <i class="bi bi-link-45deg me-1"></i>{{ $opd->url }}
                </a>
              </td>
              <td class="text-center">
                @if($opd->aktif)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                    <i class="bi bi-clock-history me-1"></i> Pending / Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('opd.edit', ['opd' => $opd->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit OPD">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('opd.destroy', ['opd' => $opd->id]) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus OPD">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted-custom">
                <i class="bi bi-building fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data OPD. Klik <strong>Tambah OPD Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($opds->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $opds->firstItem() }} - {{ $opds->lastItem() }} dari {{ $opds->total() }} OPD</small>
        <div>{{ $opds->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection