@extends('layouts.admin')

@section('title', 'Tambah Dokumentasi')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Tambah Dokumentasi</h1>
      <p class="text-muted-custom mb-0 fs-6">Formulir penambahan data dokumentasi kegiatan baru.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 p-md-5 shadow-sm w-100">
    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="row g-4">
        <!-- Judul Dokumentasi -->
        <div class="col-12">
          <label for="judul" class="form-label fw-bold text-main">Judul Dokumentasi <span class="text-danger">*</span></label>
          <input type="text" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('judul') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;" 
                 id="judul" 
                 name="judul" 
                 value="{{ old('judul') }}" 
                 placeholder="Masukkan judul kegiatan atau dokumentasi" 
                 required 
                 autofocus>
          @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Tanggal Kegiatan -->
        <div class="col-md-6">
          <label for="tanggal" class="form-label fw-bold text-main">Tanggal Kegiatan <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-calendar3"></i>
            </span>
            <input type="date" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('tanggal') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                   id="tanggal" 
                   name="tanggal" 
                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                   required>
            @error('tanggal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Tipe Media -->
        <div class="col-md-6">
          <label for="tipe" class="form-label fw-bold text-main">Tipe Dokumentasi <span class="text-danger">*</span></label>
          <select class="form-select border-0 py-2.5 px-3 fs-7 fw-semibold @error('tipe') is-invalid @enderror" 
                  style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" 
                  id="tipe" 
                  name="tipe" 
                  required 
                  onchange="toggleMediaInput()">
            <option value="gambar" {{ old('tipe') == 'gambar' ? 'selected' : '' }}>Gambar (Upload File)</option>
            <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video (Link YouTube)</option>
          </select>
          @error('tipe')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Input Gambar & Pratinjau -->
        <!-- Input Gambar & Pratinjau (Sesuai Struktur Input Berita) -->
        <div class="col-12" id="input-gambar-container">
          <label for="file_path" class="form-label fw-bold text-main">Upload Gambar <span class="text-danger">*</span></label>
          <input type="file"
                name="file_path"
                id="file_path"
                class="form-control border-0 fs-7 @error('file_path') is-invalid @enderror"
                accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
                onchange="previewImage(this)">
          <small class="text-muted-custom mt-1 d-block fs-8">Format gambar: JPG, PNG, WEBP, GIF. Maksimal 5 MB.</small>
          @error('file_path')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror

          <!-- Preview Image Container -->
          <div id="imagePreviewContainer" class="mt-3 d-none">
            <label class="form-label fw-semibold text-muted-custom fs-7">Pratinjau Gambar:</label>
            <div>
              <img id="imagePreview" src="#" alt="Pratinjau Gambar" class="rounded-4 border-0 shadow-sm" style="max-height: 220px; object-fit: contain; background: var(--card-sub-bg); p-2">
            </div>
          </div>
        </div>
        

        <!-- Input Video -->
        <div class="col-12" id="input-video-container" style="display: none;">
          <label for="url" class="form-label fw-bold text-main">Link YouTube <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: #ef4444; border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-youtube"></i>
            </span>
            <input type="url" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('url') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                   id="url" 
                   name="url" 
                   value="{{ old('url') }}" 
                   placeholder="https://www.youtube.com/watch?v=...">
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8">Pastikan memasukkan URL video lengkap dari YouTube.</small>
          @error('url')
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
          <i class="bi bi-save"></i> Simpan Dokumentasi
        </button>
      </div>
    </form>
  </div>

  <script>
    // Toggle Tipe Media (Gambar / Video)
    function toggleMediaInput() {
      const tipe = document.getElementById('tipe').value;
      const gambarContainer = document.getElementById('input-gambar-container');
      const videoContainer = document.getElementById('input-video-container');
      const fileInput = document.getElementById('file_path');
      const urlInput = document.getElementById('url');

      if (tipe === 'gambar') {
        gambarContainer.style.display = 'block';
        videoContainer.style.display = 'none';
        fileInput.required = true;
        urlInput.required = false;
        urlInput.value = '';
      } else {
        gambarContainer.style.display = 'none';
        videoContainer.style.display = 'block';
        fileInput.required = false;
        urlInput.required = true;
        fileInput.value = '';
        resetPreview();
      }
    }

    // Function Preview Gambar
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

    // Jalankan saat pertama kali halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
      toggleMediaInput();
    });
  </script>

@endsection