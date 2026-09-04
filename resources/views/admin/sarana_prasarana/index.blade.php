@extends('layouts.admin')

@section('title', 'Manajemen Sarana dan Prasarana')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Manajemen Sarana & Prasarana</h1>
      <p class="text-muted-custom mb-0 fs-6">Kelola fasilitas publik, kendaraan operasional, gedung, dan sarana prasarana Solok Selatan.</p>
    </div>
    <div>
      <a href="{{ route('sarana-prasarana.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Sarana & Prasarana
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('sarana-prasarana.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-4">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama, kategori, pengelola..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-12 col-md-3">
        <select name="kecamatan" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Kecamatan --</option>
          @foreach($kecamatans as $kec)
            <option value="{{ $kec->nama }}" {{ request('kecamatan') == $kec->nama ? 'selected' : '' }}>
              {{ $kec->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-12 col-md-3">
        <select name="kondisi" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" onchange="this.form.submit()">
          <option value="">-- Semua Kondisi --</option>
          <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
          <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
          <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
        </select>
      </div>

      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('kecamatan') || request('kondisi') || request('kategori'))
          <a href="{{ route('sarana-prasarana.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Foto & Nama</th>
            <th class="border-0">Kategori / Sub</th>
            <th class="border-0">Kecamatan & Nagari</th>
            <th class="border-0 text-center">Kondisi</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0 text-end" style="width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($items as $index => $item)
            <tr>
              <td class="text-muted-custom">{{ $items->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-3 overflow-hidden flex-shrink-0" style="width: 50px; height: 50px; background: var(--card-sub-bg);">
                    @if($item->foto_utama)
                      <img src="{{ asset('storage/' . $item->foto_utama) }}" alt="{{ $item->nama }}" class="w-100 h-100 object-fit-cover">
                    @else
                      <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted-custom">
                        <i class="bi bi-building fs-4"></i>
                      </div>
                    @endif
                  </div>
                  <div>
                    <span class="fw-bold d-block text-truncate text-main" style="max-width: 250px;" title="{{ $item->nama }}">
                      {{ $item->nama }}
                    </span>
                    <small class="text-muted-custom d-block text-truncate" style="max-width: 250px;">
                      Pengelola: {{ $item->pengelola }}
                    </small>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1">
                  {{ $item->kategori }}
                </span>
                @if($item->sub_kategori)
                  <small class="text-muted-custom d-block mt-1">
                    {{ $item->sub_kategori }}
                  </small>
                @endif
              </td>
              <td>
                <div class="fw-semibold text-main">
                  <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $item->kecamatan }}
                </div>
                @if($item->nagari)
                  <small class="text-muted-custom d-block">
                    Nagari {{ $item->nagari }}
                  </small>
                @endif
              </td>
              <td class="text-center">
                @if($item->kondisi == 'Baik')
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1">
                    <i class="bi bi-check-circle me-1"></i> Baik
                  </span>
                @elseif($item->kondisi == 'Rusak Ringan')
                  <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1">
                    <i class="bi bi-exclamation-triangle me-1"></i> Rusak Ringan
                  </span>
                @else
                  <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1">
                    <i class="bi bi-x-circle me-1"></i> Rusak Berat
                  </span>
                @endif
              </td>
              <td class="text-center">
                @if($item->status_operasional == 'Aktif')
                  <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1">
                    Aktif
                  </span>
                @elseif($item->status_operasional == 'Dalam Perbaikan')
                  <span class="badge bg-warning-subtle text-dark rounded-pill px-2.5 py-1">
                    Dalam Perbaikan
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1">
                    Tidak Beroperasi
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('sarana-prasarana.show', $item->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Detail">
                    <i class="bi bi-eye text-info"></i>
                  </a>
                  <a href="{{ route('sarana-prasarana.edit', $item->id) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('sarana-prasarana.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted-custom">
                <i class="bi bi-building-x fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data Sarana & Prasarana. Klik <strong>Tambah Sarana & Prasarana</strong> untuk membuat baru.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($items->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} Data</small>
        <div>{{ $items->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
