@extends('layouts.admin')

@section('title', 'Tambah Kategori Berita')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Kategori Berita</h1>
      <p class="admin-page-subtitle mb-0">
        Buat kategori baru untuk mengorganisir berita.
        <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold ms-2 d-inline-flex align-items-center gap-1 fs-7" data-bs-toggle="modal" data-bs-target="#petunjukModal" data-bs-backdrop="false">
          <i class="bi bi-info-circle"></i> Lihat Petunjuk
        </a>
      </p>
    </div>
  </div>

  <div class="glass-card p-4">
    <form action="{{ route('admin.berita.kategori.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label for="nama" class="form-label fw-bold ">Nama Kategori <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Pemerintahan, Pembangunan, Sosial Budaya..." required autofocus>
          @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Nama kategori akan otomatis dibuatkan slug URL-nya</small>
        </div>

        <div class="col-md-6">
          <label for="urutan" class="form-label fw-bold ">Urutan Tampil</label>
          <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0">
          @error('urutan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted mt-1 d-block fs-8">Angka lebih kecil akan ditampilkan lebih dulu</small>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-bold ">Status Kategori</label>
          <div class="p-2.5 rounded-4" style="background: var(--card-sub-bg);">
            <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
              <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold fs-7 ms-2" for="aktifSwitch">
                <span class="status-text text-primary">{{ old('aktif', true) ? 'Aktif' : 'Nonaktif' }}</span>
              </label>
            </div>
          </div>
          <small class="form-text text-muted mt-1 d-block fs-8">Kategori nonaktif tidak akan tampil di frontend</small>
        </div>
      </div>

      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('admin.berita.kategori.index') }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
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
        <h6 class="fs-7 fw-bold mb-3">Contoh Kategori Berita:</h6>
        <div class="d-flex flex-column gap-2 mb-3">
          <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <div class="rounded-circle p-2 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-building fs-6"></i>
            </div>
            <div>
              <div class="fw-bold fs-7">Pemerintahan</div>
              <small class="text-muted fs-8">Kebijakan, rapat kerja, dan kegiatan resmi kepala daerah.</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <div class="rounded-circle p-2 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-cash-coin fs-6"></i>
            </div>
            <div>
              <div class="fw-bold fs-7">Pembangunan</div>
              <small class="text-muted fs-8">Infrastruktur, proyek fasilitas publik, dan tata ruang.</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <div class="rounded-circle p-2 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-people fs-6"></i>
            </div>
            <div>
              <div class="fw-bold fs-7">Sosial Budaya</div>
              <small class="text-muted fs-8">Pendidikan, kesehatan, kebudayaan, dan kegiatan masyarakat.</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <div class="rounded-circle p-2 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-briefcase fs-6"></i>
            </div>
            <div>
              <div class="fw-bold fs-7">Ekonomi</div>
              <small class="text-muted fs-8">UMKM, pariwisata, pertanian, dan investasi daerah.</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: var(--card-sub-bg, rgba(255,255,255,0.03));">
            <div class="rounded-circle p-2 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-megaphone fs-6"></i>
            </div>
            <div>
              <div class="fw-bold fs-7">Pengumuman</div>
              <small class="text-muted fs-8">Informasi dan edaran penting untuk masyarakat luas.</small>
            </div>
          </div>
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
