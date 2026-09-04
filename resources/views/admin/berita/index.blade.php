@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
  <!-- Flash Message Success -->


  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Berita Daerah</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola dan publikasikan informasi berita Pemerintah Kabupaten Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('berita.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Berita Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('berita.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari judul atau ringkasan berita..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="kategori" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          <option value="Pemerintahan" {{ request('kategori') == 'Pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
          <option value="Pembangunan" {{ request('kategori') == 'Pembangunan' ? 'selected' : '' }}>Pembangunan</option>
          <option value="Ekonomi" {{ request('kategori') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
          <option value="Sosial Budaya" {{ request('kategori') == 'Sosial Budaya' ? 'selected' : '' }}>Sosial Budaya</option>
          <option value="Pengumuman" {{ request('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('kategori'))
          <a href="{{ route('berita.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- News Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0" style="width: 90px;">Gambar</th>
            <th class="border-0">Judul Berita</th>
            <th class="border-0">Kategori</th>
            <th class="border-0">Tanggal Terbit</th>
            <th class="border-0 text-center">Dibaca</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($beritas as $index => $berita)
            <tr>
              <td class="text-muted-custom">{{ $beritas->firstItem() + $index }}</td>
              <td>
                @if($berita->image)
                  <img src="{{ asset('storage/' . $berita->image) }}"
                       alt="{{ $berita->judul }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @else
                  <div class="rounded-3 text-muted-custom d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td style="max-width: 320px;">
                <div class="fw-bold text-truncate text-main" title="{{ $berita->judul }}">{{ $berita->judul }}</div>
                <small class="text-muted-custom d-block text-truncate" style="max-width: 300px;">{{ $berita->ringkas }}</small>
              </td>
              <td>
                <span class="badge glass-badge" style="background: rgba(0, 82, 255, 0.1); color: #0052ff;">
                  {{ $berita->kategori }}
                </span>
              </td>
              <td class="text-muted-custom">{{ $berita->tanggal_terbit ? $berita->tanggal_terbit->format('d M Y') : '-' }}</td>
              <td class="text-center">
                <span class="badge glass-badge" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;">
                  <i class="bi bi-eye-fill me-1"></i> {{ number_format($berita->views_count ?? 0) }}
                </span>
              </td>
              <td class="text-center">
                @if($berita->terbit)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-1"></i> Terbit
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(100, 116, 139, 0.15); color: #64748b;">
                    <i class="bi bi-file-earmark me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('berita.edit', ['berita' => $berita->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Berita">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('berita.destroy', ['berita' => $berita->id]) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Berita">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted-custom">
                <i class="bi bi-newspaper fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data berita. Klik <strong>Tambah Berita Baru</strong> untuk membuat.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($beritas->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }} berita</small>
        <div>{{ $beritas->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection