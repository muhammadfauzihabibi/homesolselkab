@php
  if (!isset($visitorStats)) {
      try {
          $onlineCount = \App\Models\Visitor::where('visited_at', '>=', now()->subMinutes(15))->count();
          $todayCount = \App\Models\Visitor::whereDate('visited_at', today())->count();
          $totalCount = \App\Models\Visitor::count();
          $visitorStats = [
              'online' => max(1, $onlineCount),
              'today' => max(1, $todayCount),
              'total' => max(1, $totalCount),
          ];
      } catch (\Throwable $e) {
          $visitorStats = ['online' => 1, 'today' => 1, 'total' => 1];
      }
  }
@endphp

<!-- Footer Utama Portal JDS Style -->
<footer class="footer-jds text-white pt-5 pb-4 mt-auto">
  <div class="container">
    
    <!-- Informasi Kontak & Alamat Grid -->
    <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
      
      <!-- Logo & Brand -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda" height="38">
          <img src="{{ asset('images/solok-selatan.png') }}" alt="Logo Solsel" height="32" class="img-white-logo">
        </div>
        <p class="text-white-50 fs-8 leading-relaxed mb-0">
          Unit Pengelola Portal Informasi & Layanan Publik Terpadu Pemerintah Kabupaten Solok Selatan.
        </p>
      </div>

      <!-- Alamat -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex gap-2">
          <i class="bi bi-geo-alt text-warning fs-5 flex-shrink-0"></i>
          <div>
            <h6 class="fw-bold mb-1 fs-7 text-white">Alamat</h6>
            <p class="text-white-50 fs-8 mb-0 leading-relaxed">
              Jalan Raya Padang Aro Kode Pos 27778, Kabupaten Solok Selatan, Sumatera Barat.
            </p>
          </div>
        </div>
      </div>

      <!-- Kontak & Email -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex gap-2 mb-3">
          <i class="bi bi-envelope text-warning fs-5 flex-shrink-0"></i>
          <div>
            <h6 class="fw-bold mb-1 fs-7 text-white">Email</h6>
            <p class="text-white-50 fs-8 mb-0">diskominfo@solselkab.go.id</p>
          </div>
        </div>
        <div class="d-flex gap-2">
          <i class="bi bi-telephone text-warning fs-5 flex-shrink-0"></i>
          <div>
            <h6 class="fw-bold mb-1 fs-7 text-white">Nomor Telepon</h6>
            <p class="text-white-50 fs-8 mb-0">(0755) 7000123</p>
          </div>
        </div>
      </div>

      <!-- Sosial Media -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold mb-3 fs-7 text-white">Sosial Media</h6>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle social-icon-btn"><i class="bi bi-facebook"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle social-icon-btn"><i class="bi bi-instagram"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle social-icon-btn"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle social-icon-btn"><i class="bi bi-youtube"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle social-icon-btn"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

    </div>

    <!-- Section Statistik Pengunjung -->
    <div class="py-3 border-bottom border-secondary border-opacity-25">
      <div class="row align-items-center g-3">
        <div class="col-md-4 text-center text-md-start">
          <span class="fw-bold fs-7 text-white text-uppercase tracking-wide">
            <i class="bi bi-bar-chart-fill text-warning me-2"></i>Statistik Pengunjung
          </span>
        </div>
        <div class="col-md-8">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-3">
            
            {{-- Pengunjung Online --}}
            <div class="d-inline-flex align-items-center bg-dark bg-opacity-50 border border-secondary border-opacity-25 rounded-pill px-3 py-1.5 shadow-sm">
              <span class="spinner-grow spinner-grow-sm text-success me-2" style="width: 8px; height: 8px;" role="status"></span>
              <span class="text-white-50 fs-8 me-2">Online:</span>
              <span class="fw-bold text-white fs-7">{{ number_format($visitorStats['online']) }}</span>
            </div>

            {{-- Pengunjung Hari Ini --}}
            <div class="d-inline-flex align-items-center bg-dark bg-opacity-50 border border-secondary border-opacity-25 rounded-pill px-3 py-1.5 shadow-sm">
              <i class="bi bi-calendar2-check text-warning me-2 fs-8"></i>
              <span class="text-white-50 fs-8 me-2">Hari Ini:</span>
              <span class="fw-bold text-white fs-7">{{ number_format($visitorStats['today']) }}</span>
            </div>

            {{-- Total Pengunjung --}}
            <div class="d-inline-flex align-items-center bg-dark bg-opacity-50 border border-secondary border-opacity-25 rounded-pill px-3 py-1.5 shadow-sm">
              <i class="bi bi-people-fill text-info me-2 fs-8"></i>
              <span class="text-white-50 fs-8 me-2">Total Pengunjung:</span>
              <span class="fw-bold text-white fs-7">{{ number_format($visitorStats['total']) }}</span>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Copyright Bar -->
    <div class="pt-4 text-center">
      <p class="mb-0 fs-8 text-white-50">
        Copyright &copy; {{ date('Y') }} UPTD Kominfo Diskominfo Kabupaten Solok Selatan. Hak Cipta Dilindungi.
      </p>
    </div>

  </div>
</footer>