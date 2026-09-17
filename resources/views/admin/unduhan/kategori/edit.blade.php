@extends('layouts.admin')

@section('title', 'Edit Kategori Unduhan')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Kategori Unduhan</h1>
      <p class="admin-page-subtitle">Perbarui informasi kategori "{{ $kategori->nama }}".</p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="row g-4">
    <div class="col-lg-8">
      <form action="{{ route('admin.unduhan.kategori.update', $kategori) }}" method="POST" class="glass-card p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Nama Kategori -->
          <div class="col-12">
            <label for="nama" class="form-label fw-bold ">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" placeholder="Contoh: Anggaran, Laporan, Regulasi..." required autofocus>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">Slug URL: <code>{{ $kategori->slug }}</code></small>
          </div>

          <!-- Deskripsi -->
          <div class="col-12">
            <label for="deskripsi" class="form-label fw-bold ">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan kategori ini secara singkat...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Icon -->
          <div class="col-12">
            <label for="icon" class="form-label fw-bold ">Icon Bootstrap</label>
            <div class="input-group">
              <span class="input-group-text border-0 ps-3">
                <i id="icon-preview" class="{{ old('icon', $kategori->icon ?: 'bi-folder') }} text-primary"></i>
              </span>
              <input type="text" class="form-control border-0 py-2 fs-7 @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $kategori->icon) }}" placeholder="bi-folder, bi-file-text, bi-cash-coin...">
            </div>
            @error('icon')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">
              Gunakan class icon Bootstrap (contoh: bi-folder, bi-file-text).
              <a href="https://icons.getbootstrap.com/" target="_blank" class="text-primary text-decoration-underline">Lihat icon tersedia</a>
            </small>
          </div>

          <!-- Urutan Tampil -->
          <div class="col-md-6">
            <label for="urutan" class="form-label fw-bold ">Urutan Tampil</label>
            <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', $kategori->urutan) }}" min="0" placeholder="0">
            @error('urutan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">Angka lebih kecil akan ditampilkan lebih dulu</small>
          </div>

          <!-- Status Switch -->
          <div class="col-md-6">
            <label class="form-label fw-bold ">Status Kategori</label>
            <div class="p-2.5 rounded-4" style="background: var(--card-sub-bg);">
              <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
                <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $kategori->aktif) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                  <span class="status-text text-primary">{{ old('aktif', $kategori->aktif) ? 'Aktif' : 'Nonaktif' }}</span>
                </label>
              </div>
            </div>
            <small class="form-text text-muted mt-1 d-block fs-8">Kategori nonaktif tidak akan tampil di frontend</small>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
          <a href="{{ route('admin.unduhan.kategori.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Kategori</button>
        </div>
      </form>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-4">
      <div class="glass-card p-4 mb-3">
        <h6 class="fw-bold  mb-3 pb-2 border-bottom">
          <i class="bi bi-bar-chart-line me-2 text-primary"></i>Statistik Kategori
        </h6>

        <div class="row g-2 text-center mb-3">
          <div class="col-6">
            <div class="p-3 rounded-4" style="background: var(--card-sub-bg);">
              <div class="fs-3 fw-bold text-info">{{ $kategori->jenisUnduhans()->count() }}</div>
              <div class="fs-8 text-muted">Jenis Dokumen</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-4" style="background: var(--card-sub-bg);">
              <div class="fs-3 fw-bold text-success">{{ $kategori->unduhans()->count() }}</div>
              <div class="fs-8 text-muted">Total Dokumen</div>
            </div>
          </div>
        </div>

        <div class="border-top pt-3 fs-8 text-muted">
          <div class="mb-1">
            <i class="bi bi-calendar3 me-1"></i> Dibuat: {{ $kategori->created_at->format('d M Y, H:i') }}
          </div>
          @if($kategori->updated_at != $kategori->created_at)
            <div>
              <i class="bi bi-pencil me-1"></i> Diperbarui: {{ $kategori->updated_at->format('d M Y, H:i') }}
            </div>
          @endif
        </div>
      </div>

      <div class="glass-card p-4">
        <h6 class="fw-bold  mb-3 pb-2 border-bottom">
          <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Peringatan
        </h6>

        <div class="alert alert-warning border-0 rounded-3 mb-0 fs-8" style="background: rgba(255, 193, 7, 0.1); color: #856404;">
          <strong>Perhatian:</strong><br>
          Jika kategori ini memiliki jenis dokumen atau dokumen aktif, pastikan perubahan tidak mengganggu struktur yang sudah ada.
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const iconInput = document.getElementById('icon');
  const iconPreview = document.getElementById('icon-preview');

  iconInput.addEventListener('input', function() {
    const iconClass = this.value.trim();
    if (iconClass) {
      iconPreview.className = iconClass + ' text-primary';
    } else {
      iconPreview.className = 'bi-folder text-primary';
    }
  });

  const statusToggle = document.getElementById('aktifSwitch');
  const statusText = document.querySelector('.status-text');

  statusToggle.addEventListener('change', function() {
    statusText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
  });
});
</script>
@endpush
