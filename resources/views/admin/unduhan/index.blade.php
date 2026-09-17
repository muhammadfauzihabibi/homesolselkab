@extends('layouts.admin')

@section('title', 'Manajemen Dokumen Unduhan')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Manajemen Dokumen Unduhan</h1>
        <span class="badge badge-solsel fs-8">Download Center</span>
      </div>
      <p class="admin-page-subtitle">Kelola dokumen Download Center dengan Google Drive integration.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.unduhan.kategori.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Kelola Kategori">
        <i class="bi bi-folder text-primary"></i>
      </a>
      <a href="{{ route('admin.unduhan.jenis.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Kelola Jenis">
        <i class="bi bi-tags text-primary"></i>
      </a>
      <a href="{{ route('unduhan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Dokumen Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4">
    <form action="{{ route('unduhan.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-3">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari judul atau deskripsi..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-12 col-md-2">
        <select name="kategori" class="form-select border-0 py-2 fs-7 fw-semibold" id="filter-kategori">
          <option value="">-- Kategori --</option>
          @foreach($kategoris as $kat)
            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
              {{ $kat->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-12 col-md-2">
        <select name="jenis" class="form-select border-0 py-2 fs-7 fw-semibold" id="filter-jenis">
          <option value="">-- Jenis --</option>
        </select>
      </div>

      <div class="col-12 col-md-2">
        <select name="tahun" class="form-select border-0 py-2 fs-7 fw-semibold">
          <option value="">-- Tahun --</option>
          @for($year = date('Y'); $year >= 2020; $year--)
            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
          @endfor
        </select>
      </div>

      <div class="col-12 col-md-1">
        <select name="status" class="form-select border-0 py-2 fs-7 fw-semibold">
          <option value="">-- Status --</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Filter</button>
        @if(request()->hasAny(['search', 'kategori', 'jenis', 'tahun', 'status']))
          <a href="{{ route('unduhan.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Dokumen Table Card -->
  <div class="glass-card p-3">
    <!-- Table Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-2 border-bottom">
      <h6 class="fw-bold  mb-0">Daftar Dokumen Unduhan</h6>
      <span class="badge badge-solsel">{{ $unduhans->total() }} Dokumen</span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Dokumen</th>
            <th>Kategori & Jenis</th>
            <th class="text-center" style="width: 80px;">Tahun</th>
            <th class="text-center" style="width: 100px;">Download</th>
            <th class="text-center" style="width: 90px;">Status</th>
            <th class="text-end" style="width: 130px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($unduhans as $index => $unduhan)
            <tr>
              <td class="text-muted">{{ $unduhans->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-start gap-3">
                  <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger-subtle p-2 flex-shrink-0" style="width: 44px; height: 44px;">
                    <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                  </div>
                  <div class="flex-grow-1">
                    <div class="fw-bold ">{{ $unduhan->judul }}</div>
                    @if($unduhan->deskripsi)
                      <div class="text-muted fs-8">{{ Str::limit($unduhan->deskripsi, 80) }}</div>
                    @endif
                    @if($unduhan->google_drive_url)
                      <small class="text-success fs-8">
                        <i class="bi bi-cloud-check me-1"></i>Google Drive
                      </small>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                @if($unduhan->kategoriUnduhan)
                  <div class="d-flex align-items-center gap-1 mb-1">
                    @if($unduhan->kategoriUnduhan->icon)
                      <i class="{{ $unduhan->kategoriUnduhan->icon }} text-primary"></i>
                    @endif
                    <span class="fw-bold  fs-7">{{ $unduhan->kategoriUnduhan->nama }}</span>
                  </div>
                  @if($unduhan->jenisUnduhan)
                    <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $unduhan->jenisUnduhan->nama }}</span>
                  @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-center">
                @if($unduhan->tahun)
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $unduhan->tahun }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-center">
                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ number_format($unduhan->jumlah_unduhan ?? 0) }}</span>
              </td>
              <td class="text-center">
                @if($unduhan->aktif)
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
                  @if($unduhan->google_drive_url)
                    <a href="{{ $unduhan->google_drive_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Lihat di Google Drive">
                      <i class="bi bi-cloud-arrow-up text-success"></i>
                    </a>
                  @endif
                  <a href="{{ route('unduhan.edit', $unduhan) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Dokumen">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Dokumen" onclick="confirmDelete('{{ $unduhan->id }}', '{{ $unduhan->judul }}')">
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
                  <span>Belum ada dokumen unduhan ditemukan.</span>
                  <a href="{{ route('unduhan.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fs-7 mt-1">
                    <i class="bi bi-plus-circle-fill me-1"></i> Tambah Dokumen Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($unduhans->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $unduhans->firstItem() }} - {{ $unduhans->lastItem() }} dari {{ $unduhans->total() }} dokumen</small>
        <div>{{ $unduhans->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>

  <!-- Delete Form -->
  <form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>

@endsection

@push('scripts')
<script>
document.getElementById('filter-kategori').addEventListener('change', function() {
  const kategoriId = this.value;
  const jenisSelect = document.getElementById('filter-jenis');

  jenisSelect.innerHTML = '<option value="">-- Jenis --</option>';

  if (kategoriId) {
    fetch(`{{ route('admin.unduhan.jenis.by-kategori') }}?kategori_id=${kategoriId}`)
      .then(response => response.json())
      .then(data => {
        data.forEach(jenis => {
          const option = document.createElement('option');
          option.value = jenis.id;
          option.textContent = jenis.nama;
          if ('{{ request("jenis") }}' == jenis.id) {
            option.selected = true;
          }
          jenisSelect.appendChild(option);
        });
      })
      .catch(error => console.error('Error:', error));
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const kategoriSelect = document.getElementById('filter-kategori');
  if (kategoriSelect.value) {
    kategoriSelect.dispatchEvent(new Event('change'));
  }
});

function confirmDelete(id, title) {
  Swal.fire({
    title: 'Konfirmasi Hapus',
    html: `Apakah Anda yakin ingin menghapus dokumen <strong>"${title}"</strong>?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>`,
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
      form.action = `{{ route('unduhan.index') }}/${id}`;
      form.submit();
    }
  });
}
</script>
@endpush
