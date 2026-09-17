@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Berita</h1>
      <p class="admin-page-subtitle">Perbarui informasi berita atau status publikasi.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('berita.update', ['berita' => $berita->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Judul Berita -->
      <div class="mb-3">
        <label for="judul" class="form-label fw-bold ">Judul Berita <span class="text-danger">*</span></label>
        <input type="text"
               name="judul"
               id="judul"
               class="form-control @error('judul') is-invalid @enderror"
               value="{{ old('judul', $berita->judul) }}"
               required>
        @error('judul')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row g-3 mb-3">
        <!-- Kategori -->
        <div class="col-md-6">
          <label for="kategori_berita_id" class="form-label fw-bold ">Kategori Berita <span class="text-danger">*</span></label>
          <select name="kategori_berita_id" id="kategori_berita_id" class="form-select fw-semibold @error('kategori_berita_id') is-invalid @enderror" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
              <option value="{{ $kategori->id }}" {{ old('kategori_berita_id', $berita->kategori_berita_id) == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
              </option>
            @endforeach
          </select>
          @error('kategori_berita_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Tanggal Terbit -->
        <div class="col-md-6">
          <label for="tanggal_terbit" class="form-label fw-bold ">Tanggal Terbit <span class="text-danger">*</span></label>
          <input type="date"
                 name="tanggal_terbit"
                 id="tanggal_terbit"
                 class="form-control @error('tanggal_terbit') is-invalid @enderror"
                 value="{{ old('tanggal_terbit', $berita->tanggal_terbit ? $berita->tanggal_terbit->format('Y-m-d') : '') }}"
                 required>
          @error('tanggal_terbit')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Upload Gambar Berita -->
      <div class="mb-4">
        <label for="image" class="form-label fw-bold ">Ganti Gambar Berita</label>

        @if($berita->image)
          <div class="mb-3">
            <label class="form-label fs-8 text-muted d-block">Gambar Saat Ini:</label>
            <img src="{{ asset('storage/' . $berita->image) }}"
                 alt="{{ $berita->judul }}"
                 class="rounded-4 border-0 shadow-sm p-2"
                 style="max-height: 180px; object-fit: contain; background: var(--card-sub-bg);">
          </div>
        @endif

        <input type="file"
               name="image"
               id="image"
               class="form-control @error('image') is-invalid @enderror"
               accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
               onchange="previewImage(this)">
        <small class="text-muted mt-1 d-block fs-8">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP, GIF. Maksimal 2 MB.</small>
        @error('image')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <!-- Preview Image Container Baru -->
        <div id="imagePreviewContainer" class="mt-3 d-none">
          <label class="form-label fw-semibold text-muted fs-7">Pratinjau Gambar Baru:</label>
          <div>
            <img id="imagePreview" src="#" alt="Pratinjau Gambar Baru" class="rounded-4 border-0 shadow-sm p-2" style="max-height: 200px; object-fit: contain; background: var(--card-sub-bg);">
          </div>
        </div>
      </div>

      <!-- Ringkasan / Isi Singkat -->
      <div class="mb-4">
        <label for="ringkas" class="form-label fw-bold ">Ringkasan Berita <span class="text-danger">*</span></label>
        <textarea name="ringkas"
                  id="ringkas"
                  rows="3"
                  class="form-control @error('ringkas') is-invalid @enderror"
                  placeholder="Tuliskan ikhtisar atau ringkasan berita di sini..."
                  required>{{ old('ringkas', $berita->ringkas) }}</textarea>
        <div class="form-text text-muted fs-8 mt-1">Maksimal 500 karakter.</div>
        @error('ringkas')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Konten Lengkap Berita -->
      <div class="mb-4">
        <label for="konten" class="form-label fw-bold  mb-2">Isi Berita Lengkap</label>
        <x-tiptap-editor name="konten" id="konten" :value="old('konten', $berita->konten)" />
        @error('konten')
          <div class="text-danger mt-1 fs-8">{{ $message }}</div>
        @enderror
      </div>

      <!-- Status Terbit Checkbox -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="terbit" value="1" id="terbitSwitch" style="width: 2.8em; height: 1.5em;" {{ old('terbit', $berita->terbit) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold  fs-7 ms-2" for="terbitSwitch">
            Publikasikan (Terbit)
          </label>
        </div>
        <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, berita akan tayang di portal publik.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('berita.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Berita</button>
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
