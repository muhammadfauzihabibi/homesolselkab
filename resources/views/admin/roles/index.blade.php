@extends('layouts.admin')

@section('title', 'Manajemen Role')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Role</h1>
        <span class="badge badge-solsel fs-8">Otorisasi</span>
      </div>
      <p class="admin-page-subtitle">Kelola grup role pengguna dan konfigurasi batas akses.</p>
    </div>
    <div>
      <a href="{{ route('roles.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Role Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('roles.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-10">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama role..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search'))
          <a href="{{ route('roles.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Roles Data Table Card -->
  <div class="glass-card p-3">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Role</th>
            <th class="text-center">Jumlah User</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($roles as $index => $role)
            <tr>
              <td class="text-muted">{{ $roles->firstItem() + $index }}</td>
              <td>
                <div class="fw-bold ">{{ $role->name }}</div>
                @if($role->name === 'Super Admin')
                  <small class="text-success"><i class="bi bi-shield-check me-1"></i>Akses Penuh</small>
                @endif
              </td>
              <td class="text-center">
                <span class="badge badge-solsel">
                  {{ $role->users_count ?? $role->users()->count() }} Pengguna
                </span>
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Role">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  @if($role->name !== 'Super Admin')
                    <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST" class="delete-form d-inline">
                      @csrf
                      @method('DELETE')
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
              <td colspan="4" class="text-center py-5 text-muted">
                <i class="bi bi-shield fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data role ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $roles->firstItem() }} - {{ $roles->lastItem() }} dari {{ $roles->total() }} role</small>
        <div>{{ $roles->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
