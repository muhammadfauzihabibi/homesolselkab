@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
  <!-- Header Page Title & Action Controls -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Log Aktivitas</h1>
      <p class="text-muted-custom mb-0 fs-6">Pantau aktivitas seluruh pengguna sistem.</p>
    </div>
  </div>

  <!-- Filter & Search Section -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('activity-logs.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-12 col-md-3">
        <div class="input-group">
          <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 999px; border-bottom-left-radius: 999px;">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" name="search" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 999px; border-bottom-right-radius: 999px;" placeholder="Cari nama, event..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-2">
        <select name="event" class="form-select border-0 py-2 fs-7 fw-semibold" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;">
          <option value="">-- Semua Event --</option>
          <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
          <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
          <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
          <option value="login"   {{ request('event') == 'login'   ? 'selected' : '' }}>Login</option>
          <option value="logout"  {{ request('event') == 'logout'  ? 'selected' : '' }}>Logout</option>
        </select>
      </div>
      <div class="col-12 col-md-2">
        <input type="date" name="start_date" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" value="{{ request('start_date') }}">
      </div>
      <div class="col-12 col-md-2">
        <input type="date" name="end_date" class="form-control border-0 py-2 fs-7" style="background: var(--card-sub-bg); color: var(--text-dark); border-radius: 999px;" value="{{ request('end_date') }}">
      </div>
      <div class="col-12 col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
        @if(request()->anyFilled(['search', 'event', 'start_date', 'end_date']))
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
            <th class="border-0">Modul / Item</th>
            <th class="border-0 text-center">Info Ekstra</th>
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
                  $badgeColor = match($log->event) {
                    'created' => 'rgba(16, 185, 129, 0.15)',
                    'updated' => 'rgba(255, 193, 7, 0.15)',
                    'deleted' => 'rgba(220, 53, 69, 0.15)',
                    'login'   => 'rgba(13, 202, 240, 0.15)',
                    'logout'  => 'rgba(108, 117, 125, 0.15)',
                    default   => 'rgba(0, 82, 255, 0.15)'
                  };
                  $textColor = match($log->event) {
                    'created' => '#10b981',
                    'updated' => '#ffc107',
                    'deleted' => '#dc3545',
                    'login'   => '#0dcaf0',
                    'logout'  => '#6c757d',
                    default   => '#0052ff'
                  };
                @endphp
                <span class="badge glass-badge text-uppercase" style="background: {{ $badgeColor }}; color: {{ $textColor }};">
                  {{ $log->event }}
                </span>
              </td>
              <td class="text-muted-custom">
                {{ class_basename($log->subject_type) ?? '-' }}
                @if($log->subject_id)
                  <span class="badge bg-secondary ms-1">#{{ $log->subject_id }}</span>
                @endif
              </td>
              <td class="text-center">
                @if(count($log->properties) > 0 && !($log->event === 'login' || $log->event === 'logout'))
                  <button type="button" class="btn btn-sm btn-glass-icon" title="Lihat Detail Properti" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                    <i class="bi bi-file-earmark-code text-primary"></i>
                  </button>
                @else
                  <span class="text-muted-custom">-</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted-custom">
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
@endsection

@push('modals')
  <!-- Modals rendered outside of table-responsive and main-wrapper to prevent backdrop and z-index issues -->
  @foreach($activities as $log)
    @if(count($log->properties) > 0 && !($log->event === 'login' || $log->event === 'logout'))
      <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content glass-card border-0">
            <div class="modal-header border-bottom border-secondary">
              <h5 class="modal-title text-main fw-bold">Detail Perubahan Data (ID: {{ $log->id }})</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start p-0">
              <div style="background: #1e1e2d; border-radius: 0 0 0.5rem 0.5rem; border-top: 1px solid var(--card-border); overflow-x: auto; max-height: 500px;">
                <pre class="m-0 p-4"><code style="font-family: 'Fira Code', 'Courier New', Courier, monospace; font-size: 13px; color: #a3b3ce; word-break: break-all; white-space: pre-wrap;">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endpush
