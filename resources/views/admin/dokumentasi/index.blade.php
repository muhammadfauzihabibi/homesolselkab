@extends('layouts.admin')

@section('title', 'Manajemen Dokumentasi')

@section('content')
  <!-- Flash Message Success -->
  @if(session('success'))
    <div class="alert glass-card border-0 text-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15);">
      <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Dokumentasi</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola data dokumentasi kegiatan berupa foto maupun video daerah.</p>
    </div>
    <div>
      <a href="{{ route('dokumentasi.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Dokumentasi
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('dokumentasi.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari judul dokumentasi..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="tipe" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Tipe Media --</option>
          <option value="gambar" {{ request('tipe') == 'gambar' ? 'selected' : '' }}>Gambar / Foto</option>
          <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video (YouTube)</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('tipe'))
          <a href="{{ route('dokumentasi.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Documentation Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Judul Dokumentasi</th>
            <th class="border-0">Tipe Media</th>
            <th class="border-0">Tanggal Kegiatan</th>
            <th class="border-0" style="width: 90px;">Preview</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($dokumentasis as $index => $dokumentasi)
            <tr>
              <td class="text-muted-custom">
                {{ method_exists($dokumentasis, 'firstItem') ? $dokumentasis->firstItem() + $index : $index + 1 }}
              </td>
              <td style="max-width: 320px;">
                <div class="fw-bold text-truncate text-main" title="{{ $dokumentasi->judul }}">{{ $dokumentasi->judul }}</div>
              </td>
              <td>
                @if($dokumentasi->tipe == 'gambar')
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-image me-1"></i> Gambar
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">
                    <i class="bi bi-play-btn-fill me-1"></i> Video
                  </span>
                @endif
              </td>
              <td class="text-muted-custom">
                {{ $dokumentasi->tanggal ? \Carbon\Carbon::parse($dokumentasi->tanggal)->translatedFormat('d M Y') : '-' }}
              </td>
              <td>
                @if($dokumentasi->tipe == 'gambar' && $dokumentasi->file_path)
                  <img src="{{ asset('storage/' . $dokumentasi->file_path) }}"
                       alt="{{ $dokumentasi->judul }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @elseif($dokumentasi->tipe == 'video' && $dokumentasi->url)
                  <a href="{{ $dokumentasi->url }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 fs-8 fw-semibold d-inline-flex align-items-center gap-1" title="Putar Video YouTube">
                    <i class="bi bi-youtube fs-7"></i> Tonton
                  </a>
                @else
                  <div class="rounded-3 text-muted-custom d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Dokumentasi">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('dokumentasi.destroy', $dokumentasi->id) }}" method="POST" class="delete-form" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
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
              <td colspan="6" class="text-center py-5 text-muted-custom">
                <i class="bi bi-camera-video fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data dokumentasi. Klik <strong>Tambah Dokumentasi</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination (Jika Menggunakan Paginator Laravel) -->
    @if(method_exists($dokumentasis, 'hasPages') && $dokumentasis->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $dokumentasis->firstItem() }} - {{ $dokumentasis->lastItem() }} dari {{ $dokumentasis->total() }} dokumentasi</small>
        <div>{{ $dokumentasis->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection