@extends('layouts.admin')

@section('title', 'Edit Agenda Kegiatan')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Agenda Kegiatan</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui detail judul, deskripsi, atau jadwal pelaksanaan agenda.</p>
    </div>
  </div>

  <!-- Form Card (Full Width Content Area) -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('agenda.update', ['agenda' => $agenda->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Judul Agenda -->
      <div class="mb-4">
        <label for="title" class="form-label fw-bold text-main">Judul Agenda <span class="text-danger">*</span></label>
        <input type="text"
               name="title"
               id="title"
               class="form-control border-0 py-2.5 px-3 fs-7 @error('title') is-invalid @enderror"
               style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
               placeholder="Contoh: Rapat Koordinasi Pimpinan Daerah Triwulan III"
               value="{{ old('title', $agenda->title) }}"
               required
               autofocus>
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label for="description" class="form-label fw-bold text-main">Deskripsi Kegiatan</label>
        <textarea name="description"
                  id="description"
                  rows="3"
                  class="form-control border-0 py-2.5 px-3 fs-7 @error('description') is-invalid @enderror"
                  style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 16px;"
                  placeholder="Tuliskan detail singkat tentang agenda ini (opsional)...">{{ old('description', $agenda->description) }}</textarea>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Tanggal Mulai & Selesai -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label for="start_date" class="form-label fw-bold text-main">Tanggal Mulai <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-calendar3"></i>
            </span>
            <input type="date"
                   name="start_date"
                   id="start_date"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('start_date') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                   value="{{ old('start_date', $agenda->start_date->format('Y-m-d')) }}"
                   required>
            @error('start_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <label for="end_date" class="form-label fw-bold text-main">Tanggal Selesai <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
              <i class="bi bi-calendar3-range"></i>
            </span>
            <input type="date"
                   name="end_date"
                   id="end_date"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('end_date') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;"
                   value="{{ old('end_date', $agenda->end_date->format('Y-m-d')) }}"
                   required>
            @error('end_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <small class="text-muted-custom mt-1 d-block fs-8">Harus sama dengan atau setelah tanggal mulai.</small>
        </div>
      </div>

      <!-- Status Aktif Switch -->
      <div class="p-3 rounded-4 mb-4" style="background: var(--card-sub-bg);">
        <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
          <input class="form-check-input ms-0" type="checkbox" name="aktif" value="1" id="aktifSwitch" style="width: 2.8em; height: 1.5em;" {{ old('aktif', $agenda->aktif) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktifSwitch">
            Publikasikan Agenda Ini
          </label>
        </div>
        <small class="text-muted-custom d-block ms-5 mt-1 fs-8">Jika diaktifkan, agenda akan tampil pada website publik Pemda Solok Selatan.</small>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-glass-pill px-4 py-2 fs-7">Batal</a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">Simpan Perubahan</button>
      </div>

    </form>
  </div>

  <script>
    const startDateInput = document.getElementById('start_date');
    const endDateInput   = document.getElementById('end_date');

    startDateInput.addEventListener('change', function() {
      endDateInput.min = this.value;
      if (endDateInput.value && endDateInput.value < this.value) {
        endDateInput.value = this.value;
      }
    });
  </script>
@endsection