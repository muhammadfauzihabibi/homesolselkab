<nav class="navbar navbar-glass p-2 p-lg-3 mb-3">
  <div class="container-fluid px-2 d-flex align-items-center justify-content-between gap-2">

    <!-- Left Section: Mobile Toggle & Brand Logo -->
    <div class="d-flex align-items-center gap-2 gap-lg-3">
      <!-- Sidebar Toggle for Mobile -->
      <button class="btn btn-glass-icon d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Toggle navigation">
        <i class="bi bi-list fs-5"></i>
      </button>

      <!-- Brand Logo Left -->
      <a class="navbar-brand d-flex align-items-center gap-2 gap-lg-3 m-0" href="{{ route('dashboard') }}">
        <div class="rounded-circle d-flex align-items-center justify-content-center p-1" style="width: 42px; height: 42px; background: rgba(76, 135, 186, 0.15);">
          <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda Solsel" width="26" height="26" onerror="this.src='{{ asset('images/logo.png') }}'">
        </div>
        <div class="d-none d-sm-block">
          <span class="fw-bold fs-9 d-block leading-none" style="letter-spacing: -0.3px; color: var(--text-dark);">Admin Panel</span>
          <small class="text-muted d-block fs-10">Portal Admin Pemda Solok Selatan</small>
        </div>
      </a>
    </div>

    <!-- Right Section: Action Buttons, Theme Switcher & Profile -->
    <div class="d-flex align-items-center gap-2">

      <!-- Theme Switcher Button -->
      <button class="btn btn-glass-icon d-flex align-items-center justify-content-center"
              id="theme-toggle-btn"
              type="button"
              title="Ubah Tema (Terang/Gelap)"
              style="width: 42px; height: 42px; min-width: 42px; min-height: 42px; padding: 0; border-radius: 50%; border: 1px solid rgba(76, 135, 186, 0.12); background: var(--card-sub-bg); color: var(--text-dark);">
        <i class="bi bi-moon-stars-fill" id="theme-toggle-icon"></i>
      </button>

      <!-- User Profile Chip -->
      <div class="dropdown">
        <button class="btn btn-glass-pill d-flex align-items-center gap-2 py-1 ps-1 pe-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
               style="width: 34px; height: 34px; background: var(--solsel-primary); font-size: 0.85rem;">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
          </div>
          <div class="text-start d-none d-md-block">
            <span class="fw-semibold fs-8 d-block leading-none text-truncate" style="max-width: 120px;">{{ Auth::user()->name ?? 'Administrator' }}</span>
            <small class="text-muted d-block fs-8" style="font-size: 0.7rem;">{{ Auth::user()->roles->pluck('name')->first() ?? 'Admin OPD' }}</small>
          </div>
          <i class="bi bi-chevron-down fs-8 text-muted ms-1 d-none d-md-inline"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end sidebar-dropdown">
          <li class="px-3 py-2 border-bottom mb-1">
            <span class="fw-bold fs-7 d-block">{{ Auth::user()->name ?? 'Administrator' }}</span>
          </li>
          @role('Super Admin')
          <li>
            <a class="dropdown-item" href="{{ route('settings.index') }}">
              <i class="bi bi-gear me-2"></i>Pengaturan Sistem
            </a>
          </li>
          @endrole
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}" id="logout-navbar-form">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar / Logout
              </button>
            </form>
          </li>
        </ul>
      </div>

    </div>

  </div>
</nav>
