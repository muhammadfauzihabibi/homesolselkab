@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Pengguna</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola akun dan hak akses pengguna sistem.</p>
    </div>
    <div>
      <a href="{{ route('users.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-person-plus"></i> Tambah Pengguna Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('users.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-4">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama atau username..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-3">
        <select name="role" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Role --</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-3">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('role') || request('status') !== null && request('status') !== '')
          <a href="{{ route('users.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Users Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Informasi Pengguna</th>
            <th class="border-0">Role</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($users as $index => $user)
            <tr>
              <td class="text-muted-custom">{{ $users->firstItem() + $index }}</td>
              <td>
                <div class="fw-bold text-main">{{ $user->name }}</div>
                <small class="text-muted-custom">{{ $user->username }}</small>
              </td>
              <td>
                @foreach($user->roles as $role)
                  <span class="badge glass-badge" style="background: rgba(0, 82, 255, 0.1); color: #0052ff;">
                    {{ $role->name }}
                  </span>
                @endforeach
              </td>
              <td class="text-center">
                @if($user->is_active)
                  <span class="badge glass-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="bi bi-person-check-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge glass-badge" style="background: rgba(220, 53, 69, 0.15); color: #dc3545;">
                    <i class="bi bi-person-x-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('users.reset-password', ['user' => $user->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Reset Password">
                    <i class="bi bi-key text-warning"></i>
                  </a>
                  <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Pengguna">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>

                  @if(!$user->hasRole('Super Admin'))
                    <form action="{{ route('users.toggle-active', ['user' => $user->id]) }}" method="POST" class="d-inline">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                        <i class="bi {{ $user->is_active ? 'bi-person-slash text-secondary' : 'bi-person-check text-success' }}"></i>
                      </button>
                    </form>

                    @if(auth()->id() !== $user->id)
                      <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="delete-form" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Permanen">
                          <i class="bi bi-trash text-danger"></i>
                        </button>
                      </form>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5 text-muted-custom">
                <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data pengguna.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($users->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna</small>
        <div>{{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
