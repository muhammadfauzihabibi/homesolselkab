@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="fw-bold text-main mb-1" style="font-size:1.5rem;">Log Aktivitas</h1>
      <p class="text-muted-custom mb-0 fs-7">Pantau aktivitas seluruh pengguna sistem.</p>
    </div>
    @if($activities->total() > 0)
    <div>
      <button type="button" class="btn btn-danger d-flex align-items-center gap-2" 
              onclick="confirmDeleteAll()" 
              style="border-radius: 999px; padding: 10px 24px;">
        <i class="bi bi-trash"></i> Hapus Semua Log
      </button>
    </div>
    @endif
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('activity-logs.index') }}" method="GET" id="filterForm" class="row g-3 align-items-center">
      <div class="col-12 col-md-3">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted);">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control" placeholder="Cari nama, event..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2">
        <select name="module" class="form-select">
          <option value="">-- Semua Modul --</option>
          @foreach($modules as $module)
            <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
              {{ ucfirst($module) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-2">
        <select name="event" class="form-select">
          <option value="">-- Semua Event --</option>
          @foreach($events as $event)
            <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
              {{ ucfirst($event) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-2">
        <input type="date" name="date_from" class="form-control" placeholder="Dari Tanggal" value="{{ request('date_from') }}">
      </div>
      <div class="col-12 col-md-2">
        <input type="date" name="date_to" class="form-control" placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
      </div>
      <div class="col-12 col-md-1 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request()->hasAny(['search', 'module', 'event', 'date_from', 'date_to']))
          <a href="{{ route('activity-logs.index') }}" class="btn btn-glass-icon d-flex align-items-center justify-content-center flex-shrink-0" title="Reset Filter">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Activity Logs Data Table Card -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0" style="width: 50px;">#</th>
            <th class="border-0">Waktu</th>
            <th class="border-0">User</th>
            <th class="border-0">Aktivitas</th>
            <th class="border-0">Modul</th>
            <th class="border-0 text-center">Info</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($activities as $key => $log)
            <tr>
              <td class="text-muted-custom">{{ $activities->firstItem() + $key }}</td>
              <td class="text-muted-custom">
                {{ $log->created_at->format('d M Y') }} <br>
                <small>{{ $log->created_at->format('H:i:s') }}</small>
              </td>
              <td>
                <div class="fw-bold text-main">{{ $log->causer->name ?? 'System' }}</div>
                @if(isset($log->properties['ip']))
                  <small class="text-muted-custom"><i class="bi bi-globe2 me-1"></i>{{ $log->properties['ip'] }}</small>
                @endif
              </td>
              <td>
                @php
                  $badgeVariants = [
                    'created' => ['bg' => 'rgba(16, 185, 129, 0.15)', 'text' => '#10b981', 'icon' => 'bi-plus-circle'],
                    'updated' => ['bg' => 'rgba(255, 193, 7, 0.15)', 'text' => '#ffc107', 'icon' => 'bi-pencil-square'],
                    'deleted' => ['bg' => 'rgba(220, 53, 69, 0.15)', 'text' => '#dc3545', 'icon' => 'bi-trash'],
                    'login'   => ['bg' => 'rgba(13, 202, 240, 0.15)', 'text' => '#0dcaf0', 'icon' => 'bi-box-arrow-in-right'],
                    'logout'  => ['bg' => 'rgba(108, 117, 125, 0.15)', 'text' => '#6c757d', 'icon' => 'bi-box-arrow-left'],
                  ];
                  $variant = $badgeVariants[$log->description] ?? ['bg' => 'rgba(0, 82, 255, 0.15)', 'text' => '#0052ff', 'icon' => 'bi-info-circle'];
                @endphp
                <span class="badge glass-badge text-uppercase" style="background: {{ $variant['bg'] }}; color: {{ $variant['text'] }};">
                  <i class="{{ $variant['icon'] }} me-1"></i>{{ $log->description }}
                </span>
              </td>
              <td>
                <span class="badge bg-secondary-subtle text-secondary-emphasis">
                  {{ $log->log_name }}
                </span>
                @if($log->subject_id)
                  <small class="text-muted-custom">#{{ $log->subject_id }}</small>
                @endif
              </td>
              <td class="text-center">
                @if(count($log->properties) > 0 && !in_array($log->description, ['login', 'logout']))
                  <button type="button" class="btn btn-sm btn-glass-icon" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                    <i class="bi bi-file-earmark-code text-primary"></i>
                  </button>
                @else
                  <span class="text-muted-custom">-</span>
                @endif
              </td>
              <td class="text-end">
                <form action="{{ route('activity-logs.destroy', $log->id) }}" method="POST" class="delete-form d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-glass-icon d-flex align-items-center justify-content-center" title="Hapus Log">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted-custom">
                <i class="bi bi-clock-history fs-1 d-block mb-2 opacity-50"></i>
                Belum ada rekaman log aktivitas.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($activities->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari {{ $activities->total() }} log</small>
        <div>{{ $activities->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>

  <!-- Hidden Form untuk Delete All -->
  <form id="deleteAllForm" action="{{ route('activity-logs.destroy-all') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="module" value="{{ request('module') }}">
    <input type="hidden" name="event" value="{{ request('event') }}">
    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
  </form>
@endsection

@push('modals')
  @foreach($activities as $log)
    @if(count($log->properties) > 0 && !in_array($log->description, ['login', 'logout']))
      <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content" style="background: var(--card-bg); border: none; border-radius: 28px;">
            <div class="modal-header" style="border-bottom: 1px solid var(--card-sub-bg);">
              <h5 class="modal-title text-main fw-bold">
                <i class="bi bi-file-earmark-code me-2"></i>Detail Log #{{ $log->id }}
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
              <div style="background: #1e1e2d; border-radius: 0 0 28px 28px; overflow-x: auto; max-height: 500px;">
                <pre class="m-0 p-4"><code style="font-family: 'Fira Code', 'Courier New', monospace; font-size: 13px; color: #a3b3ce; word-break: break-all; white-space: pre-wrap;">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endpush

@push('scripts')
<script>
function confirmDeleteAll() {
  Swal.fire({
    title: "Hapus Semua Log Aktivitas?",
    text: "Tindakan ini akan menghapus semua log aktivitas{{ request()->hasAny(['module', 'event', 'date_from', 'date_to']) ? ' sesuai filter yang aktif' : '' }}. Data yang sudah dihapus tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Ya, Hapus Semua!",
    cancelButtonText: "Batal"
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('deleteAllForm').submit();
    }
  });
}
</script>
@endpush
