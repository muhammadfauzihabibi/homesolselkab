@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Menu</h1>
      <p class="text-muted-custom mb-0 fs-6">Form pembaruan data menu portal daerah.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 p-md-5 shadow-sm w-100">
    <form action="{{ route('menu.update', $menu->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-4">
        
        <!-- 1. Nama Menu -->
        <div class="col-12">
          <label for="nama" class="form-label fw-bold text-main">Nama Menu <span class="text-danger">*</span></label>
          <input type="text" 
                 class="form-control border-0 py-2.5 px-3 fs-7 @error('nama') is-invalid @enderror" 
                 style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" 
                 id="nama" 
                 name="nama" 
                 value="{{ old('nama', $menu->nama) }}" 
                 placeholder="Masukkan nama menu (contoh: Profil Daerah)" 
                 required 
                 autofocus>
          @error('nama')
            <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
          @enderror
        </div>

        <!-- 2. Tipe Menu -->
        <div class="col-md-6">
          <label for="tipe" class="form-label fw-bold text-main">Tipe Menu <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-list-nested"></i>
            </span>
            <select class="form-select border-0 py-2.5 px-3 fs-7 fw-semibold @error('tipe') is-invalid @enderror" 
                    style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                    id="tipe" 
                    name="tipe" 
                    required>
              <option value="internal" {{ old('tipe', $menu->tipe) == 'internal' ? 'selected' : '' }}>Halaman Internal (Dropdown / Parent)</option>
              <option value="external" {{ old('tipe', $menu->tipe) == 'external' ? 'selected' : '' }}>Link Eksternal</option>
            </select>
          </div>
          @error('tipe')
            <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
          @enderror
        </div>

        <!-- 3. Parent Menu -->
        <div class="col-md-6">
          <label for="parent_id" class="form-label fw-bold text-main">Parent Menu</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-diagram-2"></i>
            </span>
            <select class="form-select border-0 py-2.5 px-3 fs-7 fw-semibold @error('parent_id') is-invalid @enderror" 
                    style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                    id="parent_id" 
                    name="parent_id">
              <option value="">-- Menu Utama (Root) --</option>
              @foreach($parents as $parent)
                @if($parent->id != $menu->id)
                  <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->nama }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8 ms-3">Pilih parent jika menu ini merupakan sub-menu.</small>
          @error('parent_id')
            <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
          @enderror
        </div>

        <!-- 4. URL Eksternal (Hanya Muncul Jika Tipe = external) -->
        <div class="col-12 d-none" id="container_url">
          <label for="url" class="form-label fw-bold text-main">URL Eksternal <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-link-45deg"></i>
            </span>
            <input type="url" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('url') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                   id="url" 
                   name="url" 
                   value="{{ old('url', $menu->url) }}" 
                   placeholder="https://ppid.solselkab.go.id">
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8 ms-3">Sertakan protokol lengkap (http:// atau https://).</small>
          @error('url')
            <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
          @enderror
        </div>

        <!-- 5. Urutan Tampil -->
        <div class="col-12">
          <label for="urutan" class="form-label fw-bold text-main">Urutan Tampil</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-sort-numeric-down"></i>
            </span>
            <input type="number" 
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('urutan') is-invalid @enderror" 
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" 
                   id="urutan" 
                   name="urutan" 
                   value="{{ old('urutan', $menu->urutan ?? 0) }}" 
                   placeholder="0">
          </div>
          @error('urutan')
            <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-4 mt-4" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <button type="reset" class="btn btn-glass-pill px-4 py-2 fs-7">Reset</button>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-save"></i> Perbarui Menu
        </button>
      </div>
    </form>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tipeSelect = document.getElementById('tipe');
    const containerUrl = document.getElementById('container_url');
    const inputUrl = document.getElementById('url');

    function toggleFields() {
      if (tipeSelect.value === 'external') {
        containerUrl.classList.remove('d-none');
        inputUrl.setAttribute('required', 'required');
      } else {
        containerUrl.classList.add('d-none');
        inputUrl.removeAttribute('required');
      }
    }

    // Pengecekan awal saat pertama kali dimuat
    toggleFields();

    // Event listener setiap kali pilihan tipe menu berubah
    tipeSelect.addEventListener('change', toggleFields);
  });
</script>
@endpush