@extends('layouts.admin')

@section('title', 'Edit Layanan Publik')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Layanan Publik</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui data layanan publik yang ditampilkan di portal daerah.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('layanan-publik.update', $layananPublik->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama Layanan -->
      <div class="mb-3">
        <label for="nama" class="form-label fw-bold text-main">Nama Layanan <span class="text-danger">*</span></label>
        <input type="text"
               class="form-control border-0 py-2 px-3 fs-7 @error('nama') is-invalid @enderror"
               style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
               id="nama"
               name="nama"
               value="{{ old('nama', $layananPublik->nama) }}"
               placeholder="Contoh: Pelayanan KTP, SIMPEG, LHKPN, dll."
               required autofocus>
        @error('nama')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Deskripsi -->
      <div class="mb-3">
        <label for="deskripsi" class="form-label fw-bold text-main">Deskripsi Singkat</label>
        <textarea name="deskripsi"
                  id="deskripsi"
                  rows="2"
                  class="form-control border-0 py-2 px-3 fs-7 @error('deskripsi') is-invalid @enderror"
                  style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                  placeholder="Tuliskan keterangan singkat tentang layanan ini...">{{ old('deskripsi', $layananPublik->deskripsi) }}</textarea>
        @error('deskripsi')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- URL Layanan -->
      <div class="mb-3">
        <label for="url" class="form-label fw-bold text-main">URL / Tautan <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-radius: 999px 0 0 999px;">
            <i class="bi bi-link-45deg"></i>
          </span>
          <input type="url"
                 class="form-control border-0 py-2 px-3 fs-7 @error('url') is-invalid @enderror"
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 0 999px 999px 0;"
                 id="url"
                 name="url"
                 value="{{ old('url', $layananPublik->url) }}"
                 placeholder="https://contoh.go.id"
                 required>
        </div>
        @error('url')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <!-- Urutan Tampil -->
      <div class="mb-3">
        <label for="urutan" class="form-label fw-bold text-main">Urutan Tampil</label>
        <input type="number"
               class="form-control border-0 py-2 px-3 fs-7 @error('urutan') is-invalid @enderror"
               style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px; width: 150px;"
               id="urutan"
               name="urutan"
               value="{{ old('urutan', $layananPublik->urutan ?? 0) }}"
               min="0">
        @error('urutan')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
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
          <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch" style="cursor: pointer;">
            Aktifkan Layanan Ini
          </label>
        </div>
        <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, layanan akan tampil di halaman portal umum.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-2" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>
      </div>

    </form>
  </div>

@endsection