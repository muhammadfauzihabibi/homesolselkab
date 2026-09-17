@extends('layouts.admin')

@section('title', 'Manajemen Dokumentasi')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Dokumentasi</h1>
        <span class="badge badge-solsel fs-8">Media</span>
      </div>
      <p class="admin-page-subtitle">Kelola data dokumentasi kegiatan berupa foto maupun video daerah.</p>
    </div>
    <div>
      <a href="{{ route('dokumentasi.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Dokumentasi
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('dokumentasi.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul dokumentasi..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="tipe" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Tipe Media --</option>
          <option value="gambar" {{ request('tipe') == 'gambar' ? 'selected' : '' }}>Gambar / Foto</option>
          <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video (YouTube)</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('tipe'))
          <a href="{{ route('dokumentasi.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Documentation Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Judul Dokumentasi</th>
            <th>Tipe Media</th>
            <th>Tanggal Kegiatan</th>
            <th style="width: 90px;">Preview</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($dokumentasis as $index => $dokumentasi)
            <tr>
              <td class="text-muted">
                {{ method_exists($dokumentasis, 'firstItem') ? $dokumentasis->firstItem() + $index : $index + 1 }}
              </td>
              <td style="max-width: 320px;">
                <div class="fw-bold text-truncate " title="{{ $dokumentasi->judul }}">{{ $dokumentasi->judul }}</div>
              </td>
              <td>
                @if($dokumentasi->tipe == 'gambar')
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-image me-1"></i> Gambar
                  </span>
                @else
                  <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-play-btn-fill me-1"></i> Video
                  </span>
                @endif
              </td>
              <td class="text-muted">
                {{ $dokumentasi->tanggal ? \Carbon\Carbon::parse($dokumentasi->tanggal)->translatedFormat('d M Y') : '-' }}
              </td>
              <td>
                @if($dokumentasi->tipe == 'gambar' && $dokumentasi->file_path)
                  <img src="{{ asset('storage/' . $dokumentasi->file_path) }}"
                       alt="{{ $dokumentasi->judul }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @elseif($dokumentasi->tipe == 'video' && $dokumentasi->url)
                  <a href="{{ $dokumentasi->url }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-8 fw-bold d-inline-flex align-items-center gap-1" title="Putar Video YouTube">
                    <i class="bi bi-youtube fs-7"></i> Tonton
                  </a>
                @else
                  <div class="rounded-3 text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Dokumentasi">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('dokumentasi.destroy', $dokumentasi->id) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Dokumentasi">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-camera-video fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data dokumentasi. Klik <strong>Tambah Dokumentasi</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($dokumentasis, 'hasPages') && $dokumentasis->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $dokumentasis->firstItem() }} - {{ $dokumentasis->lastItem() }} dari {{ $dokumentasis->total() }} dokumentasi</small>
        <div>{{ $dokumentasis->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
