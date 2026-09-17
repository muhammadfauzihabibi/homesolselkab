@extends('layouts.admin')

@section('title', 'Edit OPD')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Data OPD</h1>
      <p class="admin-page-subtitle">Perbarui informasi Organisasi Perangkat Daerah (OPD) atau status link website.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('opd.update', ['opd' => $opd->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama OPD -->
      <div class="mb-3">
        <label for="nama" class="form-label fw-bold ">Nama OPD / Dinas / Badan <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-building text-muted"></i>
          </span>
          <input type="text"
                 name="nama"
                 id="nama"
                 class="form-control border-0 py-2 fs-7 @error('nama') is-invalid @enderror"
                 value="{{ old('nama', $opd->nama) }}"
                 required>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row g-3 mb-3">
        <!-- Kategori -->
        <div class="col-md-6">
          <label for="kategori" class="form-label fw-bold ">Kategori OPD <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-diagram-3 text-muted"></i>
            </span>
            <select name="kategori" id="kategori" class="form-select border-0 py-2 fs-7 fw-semibold @error('kategori') is-invalid @enderror" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Dinas" {{ old('kategori', $opd->kategori) == 'Dinas' ? 'selected' : '' }}>Dinas</option>
              <option value="Badan" {{ old('kategori', $opd->kategori) == 'Badan' ? 'selected' : '' }}>Badan</option>
              <option value="Sekretariat" {{ old('kategori', $opd->kategori) == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
              <option value="Layanan" {{ old('kategori', $opd->kategori) == 'Layanan' ? 'selected' : '' }}>Layanan</option>
            </select>
          </div>
          @error('kategori')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <!-- URL Subdomain -->
        <div class="col-md-6">
          <label for="url" class="form-label fw-bold ">URL Subdomain / Website <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-link-45deg text-muted"></i>
            </span>
            <input type="url"
                   name="url"
                   id="url"
                   class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                   value="{{ old('url', $opd->url) }}"
                   required>
            @error('url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>



      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $opd->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
            Verifikasi & Aktifkan Link Publik
          </label>
        </div>
        <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, link subdomain OPD akan tampil pada portal publik Pemda Solok Selatan.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('opd.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Perubahan</button>
      </div>

    </form>
  </div>
@endsection
