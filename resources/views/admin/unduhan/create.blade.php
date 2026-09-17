@extends('layouts.admin')

@section('title', 'Tambah Dokumen Unduhan')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Dokumen Unduhan</h1>
      <p class="admin-page-subtitle mb-0">
        Upload dokumen dengan integrasi Google Drive ke Download Center.
        <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold ms-2 d-inline-flex align-items-center gap-1 fs-7" data-bs-toggle="modal" data-bs-target="#petunjukModal" data-bs-backdrop="false">
          <i class="bi bi-info-circle"></i> Lihat Petunjuk
        </a>
      </p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="glass-card p-4">
    <form action="{{ route('unduhan.store') }}" method="POST">
      @csrf

        <div class="row g-3">
          <!-- Kategori Selection -->
          <div class="col-md-6">
            <label for="kategori_unduhan_id" class="form-label fw-bold ">Kategori <span class="text-danger">*</span></label>
            <select class="form-select @error('kategori_unduhan_id') is-invalid @enderror" id="kategori_unduhan_id" name="kategori_unduhan_id" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_unduhan_id') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->nama }}
                </option>
              @endforeach
            </select>
            @error('kategori_unduhan_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Jenis Dokumen Selection -->
          <div class="col-md-6">
            <label for="jenis_unduhan_id" class="form-label fw-bold ">Jenis Dokumen <span class="text-danger">*</span></label>
            <select class="form-select @error('jenis_unduhan_id') is-invalid @enderror" id="jenis_unduhan_id" name="jenis_unduhan_id" required>
              <option value="">-- Pilih Jenis --</option>
            </select>
            @error('jenis_unduhan_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Judul Dokumen -->
          <div class="col-12">
            <label for="judul" class="form-label fw-bold ">Judul Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: APBD Kabupaten Solok Selatan Tahun 2025" required autofocus>
            @error('judul')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Tahun -->
          <div class="col-md-6">
            <label for="tahun" class="form-label fw-bold ">Tahun</label>
            <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') }}">
            @error('tahun')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Tanggal Publikasi -->
          <div class="col-md-6">
            <label for="tanggal_publikasi" class="form-label fw-bold ">Tanggal Publikasi</label>
            <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', date('Y-m-d')) }}">
            @error('tanggal_publikasi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Deskripsi -->
          <div class="col-12">
            <label for="deskripsi" class="form-label fw-bold ">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi dokumen...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Google Drive URL -->
          <div class="col-12">
            <label for="google_drive_url" class="form-label fw-bold ">Link Google Drive <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text border-0 ps-3">
                <i class="bi bi-cloud-arrow-up text-success"></i>
              </span>
              <input type="url" class="form-control border-0 py-2 fs-7 @error('google_drive_url') is-invalid @enderror" id="google_drive_url" name="google_drive_url" value="{{ old('google_drive_url') }}" placeholder="https://drive.google.com/file/d/..." required>
            </div>
            @error('google_drive_url')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">
              Upload file ke Google Drive terlebih dahulu, lalu salin link "Share"-nya ke sini.
            </small>
          </div>

          <!-- Status Aktif Switch -->
          <div class="col-12">
            <div class="p-3 rounded-4 mb-2" style="background: var(--card-sub-bg);">
              <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
                <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                  Status Dokumen: <span class="status-text text-primary">{{ old('aktif', true) ? 'Aktif' : 'Nonaktif' }}</span>
                </label>
              </div>
              <small class="text-muted d-block ms-5 mt-1 fs-8">Jika diaktifkan, dokumen dapat langsung diunduh publik.</small>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
          <a href="{{ route('unduhan.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Dokumen</button>
        </div>
      </form>
  </div>
@endsection

@push('modals')
<div class="modal fade" id="petunjukModal" tabindex="-1" aria-labelledby="petunjukModalLabel" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: var(--card-bg, #1a1e29); border: 1px solid var(--card-border, rgba(255,255,255,0.08)); border-radius: 24px;">
      <div class="modal-header pb-3" style="border-bottom: 1px solid var(--card-sub-bg, rgba(255,255,255,0.08));">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="petunjukModalLabel">
          <i class="bi bi-info-circle text-primary fs-5"></i>
          Petunjuk Upload Dokumen
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-4">
          <h6 class="fw-bold fs-7 mb-2 d-flex align-items-center gap-2">
            <span class="badge bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">1</span>
            Upload ke Google Drive:
          </h6>
          <div class="p-3 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <ul class="list-unstyled mb-0 fs-7 text-muted">
              <li class="mb-2 d-flex align-items-start gap-2">
                <i class="bi bi-check2 text-success mt-1"></i>
                <span>Upload file PDF dokumen resmi ke Google Drive dinas/instansi Anda.</span>
              </li>
              <li class="mb-2 d-flex align-items-start gap-2">
                <i class="bi bi-check2 text-success mt-1"></i>
                <span>Klik kanan file di Google Drive &rarr; pilih <strong>"Bagikan" / "Share"</strong> atau <strong>"Dapatkan link" / "Get link"</strong>.</span>
              </li>
              <li class="mb-2 d-flex align-items-start gap-2">
                <i class="bi bi-check2 text-success mt-1"></i>
                <span>Ubah akses umum menjadi <strong>"Siapa saja yang memiliki link" (Anyone with the link)</strong>.</span>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="bi bi-check2 text-success mt-1"></i>
                <span>Salin link dan tempelkan pada kolom input <strong>Link Google Drive</strong> di form.</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="mb-4">
          <h6 class="fw-bold fs-7 mb-2 d-flex align-items-center gap-2">
            <span class="badge bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">2</span>
            Format Tautan yang Didukung:
          </h6>
          <div class="p-3 rounded-3 font-monospace fs-7 text-break" style="background: var(--card-sub-bg, rgba(255,255,255,0.03)); border: 1px dashed var(--card-border, rgba(255,255,255,0.15));">
            https://drive.google.com/file/d/<span class="text-primary fw-bold">FILE_ID</span>/view?usp=sharing
          </div>
          <small class="text-muted fs-8 d-block mt-1">Sistem akan secara otomatis memproses link tersebut agar publik dapat mengunduh langsung.</small>
        </div>

        <div class="p-3 rounded-3" style="background: rgba(13, 202, 240, 0.08); border-left: 4px solid #0dcaf0;">
          <h6 class="fw-bold fs-7 mb-1 text-info d-flex align-items-center gap-2">
            <i class="bi bi-shield-check"></i> Keamanan Server & Performa
          </h6>
          <p class="fs-8 mb-0 text-muted">
            File disimpan langsung di Google Drive Pemda. Hemat bandwidth server lokal dan unduhan publik lebih cepat & stabil.
          </p>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid var(--card-sub-bg, rgba(255,255,255,0.08));">
        <button type="button" class="btn btn-primary px-4 py-2 fs-7" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const kategoriSelect = document.getElementById('kategori_unduhan_id');
  const jenisSelect = document.getElementById('jenis_unduhan_id');

  kategoriSelect.addEventListener('change', function() {
    const kategoriId = this.value;

    jenisSelect.innerHTML = '<option value="">-- Pilih Jenis --</option>';

    if (kategoriId) {
      fetch(`{{ route('admin.unduhan.jenis.by-kategori') }}?kategori_id=${kategoriId}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(jenis => {
            const option = document.createElement('option');
            option.value = jenis.id;
            option.textContent = jenis.nama;
            if ('{{ old("jenis_unduhan_id") }}' == jenis.id) {
              option.selected = true;
            }
            jenisSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Error:', error));
    }
  });

  if (kategoriSelect.value) {
    kategoriSelect.dispatchEvent(new Event('change'));
  }

  const statusToggle = document.getElementById('aktifSwitch');
  const statusText = document.querySelector('.status-text');

  statusToggle.addEventListener('change', function() {
    statusText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
  });
});
</script>
@endpush
