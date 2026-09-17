@extends('layouts.admin')

@section('title', 'Tambah Kategori Unduhan')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Kategori Unduhan</h1>
      <p class="admin-page-subtitle mb-0">
        Buat kategori baru untuk mengorganisir dokumen unduhan.
        <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold ms-2 d-inline-flex align-items-center gap-1 fs-7" data-bs-toggle="modal" data-bs-target="#petunjukModal" data-bs-backdrop="false">
          <i class="bi bi-info-circle"></i> Lihat Petunjuk
        </a>
      </p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="glass-card p-4">
    <form action="{{ route('admin.unduhan.kategori.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <!-- Nama Kategori -->
        <div class="col-12">
          <label for="nama" class="form-label fw-bold ">Nama Kategori <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Anggaran, Laporan, Regulasi..." required autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Nama kategori akan otomatis dibuatkan slug URL-nya</small>
        </div>

        <!-- Deskripsi -->
        <div class="col-12">
          <label for="deskripsi" class="form-label fw-bold ">Deskripsi</label>
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan kategori ini secara singkat...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Icon -->
        <div class="col-12">
          <label for="icon" class="form-label fw-bold ">Icon Bootstrap</label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3">
              <i id="icon-preview" class="{{ old('icon', 'bi-folder') }} text-primary"></i>
            </span>
            <input type="text" class="form-control border-0 py-2 fs-7 @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon') }}" placeholder="bi-folder, bi-file-text, bi-cash-coin...">
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
          <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0">
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
              <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                <span class="status-text text-primary">{{ old('aktif', true) ? 'Aktif' : 'Nonaktif' }}</span>
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
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Kategori</button>
      </div>
    </form>
  </div>
@endsection

@push('modals')
<div class="modal fade" id="petunjukModal" tabindex="-1" aria-labelledby="petunjukModalLabel" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--card-bg, #1a1e29); border: 1px solid var(--card-border, rgba(255,255,255,0.08)); border-radius: 24px;">
      <div class="modal-header pb-3" style="border-bottom: 1px solid var(--card-sub-bg, rgba(255,255,255,0.08));">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="petunjukModalLabel">
          <i class="bi bi-info-circle text-primary fs-5"></i>
          Informasi & Contoh Kategori
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-4">
          <h6 class="fs-7 fw-bold mb-2">Contoh Kategori Unduhan:</h6>
          <div class="d-flex flex-column gap-2">
            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <div class="rounded-circle p-2 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-cash-coin fs-6"></i>
              </div>
              <div>
                <div class="fw-bold fs-7">Anggaran</div>
                <small class="text-muted fs-8">Dokumen APBD, DPA, RKA, Laporan Keuangan.</small>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <div class="rounded-circle p-2 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-file-earmark-text fs-6"></i>
              </div>
              <div>
                <div class="fw-bold fs-7">Laporan</div>
                <small class="text-muted fs-8">LKPJ, LPPD, LAKIP, Evaluasi Kinerja.</small>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <div class="rounded-circle p-2 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-clipboard-data fs-6"></i>
              </div>
              <div>
                <div class="fw-bold fs-7">Perencanaan</div>
                <small class="text-muted fs-8">RPJMD, Renstra, RKPD, RPJPD daerah.</small>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <div class="rounded-circle p-2 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-journal-text fs-6"></i>
              </div>
              <div>
                <div class="fw-bold fs-7">Regulasi</div>
                <small class="text-muted fs-8">Peraturan Daerah (Perda), Perbup, SK, Edaran.</small>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <div class="rounded-circle p-2 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-bar-chart fs-6"></i>
              </div>
              <div>
                <div class="fw-bold fs-7">Statistik</div>
                <small class="text-muted fs-8">Data statistik sektoral dan data terbuka Solok Selatan.</small>
              </div>
            </div>
          </div>
        </div>

        <div class="p-3 rounded-3" style="background: rgba(13, 202, 240, 0.08); border-left: 4px solid #0dcaf0;">
          <h6 class="fs-7 fw-bold mb-1 text-info d-flex align-items-center gap-2">
            <i class="bi bi-lightbulb"></i> Tips Pengelolaan:
          </h6>
          <ul class="list-unstyled mb-0 fs-8 text-muted">
            <li class="mb-1">• Gunakan nama yang jelas dan mudah dipahami publik.</li>
            <li class="mb-1">• Pilih icon Bootstrap yang representatif dengan isi kategori.</li>
            <li class="mb-0">• Atur nomor urut untuk menentukan prioritas tampilan di website.</li>
          </ul>
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
