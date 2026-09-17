@extends('layouts.admin')

@section('title', 'Tambah Pengumuman Baru')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Pengumuman Baru</h1>
      <p class="admin-page-subtitle">Buat edaran atau pengumuman resmi untuk masyarakat.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('pengumuman.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <!-- Judul Pengumuman -->
        <div class="col-12">
          <label for="title" class="form-label fw-bold ">Judul Pengumuman <span class="text-danger">*</span></label>
          <input type="text"
                 name="title"
                 id="title"
                 class="form-control @error('title') is-invalid @enderror"
                 placeholder="Contoh: Pengumuman Seleksi Terbuka Jabatan Pimpinan Tinggi Pratama"
                 value="{{ old('title') }}"
                 required
                 autofocus>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Content / Isi Pengumuman -->
        <div class="col-12 mb-2">
          <label for="content" class="form-label fw-bold  mb-2">Isi Pengumuman <span class="text-danger">*</span></label>
          <x-tiptap-editor name="content" id="content" :value="old('content')" />
          @error('content')
            <div class="text-danger mt-1 fs-8">{{ $message }}</div>
          @enderror
        </div>

        <!-- Status Aktif Switch -->
        <div class="col-12">
          <div class="p-3 rounded-4 mb-2" style="background: var(--card-sub-bg);">
            <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
              <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                Publikasikan Pengumuman Ini
              </label>
            </div>
            <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, pengumuman akan langsung tampil pada website publik.</small>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('pengumuman.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Pengumuman</button>
      </div>

    </form>
  </div>
@endsection
