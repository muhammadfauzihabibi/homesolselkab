@extends('layouts.admin')

@section('title', 'Tambah Kecamatan Baru')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Kecamatan Baru</h1>
      <p class="admin-page-subtitle">Masukkan data kecamatan dan tautan website resmi kecamatan.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('kecamatan.store') }}" method="POST">
      @csrf

      <!-- Nama Kecamatan -->
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold ">Nama Kecamatan <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-geo-alt text-muted"></i>
          </span>
          <input type="text"
                 name="nama"
                 id="nama"
                 class="form-control border-0 py-2 fs-7 @error('nama') is-invalid @enderror"
                 placeholder="Contoh: Sangir, Sungai Pagu, Pauh Duo"
                 value="{{ old('nama') }}"
                 required
                 autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- URL Subdomain / Website -->
      <div class="mb-4">
        <label for="url" class="form-label fw-bold ">URL Website / Subdomain <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-link-45deg text-muted"></i>
          </span>
          <input type="url"
                 name="url"
                 id="url"
                 class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                 placeholder="https://sangir.solokselatankab.go.id"
                 value="{{ old('url') }}"
                 required>
          @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <small class="text-muted mt-1 d-block fs-8">Masukkan URL lengkap termasuk http:// atau https://</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('kecamatan.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Data Kecamatan</button>
      </div>

    </form>
  </div>
@endsection
