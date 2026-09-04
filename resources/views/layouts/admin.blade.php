<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Pemda Solok Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/lambangsolsel.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Soft Organic Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-bootstrap5.css') }}">

    @yield('styles')
</head>
<body class="glass-bg d-flex flex-column min-vh-100 p-3 p-lg-4">

    <!-- Header Navbar Container -->
    <div class="px-3 px-lg-4 pt-3">
      <x-navbar />
    </div>

    <!-- Main Flexbox Layout Wrapper -->
    <div class="container-fluid px-3 px-lg-4 flex-grow-1 mt-3">
      <div class="admin-layout-wrapper gap-4"> 
        
        <!-- Sidebar Wrapper (Mengatur Lebar Dinamis 80px -> 250px) -->
        <aside id="sidebarWrapper" class="sidebar-wrapper flex-shrink-0 d-none d-md-block">
          <x-sidebar />
        </aside>

        <!-- Main Content Area (Fleksibel & Otomatis Mendorong/Menyesuaikan Konten) -->
        <main class="main-content-wrapper overflow-hidden pb-4">
          @yield('content')
        </main>

      </div>
    </div>

    <!-- Footer Component -->
    <x-footer />

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none border-0" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 280px; background: transparent;">
      <div class="offcanvas-body p-0">
        <div class="sidebar-wrapper expanded w-100 position-static h-100 p-2">
           <x-sidebar />
        </div>
      </div>
    </div>

    <!-- Stack for Modals -->
    @stack('modals')

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Control Expand/Collapse Sidebar (State Disimpan di LocalStorage) -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.getElementById('sidebarWrapper');
        const toggleBtn = document.getElementById('sidebarToggleBtn');

        if (sidebarWrapper && toggleBtn) {
          // Restore state dari localStorage
          const isExpanded = localStorage.getItem('admin_sidebar_expanded') === 'true';
          if (isExpanded) {
            sidebarWrapper.classList.add('expanded');
          }

          // Handler klik tombol toggle
          toggleBtn.addEventListener('click', function () {
            sidebarWrapper.classList.toggle('expanded');
            const currentState = sidebarWrapper.classList.contains('expanded');
            localStorage.setItem('admin_sidebar_expanded', currentState);
          });
        }
      });
    </script>

    <!-- Script Toggle Mode Terang/Gelap (Single Click) -->
    <script>
      (() => {
        'use strict'

        const getStoredTheme = () => localStorage.getItem('theme')
        const setStoredTheme = theme => localStorage.setItem('theme', theme)

        const getPreferredTheme = () => {
          const storedTheme = getStoredTheme()
          if (storedTheme) return storedTheme
          return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }

        const setTheme = theme => {
          document.documentElement.setAttribute('data-bs-theme', theme)
          updateToggleIcon(theme)
        }

        const updateToggleIcon = theme => {
          const icon = document.getElementById('theme-toggle-icon')
          if (!icon) return

          if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill text-warning fs-5'
          } else {
            icon.className = 'bi bi-moon-stars-fill text-info fs-5'
          }
        }

        const currentTheme = getPreferredTheme()
        setTheme(currentTheme)

        window.addEventListener('DOMContentLoaded', () => {
          const toggleBtn = document.getElementById('theme-toggle-btn')

          if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
              const activeTheme = document.documentElement.getAttribute('data-bs-theme')
              const newTheme = activeTheme === 'dark' ? 'light' : 'dark'

              setStoredTheme(newTheme)
              setTheme(newTheme)
            })
          }
        })

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
          const storedTheme = getStoredTheme()
          if (!storedTheme) {
            setTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
          }
        })
      })()
    </script>

    <!-- SweetAlert2 Confirmation & Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
          form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
              title: "Apakah Anda yakin?",
              text: "Data yang dihapus tidak dapat dikembalikan!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#dc3545",
              cancelButtonColor: "#6c757d",
              confirmButtonText: "Ya, hapus!",
              cancelButtonText: "Batal"
            }).then((result) => {
              if (result.isConfirmed) {
                form.submit();
              }
            });
          });
        });

        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
          logoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
              title: "Yakin ingin keluar?",
              text: "Sesi Anda akan diakhiri.",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#dc3545",
              cancelButtonColor: "#6c757d",
              confirmButtonText: "Ya, keluar!",
              cancelButtonText: "Batal"
            }).then((result) => {
              if (result.isConfirmed) {
                logoutForm.submit();
              }
            });
          });
        }

        @if(session('success'))
          Swal.fire({
            title: "Berhasil!",
            text: "{!! session('success') !!}",
            icon: "success",
            confirmButtonColor: "#0f172a"
          });
        @endif

        @if(session('error'))
          Swal.fire({
            title: "Gagal!",
            text: "{!! session('error') !!}",
            icon: "error",
            confirmButtonColor: "#0f172a"
          });
        @endif
      });
    </script>

    <!-- Vite Custom Tiptap Editor JS -->
    @vite(['resources/js/editor.js'])
    
    @stack('scripts')
    @yield('scripts')
</body>
</html>