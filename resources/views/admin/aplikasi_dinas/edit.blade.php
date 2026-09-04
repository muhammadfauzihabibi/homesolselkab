@extends('layouts.admin')

@section('title', 'Edit Aplikasi Dinas')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Aplikasi Dinas</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui nama, URL, urutan, atau status aplikasi dinas.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('aplikasi-dinas.update', ['aplikasiDinas' => $aplikasiDinas->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama Aplikasi -->
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold text-main">Nama Aplikasi Dinas <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-window"></i>
          </span>
          <input type="text" 
                 name="nama" 
                 id="nama" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('nama') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                 placeholder="Contoh: E-Kinerja, SiPBB, Srikandi" 
                 value="{{ old('nama', $aplikasiDinas->nama) }}" 
                 required 
                 autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row g-3 mb-4">
        <!-- URL Aplikasi -->
        <div class="col-md-8">
          <label for="url" class="form-label fw-bold text-main">URL Aplikasi <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-link-45deg"></i>
            </span>
            <input type="url" 
                   name="url" 
                   id="url" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('url') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                   placeholder="https://ekinerja.solokselatankab.go.id" 
                   value="{{ old('url', $aplikasiDinas->url) }}" 
                   required>
            @error('url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8">Gunakan format URL lengkap (http:// atau https://)</small>
        </div>

        <!-- Urutan -->
        <div class="col-md-4">
          <label for="urutan" class="form-label fw-bold text-main">Urutan Tampil</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-sort-numeric-down"></i>
            </span>
            <input type="number" 
                   name="urutan" 
                   id="urutan" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('urutan') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                   placeholder="0" 
                   value="{{ old('urutan', $aplikasiDinas->urutan) }}" 
                   min="0">
            @error('urutan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8">Semakin kecil angka, posisi semakin atas.</small>
        </div>
      </div>

      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $aplikasiDinas->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch">
            Aktifkan Aplikasi Dinas Ini
          </label>
        </div>
        <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, icon/tautan aplikasi ini akan muncul pada portal umum Pemda Solok Selatan.</small>
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