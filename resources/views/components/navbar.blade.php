<nav class="navbar navbar-expand-lg sticky-top  mb-4">
  <div class="container-fluid px-2">
    <!-- Sidebar Toggle for Mobile -->
    <button class="btn btn-glass-icon d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-5"></i>
    </button>
    
    <!-- Title / Brand Logo Left -->
    <a class="navbar-brand d-flex align-items-center gap-3 me-auto" href="{{ route('dashboard') }}">
      <div class="rounded-circle d-flex align-items-center justify-content-center p-1" style="width: 38px; height: 38px; background: #e9f8d9;">
        <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda Solsel" width="24" height="24" onerror="this.src='{{ asset('images/logo.png') }}'">
      </div>
      <div>
        <span class="fw-bold fs-6 d-block leading-none" style="letter-spacing: -0.3px;">Dashboard Overview</span>
        <small class="text-muted-custom d-block fs-8">Portal Pengolah Data Pemkab Solok Selatan</small>
      </div>
    </a>
    
    <!-- Mobile Toggler -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end mt-2 mt-lg-0" id="navbarNav">

      <ul class="navbar-nav align-items-center gap-2">

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown ms-lg-1">
          <a class="nav-link d-flex align-items-center gap-2 p-1 pe-3 rounded-pill bg-light" href="#" role="button" aria-expanded="false">
            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-7 shadow-sm" style="width: 34px; height: 34px;">
              {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 2)) }}
            </div>
            <span class="fw-semibold fs-7 text-truncate text-dark d-none d-sm-inline" style="max-width: 110px;">{{ Auth::user()->name ?? 'Administrator' }}</span>
          </a>
        </li>
      </ul>

      <!-- Single Click Theme Switcher Toggle -->
      <div class="d-flex align-items-center p-3">
        <button class="btn btn-glass-icon d-flex align-items-center justify-content-center p-2 rounded-circle" 
                id="theme-toggle-btn" 
                type="button" 
                title="Ubah Tema (Terang/Gelap)"
                style="width: 40px; height: 40px;">
          <i class="bi bi-moon-stars-fill fs-5" id="theme-toggle-icon"></i>
        </button>
      </div>
    </div>
  </div>
</nav>