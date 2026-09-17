@extends('layouts.admin')

@section('title', 'Tambah Aplikasi Dinas Baru')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Aplikasi Dinas Baru</h1>
      <p class="admin-page-subtitle">Daftarkan aplikasi dinas baru ke dalam sistem portal Pemda Solok Selatan.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('aplikasi-dinas.store') }}" method="POST">
      @csrf

      <!-- Nama Aplikasi -->
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold ">Nama Aplikasi Dinas <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-window text-muted"></i>
          </span>
          <input type="text"
                 name="nama"
                 id="nama"
                 class="form-control border-0 py-2 fs-7 @error('nama') is-invalid @enderror"
                 placeholder="Contoh: E-Kinerja, SiPBB, Srikandi"
                 value="{{ old('nama') }}"
                 required
                 autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row g-3 mb-4">
        <!-- URL Aplikasi -->
        <div class="col-md-12">
          <label for="url" class="form-label fw-bold ">URL Aplikasi <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-link-45deg text-muted"></i>
            </span>
            <input type="url"
                   name="url"
                   id="url"
                   class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                   placeholder="https://ekinerja.solokselatankab.go.id"
                   value="{{ old('url') }}"
                   required>
            @error('url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <small class="text-muted mt-1 d-block fs-8">Gunakan format URL lengkap (http:// atau https://)</small>
        </div>
      </div>

      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
            Aktifkan Aplikasi Dinas Ini
          </label>
        </div>
        <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, icon/tautan aplikasi ini akan muncul pada portal umum Pemda Solok Selatan.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('aplikasi-dinas.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Data Aplikasi</button>
      </div>

    </form>
  </div>
@endsection
