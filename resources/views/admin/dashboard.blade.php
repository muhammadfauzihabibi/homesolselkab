@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#5a6e7f';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(76, 135, 186, 0.1)';

    // 1. Chart Publikasi Berita (Warna Primary Solsel)
    var optionsBerita = {
        series: [{
            name: 'Jumlah Berita',
            data: @json($beritaBulanan ?? array_fill(0, 12, 0))
        }],
        chart: {
            height: 240,
            type: 'bar',
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#4c87ba'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '38%',
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor, fontSize: '11px' } } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
            y: { formatter: function(val) { return val + ' berita'; } }
        }
    };
    new ApexCharts(document.querySelector("#beritaChart"), optionsBerita).render();

    // 2. Chart Traffic Pengunjung (Gradient Blue Accent)
    var optionsVisitor = {
        series: [{
            name: 'Pengunjung',
            data: @json($visitorData ?? [0])
        }],
        chart: {
            height: 240,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#6ba7db'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 4, strokeColors: '#6ba7db', hover: { size: 6 } },
        xaxis: {
            categories: @json($visitorLabels ?? ['Hari ini']),
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor, fontSize: '11px' } } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
            y: { formatter: function(val) { return val + ' pengunjung'; } }
        }
    };
    new ApexCharts(document.querySelector("#visitorChart"), optionsVisitor).render();
});
</script>
@endpush

