@extends('layouts.admin')

@section('title', 'Reset Password Pengguna')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Reset Password Pengguna</h1>
      <p class="admin-page-subtitle">Atur ulang kata sandi untuk akun <strong>{{ $user->name }}</strong> (@ {{ $user->username }}).</p>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-12">
      <div class="glass-card p-4">
        <div class="alert alert-warning border-0 rounded-3 mb-4 fs-8 d-flex align-items-center gap-2" style="background: rgba(255, 193, 7, 0.1); color: #856404;">
          <i class="bi bi-exclamation-triangle-fill fs-6 flex-shrink-0"></i>
          <div>Tindakan ini akan langsung mengganti kata sandi lama. Beritahukan kata sandi baru kepada pengguna yang bersangkutan setelah diubah.</div>
        </div>

        <form action="{{ route('users.update-password', $user->id) }}" method="POST">
          @csrf @method('PUT')

          <div class="row g-3">
            <div class="col-md-6">
              <label for="password" class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required autofocus>
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-4" style="border-top: 1px solid var(--card-sub-bg);">
            <a href="{{ route('users.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
              <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-danger px-4 py-2 fs-7 rounded-pill fw-bold">
              <i class="bi bi-key-fill me-1"></i> Ubah Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
