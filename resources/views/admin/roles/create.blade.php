@extends('layouts.admin')

@section('title', 'Tambah Role')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Role Baru</h1>
      <p class="admin-page-subtitle">Buat grup pengguna baru dan atur izin akses modulnya.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('roles.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <!-- Nama Role -->
        <div class="col-12">
          <label for="name" class="form-label fw-bold ">Nama Role <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-shield-check text-muted"></i>
            </span>
            <input type="text"
                   class="form-control border-0 py-2 fs-7 @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Contoh: Editor Berita"
                   required
                   autofocus>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Hak Akses Modul -->
        <div class="col-12 pt-2">
          <label class="form-label fw-bold  fs-6 mb-3">Hak Akses Modul (Permissions)</label>
          <div class="row g-3">
            @forelse($permissions as $permission)
              <div class="col-md-3 col-sm-6">
                <div class="form-check form-switch p-3 border-0 rounded-4 d-flex align-items-center" style="background: var(--card-sub-bg);">
                  <input class="form-check-input ms-0 me-3 mt-0" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" style="width: 2.2em; height: 1.2em;"
                    {{ old('permissions') && in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                  <label class="form-check-label  fw-bold m-0 fs-7" for="perm_{{ $permission->id }}" style="cursor: pointer">
                    {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                  </label>
                </div>
              </div>
            @empty
              <div class="col-12 text-muted fs-7">Belum ada permission. Silakan buat permission terlebih dahulu.</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('roles.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Role</button>
      </div>
    </form>
  </div>
@endsection
