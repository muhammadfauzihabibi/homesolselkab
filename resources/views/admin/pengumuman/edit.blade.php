@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Pengumuman</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui data, konten, atau gambar thumbnail pengumuman.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('pengumuman.update', ['pengumuman' => $pengumuman->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Judul Pengumuman -->
      <div class="mb-4">
        <label for="title" class="form-label fw-bold text-main">Judul Pengumuman <span class="text-danger">*</span></label>
        <input type="text"
               name="title"
               id="title"
               class="form-control border-0 py-2.5 px-3 fs-7 @error('title') is-invalid @enderror"
               style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
               placeholder="Contoh: Pengumuman Seleksi Terbuka Jabatan Pimpinan Tinggi Pratama"
               value="{{ old('title', $pengumuman->title) }}"
               required
               autofocus>
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Upload Gambar / Thumbnail -->
      <div class="mb-4">
        <label for="thumbnail" class="form-label fw-bold text-main">Ganti Gambar / Banner Pengumuman</label>

        @if($pengumuman->thumbnail)
          <div class="mb-3">
            <label class="form-label fs-8 text-muted-custom d-block">Gambar Saat Ini:</label>
            <img src="{{ asset('storage/' . $pengumuman->thumbnail) }}"
                 alt="{{ $pengumuman->title }}"
                 class="rounded-4 border-0 shadow-sm"
                 style="max-height: 180px; object-fit: contain; background: var(--card-sub-bg); p-2">
          </div>
        @endif

        <input type="file"
               name="thumbnail"
               id="thumbnail"
               class="form-control border-0 fs-7 @error('thumbnail') is-invalid @enderror"
               accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
               onchange="previewImage(this)">
        <small class="text-muted-custom mt-1 d-block fs-8">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP, GIF. Maksimal 2 MB.</small>
        @error('thumbnail')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <!-- Preview Image Container Baru -->
        <div id="imagePreviewContainer" class="mt-3 d-none">
          <label class="form-label fw-semibold text-muted-custom fs-7">Pratinjau Gambar Baru:</label>
          <div>
            <img id="imagePreview" src="#" alt="Pratinjau Gambar Baru" class="rounded-4 border-0 shadow-sm" style="max-height: 200px; object-fit: contain; background: var(--card-sub-bg); p-2">
          </div>
        </div>
      </div>

      <!-- Content / Isi Pengumuman -->
      <div class="mb-4">
        <label for="content" class="form-label fw-bold text-main">Isi Pengumuman <span class="text-danger">*</span></label>
        <textarea name="content"
                  id="content"
                  rows="6"
                  class="form-control border-0 py-2.5 px-3 fs-7 @error('content') is-invalid @enderror"
                  style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                  placeholder="Tuliskan detail pengumuman secara rinci di sini..."
                  required>{{ old('content', $pengumuman->content) }}</textarea>
        @error('content')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $pengumuman->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch">
            Publikasikan Pengumuman Ini
          </label>
        </div>
        <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, pengumuman akan tampil pada website publik.</small>
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

  <script>
    function previewImage(input) {
      const container = document.getElementById('imagePreviewContainer');
      const preview = document.getElementById('imagePreview');

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          container.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
      } else {
        container.classList.add('d-none');
      }
    }
  </script>
@endsection