@extends('layouts.admin')

@section('title', 'Edit Poster Digital')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Poster Digital</h1>
      <p class="admin-page-subtitle">Perbarui informasi poster digital dan status publikasi.</p>
    </div>
  </div>

  <div class="glass-card p-4 w-100">
    <form action="{{ route('poster.update', ['poster' => $poster->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="judul" class="form-label fw-bold ">Judul Poster <span class="text-danger">*</span></label>
        <input type="text"
               name="judul"
               id="judul"
               class="form-control @error('judul') is-invalid @enderror"
               value="{{ old('judul', $poster->judul) }}"
               required>
        @error('judul')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="tanggal_publikasi" class="form-label fw-bold ">Tanggal Publikasi <span class="text-danger">*</span></label>
          <input type="date"
                 name="tanggal_publikasi"
                 id="tanggal_publikasi"
                 class="form-control @error('tanggal_publikasi') is-invalid @enderror"
                 value="{{ old('tanggal_publikasi', $poster->tanggal_publikasi ? $poster->tanggal_publikasi->format('Y-m-d') : '') }}"
                 required>
          @error('tanggal_publikasi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="mb-4">
        <label for="foto_poster" class="form-label fw-bold ">Ganti Foto Poster</label>

        @if($poster->foto_poster)
          <div class="mb-3">
            <label class="form-label fs-8 text-muted d-block">Poster Saat Ini:</label>
            <img src="{{ asset('storage/' . $poster->foto_poster) }}"
                 alt="{{ $poster->judul }}"
                 class="rounded-4 border-0 shadow-sm p-2"
                 style="max-height: 180px; object-fit: contain; background: var(--card-sub-bg);">
          </div>
        @endif

        <input type="file"
               name="foto_poster"
               id="foto_poster"
               class="form-control @error('foto_poster') is-invalid @enderror"
               accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
               onchange="previewImage(this)">
        <small class="text-muted mt-1 d-block fs-8">Biarkan kosong jika tidak ingin mengubah poster. Format: JPG, PNG, WEBP, GIF. Maksimal 2 MB.</small>
        @error('foto_poster')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div id="imagePreviewContainer" class="mt-3 d-none">
          <label class="form-label fw-semibold text-muted fs-7">Pratinjau Poster Baru:</label>
          <div>
            <img id="imagePreview" src="#" alt="Pratinjau Poster Baru" class="rounded-4 border-0 shadow-sm p-2" style="max-height: 240px; object-fit: contain; background: var(--card-sub-bg);">
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label for="deskripsi" class="form-label fw-bold ">Deskripsi Poster <span class="text-danger">*</span></label>
        <textarea name="deskripsi"
                  id="deskripsi"
                  rows="5"
                  class="form-control @error('deskripsi') is-invalid @enderror"
                  placeholder="Tuliskan deskripsi poster..."
                  required>{{ old('deskripsi', $poster->deskripsi) }}</textarea>
        @error('deskripsi')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $poster->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
            Publikasikan (Aktif)
          </label>
        </div>
        <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, poster akan tayang di portal publik.</small>
      </div>

      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('poster.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Poster</button>
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
