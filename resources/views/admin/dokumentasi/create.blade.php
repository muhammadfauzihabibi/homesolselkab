@extends('layouts.admin')

@section('title', 'Tambah Dokumentasi')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Dokumentasi</h1>
      <p class="admin-page-subtitle">Formulir penambahan data dokumentasi kegiatan baru.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row g-3">
        <!-- Judul Dokumentasi -->
        <div class="col-12">
          <label for="judul" class="form-label fw-bold ">Judul Dokumentasi <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control @error('judul') is-invalid @enderror"
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
          <label for="tanggal" class="form-label fw-bold ">Tanggal Kegiatan <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-calendar3 text-muted"></i>
            </span>
            <input type="date"
                   class="form-control border-0 py-2 fs-7 @error('tanggal') is-invalid @enderror"
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
          <label for="tipe" class="form-label fw-bold ">Tipe Dokumentasi <span class="text-danger">*</span></label>
          <select class="form-select fw-semibold @error('tipe') is-invalid @enderror"
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
        <div class="col-12 mb-3" id="input-gambar-container">
          <label for="file_path" class="form-label fw-bold ">Upload Gambar <span class="text-danger">*</span></label>
          <input type="file"
                 name="file_path"
                 id="file_path"
                 class="form-control @error('file_path') is-invalid @enderror"
                 accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
                 onchange="previewImage(this)">
          <small class="text-muted mt-1 d-block fs-8">Format gambar: JPG, PNG, WEBP, GIF. Maksimal 5 MB.</small>
          @error('file_path')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror

          <!-- Preview Image Container -->
          <div id="imagePreviewContainer" class="mt-3 d-none">
            <label class="form-label fw-semibold text-muted fs-7">Pratinjau Gambar:</label>
            <div>
              <img id="imagePreview" src="#" alt="Pratinjau Gambar" class="rounded-4 border-0 shadow-sm p-2" style="max-height: 220px; object-fit: contain; background: var(--card-sub-bg);">
            </div>
          </div>
        </div>

        <!-- Input Video -->
        <div class="col-12 mb-3" id="input-video-container" style="display: none;">
          <label for="url" class="form-label fw-bold ">Link YouTube <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-youtube text-danger"></i>
            </span>
            <input type="url"
                   class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                   id="url"
                   name="url"
                   value="{{ old('url') }}"
                   placeholder="https://www.youtube.com/watch?v=...">
          </div>
          <small class="text-muted mt-1 d-block fs-8">Pastikan memasukkan URL video lengkap dari YouTube.</small>
          @error('url')
            <div class="text-danger mt-1 fs-8">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('dokumentasi.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Dokumentasi</button>
      </div>
    </form>
  </div>

  <script>
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

    function resetPreview() {
      const container = document.getElementById('imagePreviewContainer');
      const preview = document.getElementById('imagePreview');
      if(preview && container) {
        preview.src = '#';
        container.classList.add('d-none');
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      toggleMediaInput();
    });
  </script>
@endsection
