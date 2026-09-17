@extends('layouts.admin')

@section('title', 'Edit Jenis Dokumen')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Edit Jenis Dokumen</h1>
      <p class="admin-page-subtitle">Perbarui informasi jenis "{{ $jenis->nama }}" dari kategori "{{ $jenis->kategoriUnduhan->nama }}".</p>
    </div>
  </div>

  <!-- Form Section -->
  <div class="row g-4">
    <div class="col-lg-8">
      <form action="{{ route('admin.unduhan.jenis.update', $jenis) }}" method="POST" class="glass-card p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Kategori Selection -->
          <div class="col-12">
            <label for="kategori_unduhan_id" class="form-label fw-bold ">Kategori <span class="text-danger">*</span></label>
            <select class="form-select @error('kategori_unduhan_id') is-invalid @enderror" id="kategori_unduhan_id" name="kategori_unduhan_id" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_unduhan_id', $jenis->kategori_unduhan_id) == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->nama }}
                </option>
              @endforeach
            </select>
            @error('kategori_unduhan_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">Ubah kategori akan memindahkan jenis ini ke kategori lain</small>
          </div>

          <!-- Nama Jenis -->
          <div class="col-12">
            <label for="nama" class="form-label fw-bold ">Nama Jenis Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $jenis->nama) }}" placeholder="Contoh: SSH, HSPK, IKPD, Perda..." required autofocus>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted mt-1 d-block fs-8">Slug URL: <code>{{ $jenis->slug }}</code></small>
          </div>

          <!-- Deskripsi -->
          <div class="col-12">
            <label for="deskripsi" class="form-label fw-bold ">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan jenis dokumen ini secara singkat...">{{ old('deskripsi', $jenis->deskripsi) }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Urutan Tampil -->
          <div class="col-md-6">
            <label for="urutan" class="form-label fw-bold ">Urutan Tampil</label>
            <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', $jenis->urutan) }}" min="0" placeholder="0">
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
                <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $jenis->aktif) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold  fs-7 ms-2" for="aktifSwitch">
                  <span class="status-text text-primary">{{ old('aktif', $jenis->aktif) ? 'Aktif' : 'Nonaktif' }}</span>
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
          <button type="submit" class="btn btn-primary px-4 py-2 fs-7">Perbarui Jenis Dokumen</button>
        </div>
      </form>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-4">
      <div class="glass-card p-4 mb-3">
        <h6 class="fw-bold  mb-3 pb-2 border-bottom">
          <i class="bi bi-bar-chart-line me-2 text-primary"></i>Statistik Jenis Dokumen
        </h6>

        <div class="text-center mb-3">
          <div class="p-3 rounded-4" style="background: var(--card-sub-bg);">
            <div class="fs-2 fw-bold text-success">{{ $jenis->unduhans()->count() }}</div>
            <div class="fs-8 text-muted">Total Dokumen Terkait</div>
          </div>
        </div>

        <div class="border-top pt-3 fs-8 text-muted">
          <div class="d-flex align-items-center gap-2 mb-2">
            @if($jenis->kategoriUnduhan->icon)
              <i class="{{ $jenis->kategoriUnduhan->icon }} text-primary"></i>
            @endif
            <span class="fw-bold  fs-7">{{ $jenis->kategoriUnduhan->nama }}</span>
          </div>

          <div class="mb-1">
            <i class="bi bi-calendar3 me-1"></i> Dibuat: {{ $jenis->created_at->format('d M Y, H:i') }}
          </div>
          @if($jenis->updated_at != $jenis->created_at)
            <div>
              <i class="bi bi-pencil me-1"></i> Diperbarui: {{ $jenis->updated_at->format('d M Y, H:i') }}
            </div>
          @endif
        </div>
      </div>

      <div class="glass-card p-4 mb-3">
        <h6 class="fw-bold  mb-3 pb-2 border-bottom">
          <i class="bi bi-list-check me-2 text-primary"></i>Jenis Lain dalam Kategori
        </h6>

        @if($jenis->kategoriUnduhan->jenisUnduhans->count() > 1)
          <div class="list-group list-group-flush fs-8">
            @foreach($jenis->kategoriUnduhan->jenisUnduhans->where('id', '!=', $jenis->id)->take(5) as $jenisLain)
              <div class="list-group-item px-0 py-2 border-0 d-flex justify-content-between align-items-center" style="background: transparent;">
                <span class=" fw-semibold">{{ $jenisLain->nama }}</span>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-0.5">{{ $jenisLain->unduhans_count ?? 0 }}</span>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-muted fs-8 mb-0">Belum ada jenis lain dalam kategori ini.</p>
        @endif
      </div>

      <div class="glass-card p-4">
        <h6 class="fw-bold  mb-3 pb-2 border-bottom">
          <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Peringatan
        </h6>

        <div class="alert alert-warning border-0 rounded-3 mb-0 fs-8" style="background: rgba(255, 193, 7, 0.1); color: #856404;">
          <strong>Perhatian:</strong><br>
          Mengubah kategori akan memindahkan semua dokumen dalam jenis ini ke kategori baru.
        </div>
      </div>
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
