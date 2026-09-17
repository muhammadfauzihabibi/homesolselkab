@extends('layouts.admin')

@section('title', 'Manajemen Data Kecamatan')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Data Kecamatan</h1>
        <span class="badge badge-solsel fs-8">Wilayah</span>
      </div>
      <p class="admin-page-subtitle">Kelola daftar kecamatan dan portal website resmi kecamatan di Kabupaten Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('kecamatan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kecamatan Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('kecamatan.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-10">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama kecamatan atau URL website..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Cari</button>
        @if(request('search'))
          <a href="{{ route('kecamatan.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Pencarian">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Kecamatan Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Kecamatan</th>
            <th>URL Website / Subdomain</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($kecamatans as $index => $kecamatan)
            <tr>
              <td class="text-muted">{{ $kecamatans->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: rgba(76, 135, 186, 0.15); color: var(--solsel-primary);">
                    <i class="bi bi-geo-alt-fill fs-6"></i>
                  </div>
                  <div>
                    <span class="fw-bold d-block ">{{ $kecamatan->nama }}</span>
                    <small class="text-muted fs-8">Kabupaten Solok Selatan</small>
                  </div>
                </div>
              </td>
              <td>
                <a href="{{ $kecamatan->url }}" target="_blank" class="text-decoration-none fw-semibold" style="color: var(--solsel-primary);">
                  <i class="bi bi-box-arrow-up-right me-1"></i>{{ $kecamatan->url }}
                </a>
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('kecamatan.edit', ['kecamatan' => $kecamatan->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Kecamatan">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('kecamatan.destroy', ['kecamatan' => $kecamatan->id]) }}" method="POST" class="delete-form d-inline">
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
              <td colspan="4" class="text-center py-5 text-muted">
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
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $kecamatans->firstItem() }} - {{ $kecamatans->lastItem() }} dari {{ $kecamatans->total() }} Kecamatan</small>
        <div>{{ $kecamatans->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
