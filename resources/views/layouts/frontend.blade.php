<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>@yield('title', 'Portal Resmi Pemerintah Kabupaten Solok Selatan')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/lambangsolsel.png') }}">

  <!-- Google Fonts: Noto Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Swiper JS CSS (Untuk Slider Hero) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/front.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/komdigi-widget.css') }}">

  @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">



  <!-- Floating Navbar Component -->
  <x-frontend-navbar />

  <!-- Dynamic Content Area -->
  <main class="flex-grow-1">
    @yield('content')
  </main>

  <!-- Back to Top Button -->
  <button id="backToTopBtn" class="btn btn-back-to-top shadow-sm d-flex align-items-center gap-2 rounded-pill px-3 py-2">
    <i class="bi bi-arrow-up"></i>
  </button>

  <!-- Accessibility Floating Widget -->
  <x-accessibility-widget />

  <!-- Footer Component -->
  <x-frontend-footer />

  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Swiper JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Core Theme & Layout Controller Script -->
  <script>
    (() => {
      'use strict'

      const getStoredTheme = () => localStorage.getItem('theme')
      const setStoredTheme = theme => localStorage.setItem('theme', theme)

      const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) return storedTheme
        return 'light'
      }

      const setTheme = theme => {
        document.documentElement.setAttribute('data-bs-theme', theme)
        updateToggleIcon(theme)
      }

      const updateToggleIcon = theme => {
        const icon = document.getElementById('theme-toggle-icon')
        if (!icon) return

        if (theme === 'dark') {
          icon.className = 'bi bi-sun-fill fs-6'
        } else {
          icon.className = 'bi bi-moon-stars-fill fs-6'
        }
      }

      setTheme(getPreferredTheme())

      window.addEventListener('DOMContentLoaded', () => {
        // Toggle Dark Mode Event
        const toggleBtn = document.getElementById('theme-toggle-btn')
        if (toggleBtn) {
          toggleBtn.addEventListener('click', () => {
            const activeTheme = document.documentElement.getAttribute('data-bs-theme')
            const newTheme = activeTheme === 'dark' ? 'light' : 'dark'
            setStoredTheme(newTheme)
            setTheme(newTheme)
          })
        }

        // Auto-Hide Navbar & Marquee saat Scroll Ke Bawah
        const navbarWrapper = document.getElementById('navbar-wrapper')
        const marqueeBanner = document.getElementById('marquee-banner')
        let lastScrollY = window.pageYOffset || document.documentElement.scrollTop
        let ticking = false

        if (navbarWrapper || marqueeBanner) {
          window.addEventListener('scroll', () => {
            if (!ticking) {
              window.requestAnimationFrame(() => {
                const currentScrollY = window.pageYOffset || document.documentElement.scrollTop
                const isMobileMenuOpen = document.querySelector('#mainNavbar.show')

                if (!isMobileMenuOpen) {
                  if (currentScrollY > lastScrollY && currentScrollY > 70) {
                    if (navbarWrapper) navbarWrapper.classList.add('navbar-hidden')
                    if (marqueeBanner) marqueeBanner.classList.add('marquee-hidden')
                  } else {
                    if (navbarWrapper) navbarWrapper.classList.remove('navbar-hidden')
                    if (marqueeBanner) marqueeBanner.classList.remove('marquee-hidden')
                  }
                }

                lastScrollY = currentScrollY <= 0 ? 0 : currentScrollY
                ticking = false
              })
              ticking = true
            }
          }, { passive: true })
        }

        // Back to Top Button Controller
        const backToTopBtn = document.getElementById('backToTopBtn')
        if (backToTopBtn) {
          window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
              backToTopBtn.classList.add('show')
            } else {
              backToTopBtn.classList.remove('show')
            }
          })

          backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' })
          })
        }
      })
    })()
  </script>

  <script>
    const bgSlides = document.querySelectorAll('.hero-bg-slide');
    if (bgSlides.length > 0) {
      let currentBgIndex = 0;
      setInterval(() => {
        bgSlides[currentBgIndex].classList.remove('active');
        currentBgIndex = (currentBgIndex + 1) % bgSlides.length;
        bgSlides[currentBgIndex].classList.add('active');
      }, 4000); // Berganti gambar setiap 4 detik
    }
  </script>

  <script>
    // Tutup semua accordion (details) di frontend secara default
    // Editor menyimpan dengan atribut 'open', tapi di frontend kita ingin tertutup dulu
    document.addEventListener('DOMContentLoaded', function () {
      const details = document.querySelectorAll('.page-detail-body details');
      details.forEach(function (el) {
        el.removeAttribute('open');
      });
    });
  </script>



  @yield('scripts')
</body>
</html>
