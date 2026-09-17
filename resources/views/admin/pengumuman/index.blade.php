@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Pengumuman</h1>
        <span class="badge badge-solsel fs-8">Informasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola berita acara, pengumuman resmi, dan edaran Pemda Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('pengumuman.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Pengumuman Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('pengumuman.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul pengumuman atau konten..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif / Publikasi</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft / Nonaktif</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || (request('status') !== null && request('status') !== ''))
          <a href="{{ route('pengumuman.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
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
            <th>Judul Pengumuman</th>
            <th class="text-center">Status</th>
            <th>Tanggal Dibuat</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($pengumumen as $index => $item)
            <tr>
              <td class="text-muted">{{ $pengumumen->firstItem() + $index }}</td>
              <td>
                <div class="fw-bold  text-truncate" style="max-width: 320px;" title="{{ $item->title }}">
                  {{ $item->title }}
                </div>
                <small class="text-muted d-block text-truncate fs-8" style="max-width: 320px;">
                  Slug: /{{ $item->slug }}
                </small>
              </td>
              <td class="text-center">
                @if($item->aktif)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td>
                <div class="text-muted fs-8">{{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}</div>
                <small class="text-muted opacity-75 fs-9">{{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}</small>
              </td>
              <td class="text-end">
                <div class="d-flex align-items-center justify-content-end gap-2">
                  <a href="{{ route('pengumuman.edit', ['pengumuman' => $item->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Pengumuman">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('pengumuman.destroy', ['pengumuman' => $item->id]) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Pengumuman">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                <i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Pengumuman. Klik <strong>Tambah Pengumuman Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($pengumumen->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $pengumumen->firstItem() }} - {{ $pengumumen->lastItem() }} dari {{ $pengumumen->total() }} Pengumuman</small>
        <div>{{ $pengumumen->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
