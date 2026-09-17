@extends('layouts.admin')

@section('title', 'Kelola Kategori Berita')

@section('content')
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Kelola Kategori Berita</h1>
        <span class="badge badge-solsel fs-8">Kategori Berita</span>
      </div>
      <p class="admin-page-subtitle">Kelola kategori untuk mengelompokkan berita di portal publik.</p>
    </div>
    <div>
      <a href="{{ route('admin.berita.kategori.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kategori Baru
      </a>
    </div>
  </div>

  <div class="glass-card p-3 mb-4">
    <form action="{{ route('admin.berita.kategori.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-9">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" placeholder="Cari nama atau deskripsi kategori..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-7">Cari</button>
        @if(request('search'))
          <a href="{{ route('admin.berita.kategori.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Pencarian">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <div class="glass-card p-3">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-2 border-bottom">
      <h6 class="fw-bold mb-0">Daftar Kategori Berita</h6>
      <span class="badge badge-solsel">{{ $kategoris->total() }} Kategori</span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Kategori</th>
            <th class="text-center" style="width: 90px;">Berita</th>
            <th class="text-center" style="width: 80px;">Urutan</th>
            <th class="text-center" style="width: 90px;">Status</th>
            <th class="text-end" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold">
          @forelse($kategoris as $index => $kategori)
            <tr>
              <td class="text-muted">{{ $kategoris->firstItem() + $index }}</td>
              <td>
                <span class="fw-bold">{{ $kategori->nama }}</span>
              </td>
              <td class="text-center">
                <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $kategori->beritas_count }}</span>
              </td>
              <td class="text-center">
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ $kategori->urutan }}</span>
              </td>
              <td class="text-center">
                @if($kategori->aktif)
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
                  <a href="{{ route('admin.berita.kategori.edit', $kategori) }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Edit Kategori">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <button type="button" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Kategori" onclick="confirmDelete('{{ $kategori->id }}', '{{ $kategori->nama }}')">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-5 text-center text-muted">
                <div class="d-flex flex-column align-items-center gap-2">
                  <i class="bi bi-inbox fs-1 opacity-50"></i>
                  <span>Belum ada kategori berita ditemukan.</span>
                  <a href="{{ route('admin.berita.kategori.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fs-7 mt-1">
                    <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kategori Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($kategoris->hasPages())
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3 gap-2" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted">Menampilkan {{ $kategoris->firstItem() }} - {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} kategori</small>
        <div>{{ $kategoris->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>

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
    html: `Apakah Anda yakin ingin menghapus kategori <strong>"${name}"</strong>?<br><small class="text-muted">Pastikan kategori tidak memiliki berita yang terhubung.</small>`,
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
      form.action = `{{ route('admin.berita.kategori.index') }}/${id}`;
      form.submit();
    }
  });
}
</script>
@endpush
