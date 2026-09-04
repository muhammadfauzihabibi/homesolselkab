@extends('layouts.admin')

@section('title', 'Tambah Role')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Tambah Role Baru</h1>
      <p class="text-muted-custom mb-0 fs-6">Buat grup pengguna baru dan atur izin akses modulnya.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('roles.store') }}" method="POST">
      @csrf

      <div class="row g-4">
        <div class="col-md-12">
          <label for="name" class="form-label fw-bold text-main">Nama Role <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('name') is-invalid @enderror"
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                 id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Editor Berita" required autofocus>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-12 pt-2">
          <label class="form-label fw-bold text-main fs-6 mb-3">Hak Akses Modul (Permissions)</label>
          <div class="row g-3">
            @forelse($permissions as $permission)
              <div class="col-md-3 col-sm-6">
                <div class="form-check form-switch p-3 border-0 rounded-4 d-flex align-items-center" style="background: var(--card-sub-bg);">
                  <input class="form-check-input ms-0 me-3 mt-0" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" style="width: 2.2em; height: 1.2em;"
                    {{ old('permissions') && in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                  <label class="form-check-label text-main fw-bold m-0 fs-7" for="perm_{{ $permission->id }}" style="cursor: pointer">
                    {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                  </label>
                </div>
              </div>
            @empty
              <div class="col-12 text-muted-custom">Belum ada permission. Silakan buat permission terlebih dahulu.</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-4 mt-4" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7">Batal</a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">Simpan Role</button>
      </div>
    </form>
  </div>
@endsection