@section('content')
  <!-- 1. Top Welcome Banner & Date Chip (Gaya Referensi Card Header) -->
  <div class="row g-3 mb-4 align-items-center">
    <div class="col-12 col-md">
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="admin-page-title mb-0">Dashboard Utama</h1>
        <span class="badge badge-solsel px-3 py-1 fs-8">CMS Solsel v2.0</span>
      </div>
      <p class="admin-page-subtitle">Ringkasan portal berita, statistik kunjungan, dan aktivitas Pemkab Solok Selatan.</p>
    </div>
    <div class="col-12 col-md-auto">
      <div class="glass-card px-3 py-2 d-flex align-items-center gap-2">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px; height:32px; background: rgba(76, 135, 186, 0.15);">
          <i class="bi bi-calendar-event text-primary fs-7"></i>
        </div>
        <div class="text-start">
          <small class="text-muted fs-8 d-block leading-none">Hari Ini</small>
          <span class="fw-bold fs-7">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. KPI Top Stat Cards (4 Grid Sesuai Referensi UI) -->
  <div class="row g-3 mb-4">
    <!-- Total Pengunjung -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="glass-card p-3 h-100 transition-hover">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted fs-8 fw-bold text-uppercase">Total Pengunjung</span>
          <div class="kpi-icon-wrapper" style="background: rgba(76, 135, 186, 0.12); color: var(--solsel-primary);">
            <i class="bi bi-people-fill fs-5"></i>
          </div>
        </div>
        <h2 class="fw-extrabold mb-1">{{ number_format($totalVisitors ?? 0) }}</h2>
        <small class="text-muted fs-8"><i class="bi bi-graph-up-arrow text-success me-1"></i>Akumulasi Kunjungan</small>
      </div>
    </div>

    <!-- Pengunjung Hari Ini -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="glass-card p-3 h-100 transition-hover">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted fs-8 fw-bold text-uppercase">Kunjungan Hari Ini</span>
          <div class="kpi-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
            <i class="bi bi-person-check-fill fs-5"></i>
          </div>
        </div>
        <h2 class="fw-extrabold mb-1">{{ number_format($todayVisitors ?? 0) }}</h2>
        <small class="text-muted fs-8"><i class="bi bi-clock-history me-1"></i>Update Real-time</small>
      </div>
    </div>

    <!-- Active Users Online -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="glass-card p-3 h-100 transition-hover">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted fs-8 fw-bold text-uppercase">Online Saat Ini</span>
          <div class="kpi-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
            <i class="bi bi-broadcast fs-5"></i>
          </div>
        </div>
        <h2 class="fw-extrabold mb-1">{{ number_format($onlineVisitors ?? 0) }}</h2>
        <small class="text-muted fs-8"><i class="bi bi-dot text-success fs-6"></i>Sesi 15 Menit Terakhir</small>
      </div>
    </div>

    <!-- Hero Solsel Highlight Widget -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="hero-card-solsel p-3 h-100 d-flex flex-column justify-content-between transition-hover">
        <div class="d-flex justify-content-between align-items-start">
          <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold">Aksi Cepat</span>
          <i class="bi bi-lightning-charge-fill fs-5 opacity-75"></i>
        </div>
        <div class="my-2">
          <h6 class="fw-bold text-white mb-0">Kelola Portal</h6>
          <small class="opacity-75 fs-8">Buat berita atau pengumuman baru dengan mudah.</small>
        </div>
        @can('berita')
        <a href="{{ route('berita.create') }}" class="btn btn-light btn-sm rounded-pill fw-semibold w-100">
          + Tulis Berita
        </a>
        @endcan
      </div>
    </div>
  </div>

  <!-- 3. Charts Section (2 Columns) -->
  <div class="row g-3 mb-4">
    <!-- Chart 1: Publikasi Berita -->
    <div class="col-12 col-xl-6">
      <div class="glass-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
              <i class="bi bi-bar-chart-line-fill text-primary"></i> Statistik Publikasi Berita
            </h6>
            <small class="text-muted fs-8">Jumlah berita dipublikasikan per bulan tahun {{ now()->year }}</small>
          </div>
          <span class="badge badge-solsel">Bulanan</span>
        </div>
        <div id="beritaChart"></div>
      </div>
    </div>

    <!-- Chart 2: Tren Traffic Pengunjung -->
    <div class="col-12 col-xl-6">
      <div class="glass-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
              <i class="bi bi-graph-up text-info"></i> Grafik Traffic Pengunjung
            </h6>
            <small class="text-muted fs-8">Tren kunjungan unik 30 hari terakhir</small>
          </div>
          <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-bold">Live</span>
        </div>
        <div id="visitorChart"></div>
      </div>
    </div>
  </div>

  <!-- 4. Browser & Perangkat (Gaya Sub-Card Referensi) -->
  <div class="row g-3 mb-4">
    <!-- Browser Stats -->
    <div class="col-12 col-md-6">
      <div class="glass-card p-4 h-100">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-browser-chrome text-primary fs-5"></i> Browser Pengunjung
        </h6>
        <div class="d-flex flex-column gap-2">
          @forelse($browserStats as $browser)
            <div class="glass-sub-card p-2.5 px-3 d-flex justify-content-between align-items-center">
              <span class="fs-7 fw-semibold">{{ $browser->browser }}</span>
              <span class="badge badge-solsel fs-8">{{ number_format($browser->total) }} Kunjungan</span>
            </div>
          @empty
            <div class="text-center text-muted py-3 fs-8">Belum ada data browser.</div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Device Stats -->
    <div class="col-12 col-md-6">
      <div class="glass-card p-4 h-100">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-display text-success fs-5"></i> Perangkat Digunakan
        </h6>
        <div class="d-flex flex-column gap-2">
          @forelse($deviceStats as $device)
            <div class="glass-sub-card p-2.5 px-3 d-flex justify-content-between align-items-center">
              <span class="fs-7 fw-semibold">{{ ucfirst($device->device_type) }}</span>
              <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ number_format($device->total) }} Perangkat</span>
            </div>
          @empty
            <div class="text-center text-muted py-3 fs-8">Belum ada data perangkat.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- 5. Agenda Table Section (Tampilan Kapsul Konsisten) -->
  <div class="row g-3">
    <div class="col-12">
      <div class="glass-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
              <i class="bi bi-calendar2-check text-primary"></i> Agenda Berlangsung & Akan Datang
            </h6>
            <small class="text-muted fs-8">Jadwal kegiatan penting Pemda Solok Selatan</small>
          </div>
          <a href="{{ route('agenda.index') }}" class="btn btn-glass-pill px-3 py-1 fs-8 fw-semibold">Lihat Semua</a>
        </div>

        @if(isset($agendas) && $agendas->count() > 0)
          <div class="table-responsive">
            <table class="table glass-table align-middle mb-0">
              <thead>
                <tr>
                  <th>Judul Agenda</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th class="text-end">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($agendas as $agenda)
                  <tr>
                    <td>
                      <span class="fw-bold fs-7">{{ $agenda->title }}</span>
                    </td>
                    <td><span class="fs-7 text-muted">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}</span></td>
                    <td><span class="fs-7 text-muted">{{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}</span></td>
                    <td class="text-end">
                      @if(\Carbon\Carbon::parse($agenda->start_date)->toDateString() <= $today && \Carbon\Carbon::parse($agenda->end_date)->toDateString() >= $today)
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-bold fs-8"><i class="bi bi-play-circle me-1"></i> Sedang Berlangsung</span>
                      @elseif(\Carbon\Carbon::parse($agenda->start_date)->toDateString() > $today)
                        <span class="badge badge-solsel px-3 py-1.5 fw-bold fs-8"><i class="bi bi-clock me-1"></i> Akan Datang</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-4 text-muted">
            <div class="d-inline-flex justify-content-center align-items-center rounded-circle mb-2" style="width: 52px; height: 52px; background: var(--card-sub-bg);">
              <i class="bi bi-calendar-x fs-3"></i>
            </div>
            <p class="mb-0 fs-7">Tidak ada agenda aktif atau mendatang.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
