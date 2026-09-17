@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Pengguna Baru</h1>
      <p class="admin-page-subtitle mb-0">
        Buat akun pengguna baru dan tentukan hak aksesnya dalam sistem.
        <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold ms-2 d-inline-flex align-items-center gap-1 fs-7" data-bs-toggle="modal" data-bs-target="#petunjukModal" data-bs-backdrop="false">
          <i class="bi bi-info-circle"></i> Lihat Petunjuk
        </a>
      </p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="glass-card p-4">
    <form action="{{ route('users.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <!-- Nama Lengkap -->
        <div class="col-12">
          <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control @error('name') is-invalid @enderror"
                 id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Username -->
        <div class="col-12">
          <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control @error('username') is-invalid @enderror"
                 id="username" name="username" value="{{ old('username') }}" placeholder="Contoh: budi_santoso123" required>
          @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Gunakan huruf, angka, atau garis bawah tanpa spasi</small>
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
          <input type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 id="password" name="password" placeholder="Minimal 8 karakter" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="col-md-6">
          <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
          <input type="password"
                 class="form-control"
                 id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
        </div>

        <!-- Role -->
        <div class="col-12">
          <label for="role" class="form-label fw-bold">Hak Akses (Role) <span class="text-danger">*</span></label>
          <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
              <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
          </select>
          @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Menentukan kewenangan pengguna dalam mengakses fitur admin</small>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('users.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Pengguna</button>
      </div>
    </form>
  </div>
@endsection

@push('modals')
<div class="modal fade" id="petunjukModal" tabindex="-1" aria-labelledby="petunjukModalLabel" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--card-bg, #1a1e29); border: 1px solid var(--card-border, rgba(255,255,255,0.08)); border-radius: 24px;">
      <div class="modal-header pb-3" style="border-bottom: 1px solid var(--card-sub-bg, rgba(255,255,255,0.08));">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="petunjukModalLabel">
          <i class="bi bi-info-circle text-primary fs-5"></i>
          Panduan Akun & Hak Akses
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-4">
          <h6 class="fs-7 fw-bold mb-2">Tingkatan Hak Akses:</h6>
          <div class="d-flex flex-column gap-2">
            <div class="p-3 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <h6 class="fs-7 fw-bold text-danger mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock"></i> Super Admin
              </h6>
              <p class="fs-8 text-muted mb-0">Memiliki akses penuh ke seluruh modul sistem, manajemen user, log aktivitas, dan pengaturan website.</p>
            </div>

            <div class="p-3 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <h6 class="fs-7 fw-bold text-info mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-person-gear"></i> Admin / Operator
              </h6>
              <p class="fs-8 text-muted mb-0">Dapat mengelola konten publik (unduhan, berita, agenda, layanan) sesuai pembagian tugas dinas terkait.</p>
            </div>
          </div>
        </div>

        <div class="p-3 rounded-3" style="background: rgba(13, 202, 240, 0.08); border-left: 4px solid #0dcaf0;">
          <h6 class="fs-7 fw-bold mb-1 text-info d-flex align-items-center gap-2">
            <i class="bi bi-shield-check"></i> Tips Keamanan Akun:
          </h6>
          <ul class="list-unstyled mb-0 fs-8 text-muted">
            <li class="mb-1">• Kombinasikan huruf besar, kecil, angka, dan simbol pada password.</li>
            <li class="mb-0">• Pastikan username unik dan mudah diidentifikasi oleh pengelola sistem.</li>
          </ul>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid var(--card-sub-bg, rgba(255,255,255,0.08));">
        <button type="button" class="btn btn-primary px-4 py-2 fs-7" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endpush
