@extends('layouts.admin')

@section('title', 'Edit Layanan Publik')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Layanan Publik</h1>
      <p class="admin-page-subtitle">Perbarui data layanan publik yang ditampilkan di portal daerah.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('layanan-publik.update', $layananPublik->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama Layanan -->
      <div class="mb-3">
        <label for="nama" class="form-label fw-bold ">Nama Layanan <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-window text-muted"></i>
          </span>
          <input type="text"
                 class="form-control border-0 py-2 fs-7 @error('nama') is-invalid @enderror"
                 id="nama"
                 name="nama"
                 value="{{ old('nama', $layananPublik->nama) }}"
                 placeholder="Contoh: Pelayanan KTP, SIMPEG, LHKPN, dll."
                 required autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>



      <div class="row g-3 mb-4">
        <!-- URL Layanan -->
        <div class="col-md-12">
          <label for="url" class="form-label fw-bold ">URL / Tautan <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-link-45deg text-muted"></i>
            </span>
            <input type="url"
                   class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                   id="url"
                   name="url"
                   value="{{ old('url', $layananPublik->url) }}"
                   placeholder="https://contoh.go.id"
                   required>
            @error('url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Status Aktif -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0"
                 type="checkbox"
                 name="aktif"
                 value="1"
                 id="aktifSwitch"
                 style="width: 2.8em; height: 1.5em; cursor: pointer;"
                 {{ old('aktif', $layananPublik->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch" style="cursor: pointer;">
            Aktifkan Layanan Ini
          </label>
        </div>
        <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, layanan akan tampil di halaman portal umum.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('layanan-publik.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Perubahan</button>
      </div>

    </form>
  </div>
@endsection
