@extends('layouts.admin')

@section('title', 'Reset Password Pengguna')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Reset Password Pengguna</h1>
      <p class="text-muted-custom mb-0 fs-6">Atur ulang kata sandi untuk <strong>{{ $user->name }}</strong> ({{ $user->username }}).</p>
    </div>
    <div>
      <a href="{{ url()->previous() }}" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="glass-card p-4 shadow-sm">
    <div class="alert alert-warning d-flex align-items-center rounded-3 border-0 mb-4" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
      <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
      <div>Anda akan mengubah kata sandi untuk pengguna ini. Pastikan untuk memberitahukan pengguna mengenai perubahan ini.</div>
    </div>

    <form action="{{ route('users.update-password', $user->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-4">
        <div class="col-md-6">
          <label for="password" class="form-label text-main fw-semibold">Password Baru <span class="text-danger">*</span></label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label for="password_confirmation" class="form-label text-main fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-dark-pill px-4" style="background-color: var(--bs-danger); border-color: var(--bs-danger);"><i class="bi bi-key me-2"></i> Ubah Password</button>
      </div>
    </form>
  </div>
@endsection
