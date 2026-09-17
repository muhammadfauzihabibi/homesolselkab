@extends('layouts.admin')

@section('title', 'Edit Kategori Berita')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Kategori Berita</h1>
      <p class="admin-page-subtitle">Perbarui informasi kategori untuk berita.</p>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <form action="{{ route('admin.berita.kategori.update', $kategori) }}" method="POST" class="glass-card p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-12">
            <label for="nama" class="form-label fw-bold ">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required autofocus>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="urutan" class="form-label fw-bold ">Urutan Tampil</label>
            <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', $kategori->urutan) }}" min="0" placeholder="0">
            @error('urutan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold ">Status Kategori</label>
            <div class="p-2.5 rounded-4" style="background: var(--card-sub-bg);">
              <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
                <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $kategori->aktif) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold fs-7 ms-2" for="aktifSwitch">
                  <span class="status-text text-primary">{{ old('aktif', $kategori->aktif) ? 'Aktif' : 'Nonaktif' }}</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
          <a href="{{ route('admin.berita.kategori.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Kategori</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const statusToggle = document.getElementById('aktifSwitch');
  const statusText = document.querySelector('.status-text');

  statusToggle.addEventListener('change', function() {
    statusText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
  });
});
</script>
@endpush
