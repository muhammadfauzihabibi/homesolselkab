@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Deteksi Mode Gelap dari HTML Theme
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    // 1. Grafik Publikasi Berita (Column Chart)
    var optionsBerita = {
        series: [{
            name: 'Jumlah Berita',
            data: @json($beritaBulanan ?? array_fill(0, 12, 0))
        }],
        chart: {
            height: 280,
            type: 'bar',
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#0284c7'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '40%',
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            labels: { style: { colors: textColor } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor } } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
            y: { formatter: function(val) { return val + ' berita'; } }
        }
    };
    new ApexCharts(document.querySelector("#beritaChart"), optionsBerita).render();

    // 2. Grafik Tren Pengunjung (Smooth Area Chart)
    var optionsVisitor = {
        series: [{
            name: 'Pengunjung',
            data: @json($visitorData ?? [0])
        }],
        chart: {
            height: 280,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#10b981'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 4, strokeColors: '#10b981', hover: { size: 6 } },
        xaxis: {
            categories: @json($visitorLabels ?? ['Hari ini']),
            labels: { style: { colors: textColor } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor } } },
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
  <!-- 1. Header Title Bar (Tanpa Tombol Tambah Berita) -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Dashboard Utama</h1>
      <p class="text-muted-custom mb-0 fs-6">Ringkasan statistik visitor, grafik publikasi, dan seluruh modul pengelolaan data Pemkab Solok Selatan.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <div class="glass-card px-3 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-calendar3 text-primary"></i>
        <span class="fw-semibold fs-7 text-main">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
      </div>
    </div>
  </div>

  <!-- 2. GRAFIK STATISTIK DI PALING ATAS -->
  <div class="row g-4 mb-4">
    <!-- Chart 1: Publikasi Berita -->
    <div class="col-12 col-xl-6">
      <div class="glass-card p-4 h-100 shadow-sm border-0">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 class="fw-bold text-main mb-1"><i class="bi bi-bar-chart-line text-primary me-2"></i>Statistik Publikasi Berita</h5>
            <small class="text-muted-custom">Jumlah berita dipublikasikan per bulan tahun {{ now()->year }}</small>
          </div>
          <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fs-8 fw-semibold">Bulanan</span>
        </div>
        <div id="beritaChart"></div>
      </div>
    </div>

    <!-- Chart 2: Tren Traffic Pengunjung -->
    <div class="col-12 col-xl-6">
      <div class="glass-card p-4 h-100 shadow-sm border-0">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 class="fw-bold text-main mb-1"><i class="bi bi-activity text-success me-2"></i>Grafik Traffic Pengunjung</h5>
            <small class="text-muted-custom">Tren statistik kunjungan unik 30 hari terakhir</small>
          </div>
          <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-8 fw-semibold">Real-time</span>
        </div>
        <div id="visitorChart"></div>
      </div>
    </div>
  </div>

  <!-- 3. Metrik Statistik Pengunjung Website -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
      <div class="glass-card p-3 shadow-sm border-0 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted-custom fs-8 fw-bold text-uppercase">Total Pengunjung</span>
          <h3 class="fw-extrabold text-main mb-0 mt-1">{{ number_format($totalVisitors ?? 0) }}</h3>
        </div>
        <div class="metric-circle-icon bg-primary-subtle text-primary">
          <i class="bi bi-people fs-4"></i>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="glass-card p-3 shadow-sm border-0 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted-custom fs-8 fw-bold text-uppercase">Pengunjung Hari Ini</span>
          <h3 class="fw-extrabold text-main mb-0 mt-1">{{ number_format($todayVisitors ?? 0) }}</h3>
        </div>
        <div class="metric-circle-icon bg-success-subtle text-success">
          <i class="bi bi-person-check fs-4"></i>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="glass-card p-3 shadow-sm border-0 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted-custom fs-8 fw-bold text-uppercase">Online Saat Ini (15 mnt)</span>
          <h3 class="fw-extrabold text-main mb-0 mt-1">{{ number_format($onlineVisitors ?? 0) }}</h3>
        </div>
        <div class="metric-circle-icon bg-warning-subtle text-warning">
          <i class="bi bi-broadcast fs-4"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Browser & Device Distribution -->
  <div class="row g-4 mb-4">
    <!-- Browser Breakdown -->
    <div class="col-12 col-md-6">
      <div class="glass-card p-4 shadow-sm border-0 h-100">
        <h6 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-browser-chrome text-primary fs-5"></i> Browser Pengunjung
        </h6>
        <div class="d-flex flex-column gap-2">
          @forelse($browserStats as $browser)
            <div class="glass-sub-card p-2.5 px-3 d-flex justify-content-between align-items-center">
              <span class="fs-7 fw-semibold text-main">{{ $browser->browser }}</span>
              <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ number_format($browser->total) }} Kunjungan</span>
            </div>
          @empty
            <div class="text-center text-muted-custom py-3 fs-8">Belum ada data browser.</div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Device Breakdown -->
    <div class="col-12 col-md-6">
      <div class="glass-card p-4 shadow-sm border-0 h-100">
        <h6 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-display text-success fs-5"></i> Perangkat Digunakan
        </h6>
        <div class="d-flex flex-column gap-2">
          @forelse($deviceStats as $device)
            <div class="glass-sub-card p-2.5 px-3 d-flex justify-content-between align-items-center">
              <span class="fs-7 fw-semibold text-main">{{ ucfirst($device->device_type) }}</span>
              <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-8 fw-bold">{{ number_format($device->total) }} Devices</span>
            </div>
          @empty
            <div class="text-center text-muted-custom py-3 fs-8">Belum ada data perangkat.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- 6. Agenda Table Section -->
  <div class="row g-4 mb-4">
    <div class="col-12">
      <div class="glass-card p-4 shadow-sm border-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="fw-bold text-main mb-0"><i class="bi bi-calendar2-check text-primary me-2"></i> Agenda Berlangsung & Akan Datang</h5>
          <a href="{{ route('agenda.index') }}" class="btn btn-glass-pill px-3 py-1.5 fs-8 fw-semibold">Lihat Semua Agenda</a>
        </div>
        
        @if(isset($agendas) && $agendas->count() > 0)
          <div class="table-responsive">
            <table class="table glass-table align-middle mb-0">
              <thead>
                <tr>
                  <th class="text-secondary fw-semibold">Judul Agenda</th>
                  <th class="text-secondary fw-semibold">Tanggal Mulai</th>
                  <th class="text-secondary fw-semibold">Tanggal Selesai</th>
                  <th class="text-secondary fw-semibold text-end">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($agendas as $agenda)
                  <tr>
                    <td>
                      <span class="fw-semibold text-main fs-7">{{ $agenda->title }}</span>
                    </td>
                    <td><span class="fs-7">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}</span></td>
                    <td><span class="fs-7">{{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}</span></td>
                    <td class="text-end">
                      @if(\Carbon\Carbon::parse($agenda->start_date)->toDateString() <= $today && \Carbon\Carbon::parse($agenda->end_date)->toDateString() >= $today)
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold fs-8"><i class="bi bi-play-circle me-1"></i> Sedang Berlangsung</span>
                      @elseif(\Carbon\Carbon::parse($agenda->start_date)->toDateString() > $today)
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-semibold fs-8"><i class="bi bi-clock me-1"></i> Akan Datang</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-5 text-muted-custom">
            <div class="d-inline-flex justify-content-center align-items-center rounded-circle mb-3" style="width: 64px; height: 64px; background: var(--card-sub-bg);">
              <i class="bi bi-calendar-x fs-2"></i>
            </div>
            <p class="mb-0 fs-6">Tidak ada agenda yang sedang berlangsung atau akan datang dalam waktu dekat.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection