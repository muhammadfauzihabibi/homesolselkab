<div id="adminSidebar" class="sidebar-glass py-3 px-2 d-flex flex-column h-100 shadow-sm">

  <!-- Header Toggle Button (Presisi Tengah) -->
  <div class="d-none d-md-flex align-items-center justify-content-center mb-4 w-100">
    <button type="button" id="sidebarToggleBtn" class="btn-sidebar-toggle" title="Buka/Tutup Sidebar">
      <i class="bi bi-chevron-right fs-6"></i>
    </button>
  </div>

  <!-- List Menu Navigasi -->
  <ul class="nav nav-pills flex-column mb-auto gap-2 w-100 p-0 align-items-center">
    
    <!-- Dashboard -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('dashboard') }}" 
         class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
         title="Dashboard">
        <span class="sidebar-icon"><i class="bi bi-grid-1x2"></i></span>
        <span class="sidebar-text">Dashboard</span>
      </a>
    </li>

    @can('menu')
    <!-- Menu -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('menu.index') }}" 
         class="sidebar-link {{ request()->routeIs('menu.*') ? 'active' : '' }}" 
         title="Kelola Menu">
        <span class="sidebar-icon"><i class="bi bi-menu-button-wide"></i></span>
        <span class="sidebar-text">Kelola Menu</span>
      </a>
    </li>
    @endcan

    @can('page')
    <!-- Halaman Statis -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('page.index') }}" 
         class="sidebar-link {{ request()->routeIs('page.*') ? 'active' : '' }}" 
         title="Halaman Statis">
        <span class="sidebar-icon"><i class="bi bi-file-earmark"></i></span>
        <span class="sidebar-text">Halaman Statis</span>
      </a>
    </li>
    @endcan

    @can('berita')
    <!-- Berita -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('berita.index') }}" 
         class="sidebar-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" 
         title="Berita & Artikel">
        <span class="sidebar-icon"><i class="bi bi-newspaper"></i></span>
        <span class="sidebar-text">Berita & Artikel</span>
      </a>
    </li>
    @endcan

    @can('opd')
    <!-- Layanan OPD -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('opd.index') }}" 
         class="sidebar-link {{ request()->routeIs('opd.*') ? 'active' : '' }}" 
         title="Daftar OPD">
        <span class="sidebar-icon"><i class="bi bi-building"></i></span>
        <span class="sidebar-text">Daftar OPD</span>
      </a>
    </li>
    @endcan

    @can('kecamatan')
    <!-- Kecamatan -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('kecamatan.index') }}" 
         class="sidebar-link {{ request()->routeIs('kecamatan.*') ? 'active' : '' }}" 
         title="Data Kecamatan">
        <span class="sidebar-icon"><i class="bi bi-geo-alt"></i></span>
        <span class="sidebar-text">Data Kecamatan</span>
      </a>
    </li>
    @endcan

    @can('aplikasi-dinas')
    <!-- Aplikasi Dinas -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('aplikasi-dinas.index') }}" 
         class="sidebar-link {{ request()->routeIs('aplikasi-dinas.*') ? 'active' : '' }}" 
         title="Aplikasi Dinas">
        <span class="sidebar-icon"><i class="bi bi-grid-3x3-gap"></i></span>
        <span class="sidebar-text">Aplikasi Dinas</span>
      </a>
    </li>
    @endcan

    @can('pengumuman')
    <!-- Pengumuman -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('pengumuman.index') }}" 
         class="sidebar-link {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}" 
         title="Pengumuman">
        <span class="sidebar-icon"><i class="bi bi-megaphone"></i></span>
        <span class="sidebar-text">Pengumuman</span>
      </a>
    </li>
    @endcan

    @can('agenda')
    <!-- Agenda Kegiatan -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('agenda.index') }}" 
         class="sidebar-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}" 
         title="Agenda Kegiatan">
        <span class="sidebar-icon"><i class="bi bi-calendar-event"></i></span>
        <span class="sidebar-text">Agenda Kegiatan</span>
      </a>
    </li>
    @endcan

    @can('layanan-publik')
    <!-- Layanan Publik -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('layanan-publik.index') }}" 
         class="sidebar-link {{ request()->routeIs('layanan-publik.*') ? 'active' : '' }}" 
         title="Layanan Publik">
        <span class="sidebar-icon"><i class="bi bi-card-checklist"></i></span>
        <span class="sidebar-text">Layanan Publik</span>
      </a>
    </li>
    @endcan

    @can('sarana-prasarana')
    <!-- Sarana & Prasarana -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('sarana-prasarana.index') }}" 
         class="sidebar-link {{ request()->routeIs('sarana-prasarana.*') ? 'active' : '' }}" 
         title="Sarana & Prasarana">
        <span class="sidebar-icon"><i class="bi bi-building-gear"></i></span>
        <span class="sidebar-text">Sarana & Prasarana</span>
      </a>
    </li>
    @endcan

    @can('dokumentasi')
    <!-- Dokumentasi -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('dokumentasi.index') }}" 
         class="sidebar-link {{ request()->routeIs('dokumentasi.*') ? 'active' : '' }}" 
         title="Dokumentasi">
        <span class="sidebar-icon"><i class="bi bi-camera-video"></i></span>
        <span class="sidebar-text">Dokumentasi</span>
      </a>
    </li>
    @endcan

    @role('Super Admin')
    <!-- Manajemen Sistem -->
    <li class="w-100 my-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;"></li>
    
    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('users.index') }}" 
         class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
         title="Manajemen Pengguna">
        <span class="sidebar-icon"><i class="bi bi-people"></i></span>
        <span class="sidebar-text">Manajemen Pengguna</span>
      </a>
    </li>

    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('roles.index') }}" 
         class="sidebar-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" 
         title="Manajemen Role">
        <span class="sidebar-icon"><i class="bi bi-shield-lock"></i></span>
        <span class="sidebar-text">Manajemen Role</span>
      </a>
    </li>

    <li class="nav-item w-100 d-flex justify-content-center">
      <a href="{{ route('activity-logs.index') }}" 
         class="sidebar-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" 
         title="Log Aktivitas">
        <span class="sidebar-icon"><i class="bi bi-clock-history"></i></span>
        <span class="sidebar-text">Log Aktivitas</span>
      </a>
    </li>
    @endrole

    <!-- Pemisah (Divider) -->
    <li class="w-100 my-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;"></li>

    <!-- Logout Button -->
    <li class="nav-item w-100 d-flex justify-content-center">
      <form method="POST" action="{{ route('logout') }}" class="w-100 d-flex justify-content-center" id="logout-form">
        @csrf
        <button type="submit" 
                class="sidebar-link text-danger border-0 bg-transparent" 
                title="Keluar / Logout">
          <span class="sidebar-icon"><i class="bi bi-box-arrow-right"></i></span>
          <span class="sidebar-text">Keluar / Logout</span>
        </button>
      </form>
    </li>

  </ul>

</div>