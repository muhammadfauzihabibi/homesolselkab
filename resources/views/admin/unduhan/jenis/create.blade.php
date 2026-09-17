@extends('layouts.admin')

@section('title', 'Tambah Jenis Dokumen')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Jenis Dokumen</h1>
      <p class="admin-page-subtitle mb-0">
        Buat jenis dokumen baru untuk kategorisasi yang lebih spesifik.
        <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold ms-2 d-inline-flex align-items-center gap-1 fs-7" data-bs-toggle="modal" data-bs-target="#petunjukModal" data-bs-backdrop="false">
          <i class="bi bi-info-circle"></i> Lihat Petunjuk
        </a>
      </p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="glass-card p-4">
    <form action="{{ route('admin.unduhan.jenis.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <!-- Kategori Selection -->
        <div class="col-12">
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
          <small class="form-text text-muted mt-1 d-block fs-8">Pilih kategori induk untuk jenis dokumen ini</small>
        </div>

        <!-- Nama Jenis -->
        <div class="col-12">
          <label for="nama" class="form-label fw-bold ">Nama Jenis Dokumen <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: SSH, HSPK, IKPD, Perda..." required autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Nama jenis akan otomatis dibuatkan slug URL-nya</small>
        </div>

        <!-- Deskripsi -->
        <div class="col-12">
          <label for="deskripsi" class="form-label fw-bold ">Deskripsi</label>
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan jenis dokumen ini secara singkat...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Urutan Tampil -->
        <div class="col-md-6">
          <label for="urutan" class="form-label fw-bold ">Urutan Tampil</label>
          <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0">
          @error('urutan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Urutan dalam kategori (angka kecil tampil dulu)</small>
        </div>

        <!-- Status Switch -->
        <div class="col-md-6">
          <label class="form-label fw-bold ">Status Jenis</label>
          <div class="p-2.5 rounded-4" style="background: var(--card-sub-bg);">
            <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
              <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                <span class="status-text text-primary">{{ old('aktif', true) ? 'Aktif' : 'Nonaktif' }}</span>
              </label>
            </div>
          </div>
          <small class="form-text text-muted mt-1 d-block fs-8">Jenis nonaktif tidak akan tampil di frontend</small>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('admin.unduhan.jenis.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Simpan Jenis Dokumen</button>
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
          Contoh & Petunjuk Jenis Dokumen
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <h6 class="fs-7 fw-bold mb-2 text-success d-flex align-items-center gap-1.5">
                <i class="bi bi-cash-coin"></i> Anggaran:
              </h6>
              <ul class="list-unstyled mb-0 fs-8 text-muted ms-1">
                <li class="mb-1">• SSH (Standar Satuan Harga)</li>
                <li class="mb-1">• HSPK (Harga Satuan Pokok Kegiatan)</li>
                <li class="mb-1">• ASB (Analisis Standar Belanja)</li>
                <li class="mb-0">• APBD (Anggaran Pendapatan Belanja Daerah)</li>
              </ul>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <h6 class="fs-7 fw-bold mb-2 text-info d-flex align-items-center gap-1.5">
                <i class="bi bi-file-earmark-text"></i> Laporan:
              </h6>
              <ul class="list-unstyled mb-0 fs-8 text-muted ms-1">
                <li class="mb-1">• IKPD (Indeks Kinerja Pemda)</li>
                <li class="mb-1">• LKPJ (Keterangan Pertanggungjawaban)</li>
                <li class="mb-1">• LPPD (Penyelenggaraan Pemda)</li>
                <li class="mb-0">• LAKIP (Akuntabilitas Kinerja)</li>
              </ul>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
              <h6 class="fs-7 fw-bold mb-2 text-primary d-flex align-items-center gap-1.5">
                <i class="bi bi-journal-text"></i> Regulasi:
              </h6>
              <ul class="list-unstyled mb-0 fs-8 text-muted ms-1">
                <li class="mb-1">• Perda (Peraturan Daerah)</li>
                <li class="mb-1">• Perbup (Peraturan Bupati)</li>
                <li class="mb-1">• SK (Surat Keputusan)</li>
                <li class="mb-0">• SE (Surat Edaran)</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="p-3 rounded-3" style="background: rgba(13, 202, 240, 0.08); border-left: 4px solid #0dcaf0;">
          <h6 class="fs-7 fw-bold mb-1 text-info d-flex align-items-center gap-2">
            <i class="bi bi-lightbulb"></i> Tips Pengisian:
          </h6>
          <ul class="list-unstyled mb-0 fs-8 text-muted">
            <li class="mb-1">• Gunakan singkatan resmi atau nama singkat yang jelas.</li>
            <li class="mb-1">• Pastikan memilih kategori induk yang tepat sebelum menyimpan.</li>
            <li class="mb-0">• Atur nomor urut tampilan agar dokumen utama berada di urutan atas.</li>
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
  const statusToggle = document.getElementById('aktifSwitch');
  const statusText = document.querySelector('.status-text');

  statusToggle.addEventListener('change', function() {
    statusText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
  });
});
</script>
@endpush
