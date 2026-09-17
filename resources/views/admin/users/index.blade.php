@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Pengguna</h1>
        <span class="badge badge-solsel fs-8">User Access Control</span>
      </div>
      <p class="admin-page-subtitle">Kelola akun dan hak akses pengguna sistem.</p>
    </div>
    <div>
      <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('users.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-4">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama atau username..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-12 col-md-3">
        <select name="role" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Role --</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-12 col-md-3">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('role') || (request('status') !== null && request('status') !== ''))
          <a href="{{ route('users.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Users Data Table Card -->
  <div class="glass-card p-3">
    <!-- Table Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-2 border-bottom">
      <h6 class="fw-bold mb-0">Daftar Pengguna Sistem</h6>
      <span class="badge badge-solsel">{{ $users->total() }} Pengguna</span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Informasi Pengguna</th>
            <th>Role</th>
            <th class="text-center" style="width: 110px;">Status</th>
            <th class="text-end" style="width: 170px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($users as $index => $user)
            <tr>
              <td class="text-muted">{{ $users->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary p-2 flex-shrink-0" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill fs-5"></i>
                  </div>
                  <div>
                    <div class="fw-bold">{{ $user->name }}</div>
                    <small class="text-muted fs-8">@ {{ $user->username }}</small>
                  </div>
                </div>
              </td>
              <td>
                @foreach($user->roles as $role)
                  <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fs-8 fw-bold">
                    {{ $role->name }}
                  </span>
                @endforeach
              </td>
              <td class="text-center">
                @if($user->is_active)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('users.reset-password', ['user' => $user->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Reset Password">
                    <i class="bi bi-key-fill text-warning"></i>
                  </a>
                  <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Pengguna">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>

                  @if(!$user->hasRole('Super Admin'))
                    <form action="{{ route('users.toggle-active', ['user' => $user->id]) }}" method="POST" class="d-inline" id="toggle-form-{{ $user->id }}">
                      @csrf @method('PATCH')
                      <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}" onclick="confirmToggleActive('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})">
                        <i class="bi {{ $user->is_active ? 'bi-person-slash text-secondary' : 'bi-person-check-fill text-success' }}"></i>
                      </button>
                    </form>

                    @if(auth()->id() !== $user->id)
                      <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Permanen" onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
                        <i class="bi bi-trash-fill text-danger"></i>
                      </button>
                      <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" style="display:none;">
                        @csrf @method('DELETE')
                      </form>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-5 text-center text-muted">
                <div class="d-flex flex-column align-items-center gap-2">
                  <i class="bi bi-people fs-1 opacity-50"></i>
                  <span>Belum ada pengguna ditemukan.</span>
                  <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fs-7 mt-1">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna</small>
        <div>{{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
  Swal.fire({
    title: 'Konfirmasi Hapus',
    html: `Apakah Anda yakin ingin menghapus pengguna <strong>"${name}"</strong> secara permanen?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById(`delete-form-${id}`).submit();
    }
  });
}

function confirmToggleActive(id, name, isActive) {
  const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
  const message = isActive
    ? `Apakah Anda yakin ingin menonaktifkan pengguna <strong>"${name}"</strong>?`
    : `Apakah Anda yakin ingin mengaktifkan pengguna <strong>"${name}"</strong>?`;

  Swal.fire({
    title: isActive ? 'Konfirmasi Nonaktifkan' : 'Konfirmasi Aktifkan',
    html: message,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#4c87ba',
    cancelButtonColor: '#6c757d',
    confirmButtonText: `Ya, ${action}`,
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById(`toggle-form-${id}`).submit();
    }
  });
}
</script>
@endpush
