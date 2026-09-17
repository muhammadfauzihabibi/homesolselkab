@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Berita</h1>
        <span class="badge badge-solsel fs-8">Publikasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola dan publikasikan informasi berita Pemerintah Kabupaten Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('berita.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tulis Berita Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('berita.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul atau ringkasan berita..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="kategori" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
              {{ $kategori->nama }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('kategori'))
          <a href="{{ route('berita.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- News Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th style="width: 90px;">Gambar</th>
            <th>Judul Berita</th>
            <th>Kategori</th>
            <th>Tanggal Terbit</th>
            <th class="text-center">Dibaca</th>
            <th class="text-center">Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($beritas as $index => $berita)
            <tr>
              <td class="text-muted">{{ $beritas->firstItem() + $index }}</td>
              <td>
                @if($berita->image)
                  <img src="{{ asset('storage/' . $berita->image) }}"
                       alt="{{ $berita->judul }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @else
                  <div class="rounded-3 text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td style="max-width: 300px;">
                <div class="fw-bold text-truncate " title="{{ $berita->judul }}">{{ $berita->judul }}</div>
                <small class="text-muted d-block text-truncate" style="max-width: 280px;">{{ $berita->ringkas }}</small>
              </td>
              <td>
                <span class="badge badge-solsel">
                  {{ $berita->kategori }}
                </span>
              </td>
              <td class="text-muted">{{ $berita->tanggal_terbit ? $berita->tanggal_terbit->format('d M Y') : '-' }}</td>
              <td class="text-center">
                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1 fs-8 fw-bold">
                  <i class="bi bi-eye-fill me-1"></i> {{ number_format($berita->views_count ?? 0) }}
                </span>
              </td>
              <td class="text-center">
                @if($berita->terbit)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Terbit
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-file-earmark me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('berita.edit', ['berita' => $berita->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Berita">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('berita.destroy', ['berita' => $berita->id]) }}" method="POST" class="delete-form d-inline">
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
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bi bi-newspaper fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data berita. Klik <strong>Tulis Berita Baru</strong> untuk membuat.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($beritas->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }} berita</small>
        <div>{{ $beritas->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
