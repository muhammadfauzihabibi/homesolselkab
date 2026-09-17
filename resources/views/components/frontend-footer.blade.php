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

  if (!isset($settings)) {
      try {
          $settings = \App\Models\Setting::pluck('value', 'key')->all();
      } catch (\Throwable $e) {
          $settings = [];
      }
  }

  $sosmeds = !empty($settings['sosmed_links']) ? json_decode($settings['sosmed_links'], true) : [];
  $hasAddress = !empty($settings['footer_address']);
  $hasEmail = !empty($settings['footer_email']);
  $hasPhone = !empty($settings['footer_phone']);
  $hasMaps = !empty($settings['footer_google_maps']);
@endphp

<!-- Direct Background Footer Component (Full-width Section, Nav Navigation Removed) -->
<footer class="footer-custom-wrapper mt-auto py-5 border-top">
  <div class="container py-2">

    <!-- Upper Row Grid (3 Columns: Brand & Sosmed | Kontak & Alamat | Peta Lokasi) -->
    <div class="row g-4 justify-content-between align-items-start">

      <!-- Column 1: Brand Logo, Deskripsi & Sosial Media -->
      <div class="col-lg-5 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda" height="44" class="flex-shrink-0">
          <img src="{{ asset('images/solok-selatan-dark.png') }}" alt="Logo Solsel" height="30" class="brand-logo-light">
          <img src="{{ asset('images/solok-selatan.png') }}" alt="Logo Solsel" height="30" class="brand-logo-dark">
        </div>

        <p class="footer-desc mb-4 fs-7">
          {{ $settings['site_description'] ?? 'Portal Resmi Pemerintah Kabupaten Solok Selatan. Pusat informasi publik, layanan perizinan digital, dan kanal pengaduan masyarakat.' }}
        </p>

        <!-- Social Media Links Row -->
        <div class="d-flex align-items-center gap-3 footer-social-row">
          @if(is_array($sosmeds) && count($sosmeds) > 0)
            @foreach($sosmeds as $sm)
              <a href="{{ $sm['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="footer-icon-link" title="{{ $sm['label'] ?? '' }}">
                <i class="bi {{ $sm['icon'] ?? 'bi-globe' }}"></i>
              </a>
            @endforeach
          @else
            <small class="text-muted-custom fs-8 d-inline-flex align-items-center gap-1">
              <i class="bi bi-info-circle opacity-75"></i> Media sosial belum diisi di Pengaturan
            </small>
          @endif
        </div>
      </div>

      <!-- Column 2: Kontak & Alamat -->
      <div class="col-lg-3 col-md-6">
        <h6 class="footer-column-title mb-3 fs-6 fw-bold">Kontak & Alamat</h6>
        <ul class="list-unstyled footer-contact-list d-flex flex-column gap-3 mb-0 fs-7">
          <li class="d-flex gap-2">
            <i class="bi bi-geo-alt-fill text-primary flex-shrink-0 mt-1 fs-6"></i>
            <div>
              @if($hasAddress)
                <span>{{ $settings['footer_address'] }}</span>
              @else
                <span class="text-muted-custom fs-8 fst-italic">[Alamat kantor belum diisi]</span>
              @endif
            </div>
          </li>
          <li class="d-flex gap-2 align-items-center">
            <i class="bi bi-envelope-at-fill text-primary flex-shrink-0 fs-6"></i>
            <div>
              @if($hasEmail)
                <span>{{ $settings['footer_email'] }}</span>
              @else
                <span class="text-muted-custom fs-8 fst-italic">[Email belum diisi]</span>
              @endif
            </div>
          </li>
          <li class="d-flex gap-2 align-items-center">
            <i class="bi bi-telephone-fill text-primary flex-shrink-0 fs-6"></i>
            <div>
              @if($hasPhone)
                <span>{{ $settings['footer_phone'] }}</span>
              @else
                <span class="text-muted-custom fs-8 fst-italic">[No. Telepon belum diisi]</span>
              @endif
            </div>
          </li>
        </ul>
      </div>

      <!-- Column 3: Peta Lokasi Google Maps -->
      <div class="col-lg-4 col-md-12">
        <h6 class="footer-column-title mb-3 fs-6 fw-bold">Lokasi Kantor</h6>
        <div class="footer-map-container rounded-4 overflow-hidden border">
          @if($hasMaps)
            {!! $settings['footer_google_maps'] !!}
          @else
            <div class="footer-map-empty rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-center h-100 bg-body-tertiary">
              <i class="bi bi-geo-alt fs-2 text-muted opacity-50 mb-1"></i>
              <span class="text-muted-custom fs-8 fw-semibold">Peta Google Maps belum diisi</span>
              <small class="text-muted-custom fs-9 mt-0.5">Silakan isi kode iframe di menu Pengaturan Admin</small>
            </div>
          @endif
        </div>
      </div>

    </div>

    <!-- Divider -->
    <hr class="footer-divider my-4 opacity-25">

    <!-- Lower Row: Copyright & Visitor Stats Only (No Navigation Links) -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 fs-8 footer-bottom-row">
      <p class="mb-0 copyright-text">
        &copy; {{ date('Y') }} Pemerintah Kabupaten Solok Selatan. Hak Cipta Dilindungi.
      </p>

      <!-- Visitor Stats Pills -->
      <div class="d-flex flex-wrap align-items-center gap-2 footer-stats-wrapper">
        <div class="footer-stat-badge">
          <span class="pulse-dot bg-success"></span>
          <span class="opacity-75">Online:</span>
          <strong>{{ number_format($visitorStats['online']) }}</strong>
        </div>
        <div class="footer-stat-badge">
          <i class="bi bi-calendar-check text-warning"></i>
          <span class="opacity-75">Hari ini:</span>
          <strong>{{ number_format($visitorStats['today']) }}</strong>
        </div>
        <div class="footer-stat-badge">
          <i class="bi bi-bar-chart-line text-info"></i>
          <span class="opacity-75">Total:</span>
          <strong>{{ number_format($visitorStats['total']) }}</strong>
        </div>
      </div>
    </div>

  </div>
</footer>