<!-- Floating Capsule Navbar Wrapper -->
<div class="container fixed-top pt-3" id="navbar-wrapper">
  <nav class="navbar navbar-expand-lg navbar-floating shadow-sm">
    <div class="container-fluid px-3 px-lg-4">
      
      <!-- Logo Brand -->
      <a class="navbar-brand d-flex align-items-center gap-2 py-0 me-4" href="{{ url('/') }}">
        <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda" height="36">
        
        <!-- Logo untuk Light Mode -->
        <img src="{{ asset('images/solok-selatan-dark.png') }}" alt="Logo Solsel" height="30" class="d-none d-sm-inline-block brand-logo-light">
        
        <!-- Logo untuk Dark Mode -->
        <img src="{{ asset('images/solok-selatan.png') }}" alt="Logo Solsel" height="30" class="d-none d-sm-inline-block brand-logo-dark">
      </a>

      <!-- Mobile Toggler -->
      <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapse Container -->
      <div class="collapse navbar-collapse" id="mainNavbar">
        
        <!-- Menu Links (Menggunakan ms-auto agar rata kanan) -->
        <ul class="navbar-nav ms-auto me-4 mb-2 mb-lg-0 gap-lg-2 align-items-lg-center">

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
            href="{{ route('home') }}">
                Home
            </a>
          </li>

          @foreach($menus as $menu)

              {{-- MENU PARENT (PUNYA SUBMENU) --}}
              @if($menu->tipe == 'parent')

                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                          <span>{{ $menu->nama }}</span>
                          <i class="bi bi-chevron-down fs-8 ms-1"></i>
                      </a>

                      <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">

                          @foreach($menu->children()->where('aktif',1)->orderBy('urutan')->get() as $child)

                              {{-- SUBMENU EXTERNAL --}}
                              @if($child->tipe == 'external')

                                  <li>
                                      <a class="dropdown-item py-2"
                                        href="{{ $child->url }}"
                                        target="_blank">
                                          {{ $child->nama }}
                                      </a>
                                  </li>

                              {{-- SUBMENU INTERNAL --}}
                              @elseif($child->tipe == 'internal')

                                  @foreach($child->page->where('aktif', true) as $page)

                                      <li>
                                          <a class="dropdown-item py-2"
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

                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">
                              <span>{{ $menu->nama }}</span>
                              <i class="bi bi-chevron-down fs-8 ms-1"></i>
                          </a>

                          <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">

                              @foreach($menu->page->where('aktif', true) as $page)

                                  <li>
                                      <a class="dropdown-item py-2"
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

                  <li class="nav-item">
                      <a class="nav-link"
                        href="{{ $menu->url }}"
                        target="_blank">
                          {{ $menu->nama }}
                      </a>
                  </li>

              @endif

          @endforeach
        </ul>

        <!-- Action Control: Theme Toggle Button -->
        <div class="d-flex align-items-center pt-2 pt-lg-0 mt-2 mt-lg-0 ms-lg-3">
          <button class="btn btn-theme-toggle d-flex align-items-center justify-content-center rounded-circle" 
                  id="theme-toggle-btn" 
                  type="button" 
                  title="Ubah Tema (Terang/Gelap)">
            <i class="bi bi-moon-stars-fill text-dark fs-6" id="theme-toggle-icon"></i>
          </button>
        </div>

      </div>

    </div>
  </nav>
</div>