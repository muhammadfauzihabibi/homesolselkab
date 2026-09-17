@extends('layouts.admin')

@section('title', 'Manajemen Poster Digital')

@section('content')
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Poster Digital</h1>
        <span class="badge badge-solsel fs-8">Publikasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola poster digital dan informasi visual publikasi daerah.</p>
    </div>
    <div>
      <a href="{{ route('poster.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Poster Baru
      </a>
    </div>
  </div>

  <div class="glass-card p-3 mb-4">
    <form action="{{ route('poster.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-10">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul atau deskripsi poster..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search'))
          <a href="{{ route('poster.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th style="width: 90px;">Poster</th>
            <th>Judul</th>
            <th>Tanggal Publikasi</th>
            <th class="text-center">Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($posters as $index => $poster)
            <tr>
              <td class="text-muted">{{ $posters->firstItem() + $index }}</td>
              <td>
                @if($poster->foto_poster)
                  <img src="{{ asset('storage/' . $poster->foto_poster) }}"
                       alt="{{ $poster->judul }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @else
                  <div class="rounded-3 text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td style="max-width: 300px;">
                <div class="fw-bold text-truncate" title="{{ $poster->judul }}">{{ $poster->judul }}</div>
                <small class="text-muted d-block text-truncate" style="max-width: 280px;">{{ Str::limit(strip_tags($poster->deskripsi), 80) }}</small>
              </td>
              <td class="text-muted">{{ $poster->tanggal_publikasi ? $poster->tanggal_publikasi->format('d M Y') : '-' }}</td>
              <td class="text-center">
                @if($poster->aktif)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-file-earmark me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('poster.edit', ['poster' => $poster->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Poster">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('poster.destroy', ['poster' => $poster->id]) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Poster">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data poster digital. Klik <strong>Tambah Poster Baru</strong> untuk membuat.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($posters->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $posters->firstItem() }} - {{ $posters->lastItem() }} dari {{ $posters->total() }} poster</small>
        <div>{{ $posters->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
