@extends('layouts.admin')

@section('title', 'Manajemen Data Kecamatan')

@section('content')
  <!-- Flash Message Success -->


  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Data Kecamatan</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola daftar kecamatan dan portal website resmi kecamatan di Kabupaten Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('kecamatan.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Kecamatan Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('kecamatan.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-9">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama kecamatan atau URL website..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Cari</button>
        @if(request('search'))
          <a href="{{ route('kecamatan.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Pencarian">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Kecamatan Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 60px;">#</th>
            <th class="border-0">Nama Kecamatan</th>
            <th class="border-0">URL Website / Subdomain</th>
            <th class="border-0 text-end" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($kecamatans as $index => $kecamatan)
            <tr>
              <td class="text-muted-custom">{{ $kecamatans->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(0, 82, 255, 0.1); color: #0052ff;">
                    <i class="bi bi-geo-alt-fill fs-5"></i>
                  </div>
                  <div>
                    <span class="fw-bold fs-6 d-block text-main">{{ $kecamatan->nama }}</span>
                    <small class="text-muted-custom">Kabupaten Solok Selatan</small>
                  </div>
                </div>
              </td>
              <td>
                <a href="{{ $kecamatan->url }}" target="_blank" class="text-decoration-none fw-semibold" style="color: #38bdf8;">
                  <i class="bi bi-box-arrow-up-right me-1"></i>{{ $kecamatan->url }}
                </a>
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('kecamatan.edit', ['kecamatan' => $kecamatan->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Kecamatan">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('kecamatan.destroy', ['kecamatan' => $kecamatan->id]) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Kecamatan">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-5 text-muted-custom">
                <i class="bi bi-geo-alt fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Kecamatan. Klik <strong>Tambah Kecamatan Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($kecamatans->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $kecamatans->firstItem() }} - {{ $kecamatans->lastItem() }} dari {{ $kecamatans->total() }} Kecamatan</small>
        <div>{{ $kecamatans->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection