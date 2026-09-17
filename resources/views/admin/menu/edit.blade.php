@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')

  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Menu</h1>
      <p class="admin-page-subtitle">Form pembaruan data menu portal daerah.</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 w-100">
    <form action="{{ route('menu.update', $menu->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">

        <!-- 1. Nama Menu -->
        <div class="col-12">
          <label for="nama" class="form-label fw-bold">Nama Menu <span class="text-danger">*</span></label>
          <input type="text"
                 class="form-control @error('nama') is-invalid @enderror"
                 id="nama"
                 name="nama"
                 value="{{ old('nama', $menu->nama) }}"
                 placeholder="Masukkan nama menu (contoh: Profil Daerah)"
                 required
                 autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- 2. Tipe Menu -->
        <div class="col-md-6">
          <label for="tipe" class="form-label fw-bold">Tipe Menu <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-list-nested text-muted"></i>
            </span>
            <select class="form-select border-0 py-2 fs-7 fw-semibold @error('tipe') is-invalid @enderror"
                    id="tipe"
                    name="tipe"
                    required>
              <option value="internal" {{ old('tipe', $menu->tipe) == 'internal' ? 'selected' : '' }}>Halaman Internal (Dropdown / Parent)</option>
              <option value="external" {{ old('tipe', $menu->tipe) == 'external' ? 'selected' : '' }}>Link Eksternal</option>
            </select>
          </div>
          @error('tipe')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- 3. Parent Menu -->
        <div class="col-md-6">
          <label for="parent_id" class="form-label fw-bold">Parent Menu</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-diagram-2 text-muted"></i>
            </span>
            <select class="form-select border-0 py-2 fs-7 fw-semibold @error('parent_id') is-invalid @enderror"
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
          <small class="text-muted mt-1 d-block fs-8">Pilih parent jika menu ini merupakan sub-menu.</small>
          @error('parent_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- 4. URL Eksternal (Hanya Muncul Jika Tipe = external) -->
        <div class="col-12 d-none" id="container_url">
          <label for="url" class="form-label fw-bold">URL Eksternal <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-link-45deg text-muted"></i>
            </span>
            <input type="url"
                   class="form-control border-0 py-2 fs-7 @error('url') is-invalid @enderror"
                   id="url"
                   name="url"
                   value="{{ old('url', $menu->url) }}"
                   placeholder="https://ppid.solselkab.go.id">
          </div>
          <small class="text-muted mt-1 d-block fs-8">Sertakan protokol lengkap (http:// atau https://).</small>
          @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- 5. Urutan Tampil -->
        <div class="col-12 mb-3">
          <label for="urutan" class="form-label fw-bold">Urutan Tampil</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i class="bi bi-sort-numeric-down text-muted"></i>
            </span>
            <input type="number"
                   class="form-control border-0 py-2 fs-7 @error('urutan') is-invalid @enderror"
                   id="urutan"
                   name="urutan"
                   value="{{ old('urutan', $menu->urutan ?? 0) }}"
                   placeholder="0">
          </div>
          @error('urutan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('menu.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Menu</button>
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

    toggleFields();
    tipeSelect.addEventListener('change', toggleFields);
  });
</script>
@endpush
