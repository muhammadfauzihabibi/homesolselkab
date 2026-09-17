@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Pengguna</h1>
      <p class="admin-page-subtitle">Perbarui informasi dasar dan hak akses untuk "{{ $user->name }}".</p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="row g-4">
    <div class="col-lg-8">
      <form action="{{ route('users.update', $user->id) }}" method="POST" class="glass-card p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Nama Lengkap -->
          <div class="col-12">
            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Username -->
          <div class="col-12">
            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control @error('username') is-invalid @enderror"
                   id="username" name="username" value="{{ old('username', $user->username) }}" required>
            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Role -->
          <div class="col-12">
            <label for="role" class="form-label fw-bold">Hak Akses (Role) <span class="text-danger">*</span></label>
            @if($user->hasRole('Super Admin'))
              <div class="alert alert-info border-0 rounded-3 mb-0 fs-8 d-flex align-items-center gap-2" style="background: rgba(13, 202, 240, 0.1); color: #0dcaf0;">
                <i class="bi bi-info-circle-fill fs-6"></i>
                <div>Pengguna ini adalah <strong>Super Admin</strong>. Role khusus ini tidak dapat diubah.</div>
              </div>
              <input type="hidden" name="role" value="Super Admin">
            @else
              <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
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
        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
          <a href="{{ route('users.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Pengguna</button>
        </div>
      </form>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-4">
      <div class="glass-card p-4">
        <h6 class="fw-bold mb-3 pb-2 border-bottom">
          <i class="bi bi-person-badge me-2 text-primary"></i>Ringkasan Akun
        </h6>

        <div class="text-center mb-3">
          <div class="p-3 rounded-4" style="background: var(--card-sub-bg);">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary mb-2" style="width: 50px; height: 50px;">
              <i class="bi bi-person-fill fs-3"></i>
            </div>
            <div class="fw-bold fs-7">{{ $user->name }}</div>
            <div class="fs-8 text-muted">@ {{ $user->username }}</div>
          </div>
        </div>

        <div class="border-top pt-3 fs-8 text-muted">
          <div class="mb-1">
            <i class="bi bi-calendar3 me-1"></i> Dibuat: {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
          </div>
          <div class="mb-1">
            <i class="bi bi-pencil me-1"></i> Diperbarui: {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : '-' }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
