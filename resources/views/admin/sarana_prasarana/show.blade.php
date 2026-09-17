@extends('layouts.admin')

@section('title', 'Detail Sarana & Prasarana')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">{{ $item->nama }}</h1>
        <span class="badge badge-solsel fs-8">Detail</span>
      </div>
      <p class="admin-page-subtitle">Detail informasi sarana dan prasarana publik Pemkab Solok Selatan.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('sarana-prasarana.edit', $item->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square"></i> Edit Data
      </a>
      <a href="{{ route('sarana-prasarana.index') }}" class="btn btn-glass-pill d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Gambar & Status -->
    <div class="col-lg-5">
      <div class="glass-card p-3 mb-4 text-center">
        <div class="rounded-3 overflow-hidden mb-3" style="max-height: 300px; background: var(--card-sub-bg);">
          @if($item->foto_utama)
            <img src="{{ asset('storage/' . $item->foto_utama) }}" alt="{{ $item->nama }}" class="w-100 h-100 object-fit-cover">
          @else
            <div class="py-5 text-muted">
              <i class="bi bi-building fs-1 d-block mb-2 opacity-50"></i>
              Belum ada foto utama
            </div>
          @endif
        </div>

        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
          <span class="badge badge-solsel">
            {{ $item->kategori }}
          </span>
          @if($item->sub_kategori)
            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
              {{ $item->sub_kategori }}
            </span>
          @endif
        </div>

        <div class="row g-2 text-start pt-3 border-top">
          <div class="col-6">
            <small class="text-muted d-block fs-8">Kondisi</small>
            @if($item->kondisi == 'Baik')
              <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fw-bold fs-8">Baik</span>
            @elseif($item->kondisi == 'Rusak Ringan')
              <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1 fw-bold fs-8">Rusak Ringan</span>
            @else
              <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 fw-bold fs-8">Rusak Berat</span>
            @endif
          </div>
          <div class="col-6">
            <small class="text-muted d-block fs-8">Status Operasional</small>
            @if($item->status_operasional == 'Aktif')
              <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fw-bold fs-8">Aktif</span>
            @elseif($item->status_operasional == 'Dalam Perbaikan')
              <span class="badge bg-warning-subtle  rounded-pill px-2.5 py-1 fw-bold fs-8">Dalam Perbaikan</span>
            @else
              <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fw-bold fs-8">Tidak Beroperasi</span>
            @endif
          </div>
        </div>
      </div>

      <!-- Galeri Foto -->
      @if(!empty($item->galeri_foto) && is_array($item->galeri_foto))
        <div class="glass-card p-3 mb-4">
          <h6 class="fw-bold  mb-3">Galeri Foto</h6>
          <div class="row g-2">
            @foreach($item->galeri_foto as $gPath)
              <div class="col-4">
                <div class="rounded-2 overflow-hidden border" style="height: 80px;">
                  <a href="{{ asset('storage/' . $gPath) }}" target="_blank">
                    <img src="{{ asset('storage/' . $gPath) }}" class="w-100 h-100 object-fit-cover">
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- Rincian Data -->
    <div class="col-lg-7">
      <div class="glass-card p-4">
        <h5 class="fw-bold  mb-4 pb-2 border-bottom">Rincian Sarana & Prasarana</h5>

        <dl class="row mb-0 fs-7">
          <dt class="col-sm-4 text-muted mb-2">Nama Sarana</dt>
          <dd class="col-sm-8 fw-bold  mb-2">{{ $item->nama }}</dd>

          <dt class="col-sm-4 text-muted mb-2">Alamat Lengkap</dt>
          <dd class="col-sm-8  mb-2">{{ $item->alamat_lengkap }}</dd>

          <dt class="col-sm-4 text-muted mb-2">Kecamatan & Nagari</dt>
          <dd class="col-sm-8  mb-2">
            {{ $item->kecamatan }} @if($item->nagari) (Nagari {{ $item->nagari }}) @endif
          </dd>

          <dt class="col-sm-4 text-muted mb-2">Koordinat Maps</dt>
          <dd class="col-sm-8  mb-2">
            @if($item->latitude && $item->longitude)
              <code>{{ $item->latitude }}, {{ $item->longitude }}</code>
            @else
              -
            @endif
            @if($item->google_maps_url)
              <div class="mt-1">
                <a href="{{ $item->google_maps_url }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fs-8">
                  <i class="bi bi-geo-alt me-1"></i> Buka Google Maps
                </a>
              </div>
            @endif
          </dd>

          <dt class="col-sm-4 text-muted mb-2">Instansi Pengelola</dt>
          <dd class="col-sm-8  mb-2 fw-semibold">{{ $item->pengelola }}</dd>

          <dt class="col-sm-4 text-muted mb-2">Kontak Pengelola</dt>
          <dd class="col-sm-8  mb-2">{{ $item->kontak_pengelola ?? '-' }}</dd>

          @if($item->jenis_kendaraan)
            <dt class="col-sm-4 text-muted mb-2">Jenis Kendaraan</dt>
            <dd class="col-sm-8  mb-2">{{ $item->jenis_kendaraan }}</dd>
          @endif

          @if($item->spesifikasi)
            <dt class="col-sm-4 text-muted mb-2">Spesifikasi</dt>
            <dd class="col-sm-8  mb-2" style="white-space: pre-line;">{{ $item->spesifikasi }}</dd>
          @endif

          @if($item->tarif_retribusi)
            <dt class="col-sm-4 text-muted mb-2">Tarif / Retribusi</dt>
            <dd class="col-sm-8  mb-2" style="white-space: pre-line;">{{ $item->tarif_retribusi }}</dd>
          @endif

          @if($item->rute_layanan)
            <dt class="col-sm-4 text-muted mb-2">Rute Layanan</dt>
            <dd class="col-sm-8  mb-2" style="white-space: pre-line;">{{ $item->rute_layanan }}</dd>
          @endif

          <dt class="col-sm-4 text-muted mb-2">Dibuat Pada</dt>
          <dd class="col-sm-8  mb-2">{{ $item->created_at ? $item->created_at->translatedFormat('d F Y H:i') : '-' }}</dd>
        </dl>
      </div>
    </div>
  </div>
@endsection
