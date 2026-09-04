@extends('layouts.admin')

@section('title', 'Manajemen Role')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Role</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola grup role pengguna dan konfigurasi batas akses.</p>
    </div>
    <div>
      <a href="{{ route('roles.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-shield-plus"></i> Tambah Role Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('roles.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-10">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama role..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search'))
          <a href="{{ route('roles.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Roles Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Nama Role</th>
            <th class="border-0 text-center">Jumlah User</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($roles as $index => $role)
            <tr>
              <td class="text-muted-custom">{{ $roles->firstItem() + $index }}</td>
              <td>
                <div class="fw-bold text-main">{{ $role->name }}</div>
                @if($role->name === 'Super Admin')
                  <small class="text-success"><i class="bi bi-shield-check me-1"></i>Akses Penuh</small>
                @endif
              </td>
              <td class="text-center">
                <span class="badge glass-badge" style="background: rgba(0, 82, 255, 0.1); color: #0052ff;">
                  {{ $role->users_count ?? $role->users()->count() }} Pengguna
                </span>
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Role">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  @if($role->name !== 'Super Admin')
                    <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST" class="delete-form" style="display:inline;">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Role">
                        <i class="bi bi-trash text-danger"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-5 text-muted-custom">
                <i class="bi bi-shield fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data role ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($roles->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $roles->firstItem() }} - {{ $roles->lastItem() }} dari {{ $roles->total() }} role</small>
        <div>{{ $roles->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
