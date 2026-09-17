@php
  // Ambil pengaturan navbar marquee dari settings
  if (!isset($settings)) {
      try {
          $settings = \App\Models\Setting::pluck('value', 'key')->all();
      } catch (\Throwable $e) {
          $settings = [];
      }
  }

  $marqueeEnabled = ($settings['navbar_marquee_enabled'] ?? '0') === '1';
  $marqueeText = $settings['navbar_marquee_text'] ?? '';

  $currentUrl = request()->url();
  $currentFullUrl = request()->fullUrl();
  $currentSlug = request()->routeIs('page.show') ? request()->route('slug') : (request()->segment(1) === 'halaman' ? request()->segment(2) : null);

  $checkUrlActive = function ($url) use ($currentUrl, $currentFullUrl) {
      if (!$url || $url === '#') return false;
      if ($url === $currentUrl || $url === $currentFullUrl) return true;
      try {
          $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
          if (!empty($path) && (request()->is($path) || request()->is($path . '/*'))) {
              return true;
          }
      } catch (\Throwable $e) {
          // ignore
      }
      return false;
  };
@endphp

<!-- Marquee Text Banner (if enabled) -->
@if($marqueeEnabled && !empty(trim($marqueeText)))
<div class="marquee-banner-wrapper fixed-top" id="marquee-banner">
  <div class="marquee-banner">
    <div class="marquee-badge">
      <i class="bi bi-megaphone-fill"></i>
      <span class="marquee-badge-text">INFORMASI</span>
    </div>
    <div class="marquee-track">
      <div class="marquee-content">
        <span class="marquee-text">{{ $marqueeText }}</span>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Navbar Floating Wrapper -->
<div class="container navbar-bento-wrapper fixed-top {{ $marqueeEnabled && !empty(trim($marqueeText)) ? 'has-marquee' : '' }}" id="navbar-wrapper">
  <nav class="navbar navbar-expand-lg navbar-bento shadow">
    <div class="container-fluid px-3 px-lg-4">

      <!-- Logo Brand -->
      <a class="navbar-brand d-flex align-items-center gap-2 py-0 me-auto" href="{{ route('home') }}">
        <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda" height="38" class="flex-shrink-0">
        <img src="{{ asset('images/solok-selatan-dark.png') }}" alt="Logo Solsel" height="28" class="d-none d-sm-inline-block brand-logo-light">
        <img src="{{ asset('images/solok-selatan.png') }}" alt="Logo Solsel" height="28" class="d-none d-sm-inline-block brand-logo-dark">
      </a>

      <!-- Mobile Toggler -->
      <button class="navbar-toggler border-0 shadow-none p-2 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapse Container -->
      <div class="collapse navbar-collapse" id="mainNavbar">

        <!-- Menu Links -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-1 align-items-lg-center">

          <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('home') || request()->is('/')) ? 'active' : '' }}"
               href="{{ route('home') }}">
                Beranda
            </a>
          </li>

          @foreach($menus as $menu)

              {{-- MENU PARENT (PUNYA SUBMENU) --}}
              @if($menu->tipe == 'parent')
                  @php
                      $children = $menu->children()->where('aktif', 1)->orderBy('urutan')->get();
                      $isParentActive = false;
                      foreach ($children as $child) {
                          if ($child->tipe == 'internal') {
                              foreach ($child->page->where('aktif', true) as $page) {
                                  if ($currentSlug && $currentSlug === $page->slug) {
                                      $isParentActive = true;
                                      break 2;
                                  }
                              }
                          } elseif ($child->tipe == 'external') {
                              if ($checkUrlActive($child->url)) {
                                  $isParentActive = true;
                                  break;
                              }
                          }
                      }
                  @endphp

                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle no-caret d-flex align-items-center gap-1 {{ $isParentActive ? 'active' : '' }}"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                          <span>{{ $menu->nama }}</span>
                          <i class="bi bi-chevron-down fs-8 ms-1 opacity-75"></i>
                      </a>

                      <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">

                          @foreach($children as $child)

                              {{-- SUBMENU EXTERNAL --}}
                              @if($child->tipe == 'external')
                                  @php
                                      $isChildActive = $checkUrlActive($child->url);
                                  @endphp
                                  <li>
                                      <a class="dropdown-item py-2 {{ $isChildActive ? 'active' : '' }}"
                                        href="{{ $child->url }}"
                                        target="_blank" rel="noopener noreferrer">
                                          {{ $child->nama }}
                                      </a>
                                  </li>

                              {{-- SUBMENU INTERNAL --}}
                              @elseif($child->tipe == 'internal')

                                  @foreach($child->page->where('aktif', true) as $page)
                                      @php
                                          $isPageActive = ($currentSlug && $currentSlug === $page->slug);
                                      @endphp
                                      <li>
                                          <a class="dropdown-item py-2 {{ $isPageActive ? 'active' : '' }}"
                                            href="{{ route('page.show', $page->slug) }}">
                                              {{ $page->judul }}
                                          </a>
                                      </li>

                                  @endforeach

                              @endif

                          @endforeach

                      </ul>
                  </li>

              {{-- MENU INTERNAL --}}
              @elseif($menu->tipe == 'internal')

                  @if($menu->page->count())
                      @php
                          $isMenuInternalActive = false;
                          foreach ($menu->page->where('aktif', true) as $page) {
                              if ($currentSlug && $currentSlug === $page->slug) {
                                  $isMenuInternalActive = true;
                                  break;
                              }
                          }
                      @endphp

                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle no-caret d-flex align-items-center gap-1 {{ $isMenuInternalActive ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                              <span>{{ $menu->nama }}</span>
                              <i class="bi bi-chevron-down fs-8 ms-1 opacity-75"></i>
                          </a>

                          <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">

                              @foreach($menu->page->where('aktif', true) as $page)
                                  @php
                                      $isPageActive = ($currentSlug && $currentSlug === $page->slug);
                                  @endphp
                                  <li>
                                      <a class="dropdown-item py-2 {{ $isPageActive ? 'active' : '' }}"
                                        href="{{ route('page.show', $page->slug) }}">
                                          {{ $page->judul }}
                                      </a>
                                  </li>

                              @endforeach

                          </ul>
                      </li>

                  @endif

              {{-- MENU EXTERNAL --}}
              @elseif($menu->tipe == 'external')
                  @php
                      $isExtActive = $checkUrlActive($menu->url);
                  @endphp
                  <li class="nav-item">
                      <a class="nav-link {{ $isExtActive ? 'active' : '' }}"
                        href="{{ $menu->url }}"
                        target="_blank" rel="noopener noreferrer">
                          {{ $menu->nama }}
                      </a>
                  </li>

              @endif

          @endforeach

          <!-- Menu Unduhan / Transparansi -->
          <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('frontend.unduhan.*') || request()->is('semua/unduhan*') || request()->is('unduh/*')) ? 'active' : '' }}"
               href="{{ request()->routeIs('home') ? '#transparansi' : route('home') . '#transparansi' }}">
                Transparansi
            </a>
          </li>

        </ul>

        <!-- Theme Toggle Button -->
        <div class="d-flex align-items-center justify-content-center pt-2 pt-lg-0 mt-2 mt-lg-0 ms-lg-2">
          <button class="btn-bento-theme" id="theme-toggle-btn" type="button" title="Ubah Tema" aria-label="Toggle Theme">
            <i class="bi bi-moon-stars-fill fs-6" id="theme-toggle-icon"></i>
          </button>
        </div>

      </div>

    </div>
  </nav>
</div>
