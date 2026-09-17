@extends('layouts.admin')

@section('title', 'Edit Halaman')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Halaman</h1>
      <p class="admin-page-subtitle">Formulir pembaruan data halaman statis portal daerah.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row g-3">

        <!-- Judul Halaman -->
        <div class="col-12">
          <label for="judul" class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control @error('judul') is-invalid @enderror"
                 id="judul"
                 name="judul"
                 value="{{ old('judul', $page->judul) }}"
                 placeholder="Masukkan judul halaman"
                 required
                 autofocus>
          @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Pilih Menu Navigasi -->
        <div class="col-md-6">
          <label for="menu_id" class="form-label fw-bold">Tautan Menu <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-link-45deg text-muted"></i>
            </span>
            <select class="form-select border-0 py-2 fs-7 fw-semibold @error('menu_id') is-invalid @enderror"
                    id="menu_id"
                    name="menu_id"
                    required>
              <option value="">-- Pilih Menu Navigasi --</option>
              @foreach($menus as $menu)
                <option value="{{ $menu->id }}" {{ old('menu_id', $page->menu_id) == $menu->id ? 'selected' : '' }}>
                  {{ $menu->nama }}
                </option>
              @endforeach
            </select>
          </div>
          @error('menu_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <!-- Deskripsi Singkat -->
        <div class="col-12">
          <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
          <textarea name="deskripsi"
                    id="deskripsi"
                    rows="3"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    placeholder="Tuliskan ringkasan singkat halaman...">{{ old('deskripsi', $page->deskripsi) }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Status Aktif Switch -->
        <div class="col-12">
          <div class="p-3 rounded-4 mb-2" style="background: var(--card-sub-bg);">
            <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
              <input
                  class="form-check-input ms-0"
                  type="checkbox"
                  name="aktif"
                  value="1"
                  id="aktifSwitch"
                  style="width: 2.8em; height: 1.5em;"
                  {{ old('aktif', $page->aktif) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold fs-7 ms-2" for="aktifSwitch">
                Aktifkan Halaman Ini
              </label>
            </div>
            <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, halaman ini dapat diakses pada portal umum Pemda Solok Selatan.</small>
          </div>
        </div>

        <!-- Konten Utama Editor (Custom Tiptap) -->
        <div class="col-12 mb-3">
          <label for="konten" class="form-label fw-bold mb-2">Konten Halaman <span class="text-danger">*</span></label>
          <x-tiptap-editor name="konten" id="konten" :value="old('konten', $page->konten)" />
          @error('konten')
            <div class="text-danger mt-1 fs-8">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('page.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Halaman</button>
      </div>

    </form>
  </div>

@endsection
