@extends('layouts.admin')

@section('title', 'Edit Data Kecamatan')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Data Kecamatan</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui informasi nama dan URL website resmi kecamatan.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('kecamatan.update', ['kecamatan' => $kecamatan->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama Kecamatan -->
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold text-main">Nama Kecamatan <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-geo-alt"></i>
          </span>
          <input type="text" 
                 name="nama" 
                 id="nama" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('nama') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                 placeholder="Contoh: Sangir, Sungai Pagu, Pauh Duo" 
                 value="{{ old('nama', $kecamatan->nama) }}" 
                 required 
                 autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- URL Subdomain / Website -->
      <div class="mb-4">
        <label for="url" class="form-label fw-bold text-main">URL Website / Subdomain <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-link-45deg"></i>
          </span>
          <input type="url" 
                 name="url" 
                 id="url" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('url') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                 placeholder="https://sangir.solokselatankab.go.id" 
                 value="{{ old('url', $kecamatan->url) }}" 
                 required>
          @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <small class="text-muted-custom mt-1 d-block fs-8">Masukkan URL lengkap termasuk http:// atau https://</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7">Batal</a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">Simpan Perubahan</button>
      </div>

    </form>
  </div>
@endsection