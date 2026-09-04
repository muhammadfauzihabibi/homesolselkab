@extends('layouts.admin')

@section('title', 'Tambah Halaman')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Tambah Halaman</h1>
      <p class="text-muted-custom mb-0 fs-6">Formulir penambahan data halaman statis baru untuk portal daerah.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 p-md-5 shadow-sm w-100">
    <form action="{{ route('page.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row g-4">
        
        <!-- Judul Halaman -->
        <div class="col-12">
          <label for="judul" class="form-label fw-bold text-main">Judul Halaman <span class="text-danger">*</span></label>
          <input type="text" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('judul') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;" 
                 id="judul" 
                 name="judul" 
                 value="{{ old('judul') }}" 
                 placeholder="Masukkan judul halaman" 
                 required 
                 autofocus>
          @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Pilih Menu Navigasi -->
        <div class="col-md-6">
          <label for="menu_id" class="form-label fw-bold text-main">Tautan Menu <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-link-45deg"></i>
            </span>
            <select class="form-select border-0 py-2.5 px-3 fs-7 fw-semibold @error('menu_id') is-invalid @enderror" 
                    style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                    id="menu_id" 
                    name="menu_id" 
                    required>
              <option value="">-- Pilih Menu Navigasi --</option>
              @foreach($menus as $menu)
                <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
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
          <label for="deskripsi" class="form-label fw-bold text-main">Deskripsi Singkat</label>
          <textarea name="deskripsi" 
                    id="deskripsi" 
                    rows="3" 
                    class="form-control border-0 py-2.5 px-3 fs-7 @error('deskripsi') is-invalid @enderror" 
                    style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;" 
                    placeholder="Tuliskan ringkasan singkat halaman...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Status Publikasi -->
        <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
          <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
            <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch">
              Aktifkan Halaman Ini
            </label>
          </div>
          <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, icon/tautan halaman ini akan muncul pada portal umum Pemda Solok Selatan.</small>
        </div>

        <!-- Upload Thumbnail Gambar & Pratinjau -->
        <div class="col-12">
          <label for="thumbnail" class="form-label fw-bold text-main">Thumbnail Halaman</label>
          <input type="file" 
                 name="thumbnail" 
                 id="thumbnail" 
                 class="form-control border-0 fs-7 @error('thumbnail') is-invalid @enderror" 
                 accept="image/png, image/jpeg, image/jpg, image/webp" 
                 onchange="previewImage(this)">
          <small class="text-muted-custom mt-1 d-block fs-8">Format gambar: JPG, PNG, WEBP. Maksimal 5 MB.</small>
          @error('thumbnail')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror

          <!-- Preview Image Container -->
          <div id="imagePreviewContainer" class="mt-3 d-none">
            <label class="form-label fw-semibold text-muted-custom fs-7">Pratinjau Thumbnail:</label>
            <div>
              <img id="imagePreview" src="#" alt="Pratinjau Thumbnail" class="rounded-4 border-0 shadow-sm" style="max-height: 200px; object-fit: contain; background: var(--card-sub-bg); padding: 8px;">
            </div>
          </div>
        </div>

        <!-- Konten Utama Editor (Custom Tiptap) -->
        <div class="col-12">
          <label for="konten" class="form-label fw-bold text-main mb-2">Konten Halaman <span class="text-danger">*</span></label>
          <x-tiptap-editor name="konten" id="konten" :value="old('konten')" />
          @error('konten')
            <div class="text-danger mt-1 fs-8">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-4 mt-4" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <button type="reset" class="btn btn-glass-pill px-4 py-2 fs-7" onclick="resetPreview()">Reset</button>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-save"></i> Simpan Halaman
        </button>
      </div>

    </form>
  </div>

  <!-- Preview JS -->
  <script>

    // Function Preview Gambar Thumbnail
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
        resetPreview();
      }
    }

    // Reset Image Preview
    function resetPreview() {
      const container = document.getElementById('imagePreviewContainer');
      const preview = document.getElementById('imagePreview');
      if(preview && container) {
        preview.src = '#';
        container.classList.add('d-none');
      }
    }
  </script>

@endsection