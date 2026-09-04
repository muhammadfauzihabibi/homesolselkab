@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')

  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Menu</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola struktur menu portal daerah.</p>
    </div>
    <div>
      <a href="{{ route('menu.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Menu
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('menu.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-8">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama menu..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Cari Menu</button>
        @if(request('search'))
          <a href="{{ route('menu.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Menu Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Nama Menu</th>
            <th class="border-0">Slug</th>
            <th class="border-0">Parent Menu</th>
            <th class="border-0 text-center" style="width: 100px;">Urutan</th>
            <th class="border-0">Tipe</th>
            <th class="border-0">URL</th>
            <th class="border-0 text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($menus as $index => $menu)
            <tr>
              <td class="text-muted-custom">
                {{ method_exists($menus, 'firstItem') ? $menus->firstItem() + $index : $index + 1 }}
              </td>
              <td>
                <div class="fw-bold text-main">{{ $menu->nama }}</div>
              </td>
              <td>
                <span class="badge glass-badge" style="background: rgba(100, 116, 139, 0.12); color: var(--text-dark);">
                  /{{ $menu->slug }}
                </span>
              </td>
              <td>
                @if($menu->parent)
                  <span class="badge glass-badge" style="background: rgba(37, 99, 235, 0.15); color: #2563eb;">
                    <i class="bi bi-diagram-2 me-1"></i> {{ $menu->parent->nama }}
                  </span>
                @else
                  <span class="text-muted-custom fs-8 fst-italic">Menu Utama (Root)</span>
                @endif
              </td>
              <td class="text-center">
                <span class="badge rounded-pill bg-light text-dark border px-3 py-1 fs-8">
                  {{ $menu->urutan }}
                </span>
              </td>
              <td>
                @if($menu->tipe == 'internal')
                    <span class="badge bg-success">
                        Internal
                    </span>
                @else
                    <span class="badge bg-primary">
                        External
                    </span>
                @endif
              </td>
              <td>
                {{ $menu->url ?? '-' }}
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <!-- Tombol Edit (Selalu Tampil) -->
                  <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Menu">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>

                  <!-- Tombol Hapus: Hanya Tampil Jika Menu Tidak Digunakan di Page & Tidak Punya Submenu -->
                  @if($menu->page->count() === 0 && $menu->children->count() === 0)
                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="delete-form" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
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
              <td colspan="6" class="text-center py-5 text-muted-custom">
                <i class="bi bi-list-nested fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data menu. Klik <strong>Tambah Menu</strong> untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination (Jika Menggunakan Paginator Laravel) -->
    @if(method_exists($menus, 'hasPages') && $menus->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $menus->firstItem() }} - {{ $menus->lastItem() }} dari {{ $menus->total() }} menu</small>
        <div>{{ $menus->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection