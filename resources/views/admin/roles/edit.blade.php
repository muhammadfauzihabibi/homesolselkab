@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Role</h1>
      <p class="admin-page-subtitle">Perbarui detail grup dan pengaturan akses modul.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
      @csrf
      @method('PUT')

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
                   value="{{ old('name', $role->name) }}" {{ $role->name === 'Super Admin' ? 'readonly' : 'required' }}>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        @if($role->name === 'Super Admin')
          <div class="col-12 mt-2">
            <div class="alert alert-info d-flex align-items-center rounded-4 border-0 m-0" style="background: rgba(13, 202, 240, 0.1); color: #0dcaf0;">
              <i class="bi bi-shield-lock-fill me-2 fs-5"></i>
              <div><strong>Super Admin</strong> secara otomatis memiliki akses ke seluruh sistem melalui bypass keamanan di background. Anda tidak perlu menceklisnya secara manual.</div>
            </div>
          </div>
        @endif

        <!-- Hak Akses Modul -->
        <div class="col-12 pt-2">
          <label class="form-label fw-bold  fs-6 mb-3">Hak Akses Modul (Permissions)</label>
          <div class="row g-3">
            @foreach($permissions as $permission)
              <div class="col-md-3 col-sm-6">
                <div class="form-check form-switch p-3 border-0 rounded-4 d-flex align-items-center" style="background: var(--card-sub-bg);">
                  <input class="form-check-input ms-0 me-3 mt-0" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" style="width: 2.2em; height: 1.2em;"
                    {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                    {{ $role->name === 'Super Admin' ? 'disabled checked' : '' }}>
                  <label class="form-check-label  fw-bold m-0 fs-7" for="perm_{{ $permission->id }}" style="cursor: pointer">
                    {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('roles.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Role</button>
      </div>
    </form>
  </div>
@endsection
