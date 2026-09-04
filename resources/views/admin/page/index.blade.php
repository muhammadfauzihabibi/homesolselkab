@extends('layouts.admin')

@section('title', 'Manajemen Halaman')

@section('content')

  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Halaman</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola data halaman statis dan keterkaitannya dengan menu portal.</p>
    </div>
    <div>
      <a href="{{ route('page.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Halaman
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('page.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari judul halaman..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Publish</option>
          <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('status') !== null && request('status') !== '')
          <a href="{{ route('page.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Page Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Judul Halaman</th>
            <th class="border-0">Menu Navigasi</th>
            <th class="border-0 text-center" style="width: 120px;">Status</th>
            <th class="border-0 text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($pages as $index => $page)
            <tr>
              <td class="text-muted-custom">
                {{ method_exists($pages, 'firstItem') ? $pages->firstItem() + $index : $index + 1 }}
              </td>
              <td>
                <div class="fw-bold text-main">{{ $page->judul }}</div>
              </td>
              <td>
                @if($page->menu)
                  <span class="badge glass-badge" style="background: rgba(37, 99, 235, 0.15); color: #2563eb;">
                    <i class="bi bi-link-45deg me-1"></i> {{ $page->menu->nama }}
                  </span>
                @else
                  <span class="text-muted-custom fs-8 fst-italic">- Tidak terhubung -</span>
                @endif
              </td>
              <td class="text-center">
                @if($page->aktif)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-1"></i> Publish
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">
                    <i class="bi bi-x-circle-fill me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('page.edit', $page->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Halaman">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('page.destroy', $page->id) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Halaman">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5 text-muted-custom">
                <i class="bi bi-file-earmark-text fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data halaman. Klik <strong>Tambah Halaman</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination (Jika Menggunakan Paginator Laravel) -->
    @if(method_exists($pages, 'hasPages') && $pages->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $pages->firstItem() }} - {{ $pages->lastItem() }} dari {{ $pages->total() }} halaman</small>
        <div>{{ $pages->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection