@extends('layouts.admin')

@section('title', 'Edit OPD')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Data OPD</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui informasi Organisasi Perangkat Daerah (OPD) atau status link website.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('opd.update', ['opd' => $opd->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama OPD -->
      <div class="mb-3">
        <label for="nama" class="form-label fw-bold text-main">Nama OPD / Dinas / Badan <span class="text-danger">*</span></label>
        <input type="text" 
               name="nama" 
               id="nama" 
               class="form-control border-0 py-2.5 px-3 fs-7 @error('nama') is-invalid @enderror" 
               style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
               value="{{ old('nama', $opd->nama) }}" 
               required>
        @error('nama')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row g-3 mb-3">
        <!-- Kategori -->
        <div class="col-md-6">
          <label for="kategori" class="form-label fw-bold text-main">Kategori OPD <span class="text-danger">*</span></label>
          <select name="kategori" id="kategori" class="form-select border-0 py-2.5 px-3 fs-7 fw-semibold @error('kategori') is-invalid @enderror" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Dinas" {{ old('kategori', $opd->kategori) == 'Dinas' ? 'selected' : '' }}>Dinas</option>
            <option value="Badan" {{ old('kategori', $opd->kategori) == 'Badan' ? 'selected' : '' }}>Badan</option>
            <option value="Sekretariat" {{ old('kategori', $opd->kategori) == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
            <option value="Layanan" {{ old('kategori', $opd->kategori) == 'Layanan' ? 'selected' : '' }}>Layanan</option>
          </select>
          @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- URL Subdomain -->
        <div class="col-md-6">
          <label for="url" class="form-label fw-bold text-main">URL Subdomain / Website <span class="text-danger">*</span></label>
          <input type="url" 
                 name="url" 
                 id="url" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('url') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                 value="{{ old('url', $opd->url) }}" 
                 required>
          @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label for="deskripsi" class="form-label fw-bold text-main">Deskripsi Singkat Layanan OPD <span class="text-danger">*</span></label>
        <textarea name="deskripsi" 
                  id="deskripsi" 
                  rows="3" 
                  class="form-control border-0 py-2.5 px-3 fs-7 @error('deskripsi') is-invalid @enderror" 
                  style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                  required>{{ old('deskripsi', $opd->deskripsi) }}</textarea>
        <div class="form-text text-muted-custom fs-8 mt-1">Maksimal 500 karakter.</div>
        @error('deskripsi')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $opd->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch">
            Verifikasi & Aktifkan Link Publik
          </label>
        </div>
        <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, link subdomain OPD akan tampil pada portal publik Pemda Solok Selatan.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-2" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7">Batal</a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">Perbarui Data OPD</button>
      </div>

    </form>
  </div>
@endsection