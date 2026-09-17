@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')

  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Menu</h1>
        <span class="badge badge-solsel fs-8">Navigasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola struktur menu portal daerah Pemkab Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('menu.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Menu Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('menu.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-10">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama menu..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Cari Menu</button>
        @if(request('search'))
          <a href="{{ route('menu.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Menu Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Menu</th>
            <th>Slug</th>
            <th>Parent Menu</th>
            <th class="text-center" style="width: 90px;">Urutan</th>
            <th>Tipe</th>
            <th>URL</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($menus as $index => $menu)
            <tr>
              <td class="text-muted">
                {{ method_exists($menus, 'firstItem') ? $menus->firstItem() + $index : $index + 1 }}
              </td>
              <td>
                <div class="fw-bold">{{ $menu->nama }}</div>
              </td>
              <td>
                <span class="badge badge-solsel">
                  /{{ $menu->slug }}
                </span>
              </td>
              <td>
                @if($menu->parent)
                  <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-diagram-2 me-1"></i> {{ $menu->parent->nama }}
                  </span>
                @else
                  <span class="text-muted fs-8 fst-italic">Menu Utama (Root)</span>
                @endif
              </td>
              <td class="text-center">
                <span class="badge badge-solsel">
                  {{ $menu->urutan }}
                </span>
              </td>
              <td>
                @if($menu->tipe == 'internal')
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                        Internal
                    </span>
                @else
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fs-8 fw-bold">
                        External
                    </span>
                @endif
              </td>
              <td class="text-muted">
                {{ $menu->url ?? '-' }}
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <!-- Tombol Edit -->
                  <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Menu">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>

                  <!-- Tombol Hapus -->
                  @if($menu->page->count() === 0 && $menu->children->count() === 0)
                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="delete-form d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Menu">
                        <i class="bi bi-trash text-danger"></i>
                      </button>
                    </form>
                  @else
                    <button class="btn btn-glass-icon d-flex align-items-center justify-content-center opacity-50 cursor-not-allowed"
                            disabled
                            title="{{ $menu->page->count() > 0 ? 'Menu digunakan oleh Halaman (Page)' : 'Menu memiliki Submenu' }}">
                      <i class="bi bi-trash text-secondary"></i>
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bi bi-list-nested fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data menu. Klik <strong>Tambah Menu Baru</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($menus, 'hasPages') && $menus->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $menus->firstItem() }} - {{ $menus->lastItem() }} dari {{ $menus->total() }} menu</small>
        <div>{{ $menus->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>

@endsection
