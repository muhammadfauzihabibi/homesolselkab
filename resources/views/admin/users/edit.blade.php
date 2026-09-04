@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Pengguna</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui informasi dan hak akses pengguna.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-4">
        <!-- Nama Lengkap -->
        <div class="col-md-12">
          <label for="name" class="form-label fw-bold text-main">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('name') is-invalid @enderror"
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                 id="name" name="name" value="{{ old('name', $user->name) }}" required>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Username -->
        <div class="col-md-12">
          <label for="username" class="form-label fw-bold text-main">Username <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('username') is-invalid @enderror"
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                 id="username" name="username" value="{{ old('username', $user->username) }}" required>
          @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Role -->
        <div class="col-md-12">
          <label for="role" class="form-label fw-bold text-main">Hak Akses (Role) <span class="text-danger">*</span></label>
          @if($user->hasRole('Super Admin'))
            <div class="alert alert-info d-flex align-items-center rounded-4 border-0 mb-0" style="background: rgba(13, 202, 240, 0.1); color: #0dcaf0;">
              <i class="bi bi-info-circle-fill me-2 fs-5"></i>
              <div>Pengguna ini adalah <strong>Super Admin</strong>. Role tidak dapat diubah.</div>
            </div>
            <input type="hidden" name="role" value="Super Admin">
          @else
            <select class="form-select border-0 py-2.5 px-3 fs-7 @error('role') is-invalid @enderror"
                    style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                    id="role" name="role" required>
              <option value="">-- Pilih Role --</option>
              @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (old('role') ?? $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                  {{ $role->name }}
                </option>
              @endforeach
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
          @endif
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-4 mt-4" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7">Batal</a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">Perbarui Data</button>
      </div>
    </form>
  </div>
@endsection
