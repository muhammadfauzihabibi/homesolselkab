@extends('layouts.admin')

@section('title', 'Kelola Jenis Dokumen')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Kelola Jenis Dokumen</h1>
        <span class="badge badge-solsel fs-8">Jenis Unduhan</span>
      </div>
      <p class="admin-page-subtitle">Kelola jenis dokumen dalam setiap kategori unduhan.</p>
    </div>
    <div>
      <a href="{{ route('admin.unduhan.jenis.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Jenis Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('admin.unduhan.jenis.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-5">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama atau deskripsi jenis..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="kategori" class="form-select border-0 py-2 fs-7 fw-semibold" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          @foreach($kategoris as $kat)
            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
              {{ $kat->nama }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request('search') || request('kategori'))
          <a href="{{ route('admin.unduhan.jenis.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Jenis Dokumen Table Card -->
  <div class="glass-card p-3">
    <!-- Table Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-2 border-bottom">
      <h6 class="fw-bold  mb-0">Daftar Jenis Dokumen</h6>
      <span class="badge badge-solsel">{{ $jenises->total() }} Jenis</span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Jenis Dokumen</th>
            <th>Kategori</th>
            <th class="text-center" style="width: 90px;">Dokumen</th>
            <th class="text-center" style="width: 80px;">Urutan</th>
            <th class="text-center" style="width: 90px;">Status</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($jenises as $index => $jenis)
            <tr>
              <td class="text-muted">{{ $jenises->firstItem() + $index }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span class="fw-bold ">{{ $jenis->nama }}</span>
                  @if($jenis->deskripsi)
                    <small class="text-muted fs-8">{{ Str::limit($jenis->deskripsi, 60) }}</small>
                  @endif
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  @if(optional($jenis->kategoriUnduhan)->icon)
                    <i class="{{ $jenis->kategoriUnduhan->icon }} text-primary"></i>
                  @endif
                  <span class="fw-bold  fs-7">{{ optional($jenis->kategoriUnduhan)->nama ?? '-' }}</span>
                </div>
              </td>
              <td class="text-center">
                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $jenis->unduhans_count ?? $jenis->unduhans()->count() }}</span>
              </td>
              <td class="text-center">
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $jenis->urutan }}</span>
              </td>
              <td class="text-center">
                @if($jenis->aktif)
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i>Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i>Nonaktif
                  </span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('admin.unduhan.jenis.edit', $jenis) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Jenis">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Jenis" onclick="confirmDelete('{{ $jenis->id }}', '{{ $jenis->nama }}')">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-5 text-center text-muted">
                <div class="d-flex flex-column align-items-center gap-2">
                  <i class="bi bi-inbox fs-1 opacity-50"></i>
                  <span>Belum ada jenis dokumen ditemukan.</span>
                  <a href="{{ route('admin.unduhan.jenis.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fs-7 mt-1">
                    <i class="bi bi-plus-circle-fill me-1"></i> Tambah Jenis Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($jenises->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $jenises->firstItem() }} - {{ $jenises->lastItem() }} dari {{ $jenises->total() }} jenis</small>
        <div>{{ $jenises->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>

  <!-- Quick Stats -->
  @if(isset($kategoris) && $kategoris->count() > 0)
    <div class="row mt-4">
      <div class="col-12">
        <div class="glass-card p-3">
          <h6 class="fw-bold  mb-3 pb-2 border-bottom">
            <i class="bi bi-bar-chart me-2 text-primary"></i>Statistik per Kategori
          </h6>
          <div class="row g-2">
            @foreach($kategoris as $kategori)
              <div class="col-md-4 col-lg-2">
                <div class="p-3 rounded-4 text-center" style="background: var(--card-sub-bg);">
                  @if($kategori->icon)
                    <i class="{{ $kategori->icon }} fs-4 text-primary mb-1 d-block"></i>
                  @endif
                  <div class="fw-bold  fs-7">{{ $kategori->nama }}</div>
                  <div class="fs-8 text-muted mt-1">{{ $kategori->jenisUnduhans()->count() }} jenis</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Delete Form -->
  <form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
  Swal.fire({
    title: 'Konfirmasi Hapus',
    html: `Apakah Anda yakin ingin menghapus jenis dokumen <strong>"${name}"</strong>?<br><small class="text-muted">Pastikan jenis ini tidak memiliki dokumen aktif.</small>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById('delete-form');
      form.action = `{{ route('admin.unduhan.jenis.index') }}/${id}`;
      form.submit();
    }
  });
}
</script>
@endpush
