@extends('layouts.admin')

@section('title', 'Manajemen Halaman')

@section('content')

  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Halaman</h1>
        <span class="badge badge-solsel fs-8">Statis</span>
      </div>
      <p class="admin-page-subtitle">Kelola data halaman statis dan keterkaitannya dengan menu portal.</p>
    </div>
    <div>
      <a href="{{ route('page.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Halaman Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('page.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul halaman..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Publish</option>
          <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || (request('status') !== null && request('status') !== ''))
          <a href="{{ route('page.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Page Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Judul Halaman</th>
            <th>Menu Navigasi</th>
            <th class="text-center" style="width: 120px;">Status</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($pages as $index => $page)
            <tr>
              <td class="text-muted">
                {{ method_exists($pages, 'firstItem') ? $pages->firstItem() + $index : $index + 1 }}
              </td>
              <td>
                <div class="fw-bold">{{ $page->judul }}</div>
              </td>
              <td>
                @if($page->menu)
                  <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-link-45deg me-1"></i> {{ $page->menu->nama }}
                  </span>
                @else
                  <span class="text-muted fs-8 fst-italic">- Tidak terhubung -</span>
                @endif
              </td>
              <td class="text-center">
                @if($page->aktif)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Publish
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('page.edit', $page->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Halaman">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('page.destroy', $page->id) }}" method="POST" class="delete-form d-inline">
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
              <td colspan="5" class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark-text fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data halaman. Klik <strong>Tambah Halaman Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($pages, 'hasPages') && $pages->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $pages->firstItem() }} - {{ $pages->lastItem() }} dari {{ $pages->total() }} halaman</small>
        <div>{{ $pages->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
