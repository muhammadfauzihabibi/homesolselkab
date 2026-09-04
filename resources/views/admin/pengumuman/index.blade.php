@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman')

@section('content')
  <!-- Flash Message Success -->


  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Pengumuman</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola berita acara, pengumuman resmi, dan edaran Pemda Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('pengumuman.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Pengumuman
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('pengumuman.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari judul pengumuman atau konten..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif / Publikasi</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft / Nonaktif</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('status') !== null)
          <a href="{{ route('pengumuman.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0" style="width: 90px;">Gambar</th>
            <th class="border-0">Judul Pengumuman</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0">Tanggal Dibuat</th>
            <th class="border-0 text-end" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($pengumumen as $index => $item)
            <tr>
              <td class="text-muted-custom">{{ $pengumumen->firstItem() + $index }}</td>
              <td>
                @if($item->thumbnail)
                  <img src="{{ asset('storage/' . $item->thumbnail) }}"
                       alt="{{ $item->title }}"
                       class="rounded-3 object-fit-cover shadow-sm"
                       style="width: 60px; height: 46px;">
                @else
                  <div class="rounded-3 text-muted-custom d-flex align-items-center justify-content-center" style="width: 60px; height: 46px; background: var(--card-sub-bg);">
                    <i class="bi bi-image fs-4 opacity-50"></i>
                  </div>
                @endif
              </td>
              <td>
                <div class="fw-bold fs-6 text-truncate text-main" style="max-width: 320px;" title="{{ $item->title }}">
                  {{ $item->title }}
                </div>
                <small class="text-muted-custom d-block text-truncate" style="max-width: 320px;">
                  Slug: {{ $item->slug }}
                </small>
              </td>
              <td class="text-center">
                @if($item->aktif)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(100, 116, 139, 0.15); color: #64748b;">
                    <i class="bi bi-eye-slash-fill me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-muted-custom">
                <i class="bi bi-calendar3 me-1"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('pengumuman.edit', ['pengumuman' => $item->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Pengumuman">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('pengumuman.destroy', ['pengumuman' => $item->id]) }}" method="POST" class="delete-form" style="display:inline;">
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
              <td colspan="6" class="text-center py-5 text-muted-custom">
                <i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Pengumuman. Klik <strong>Tambah Pengumuman</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($pengumumen->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $pengumumen->firstItem() }} - {{ $pengumumen->lastItem() }} dari {{ $pengumumen->total() }} Pengumuman</small>
        <div>{{ $pengumumen->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection