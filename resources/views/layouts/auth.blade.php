<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - Pemda Solok Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/lambangsolsel.png') }}">

    <!-- Google Fonts: Noto Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Soft Organic Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-bootstrap5.css') }}?v={{ time() }}">

    @yield('styles')
</head>
<body>

    <div class="auth-container">
        <!-- Wadah Card Utama Membungkus Kedua Sisi -->
        <div class="glass-card p-4 p-md-5 my-auto" style="width: 100%; max-width: 1100px;">
            <div class="row g-4 align-items-center">

                <!-- Left Panel: Branding & Information -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="auth-branding-panel border-end pe-lg-4" style="border-color: var(--card-sub-bg) !important;">
                        <div>
                            <!-- Header Logo & Name -->
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="{{ asset('images/lambangsolsel.png') }}"
                                     alt="Logo Pemda Solok Selatan"
                                     style="width: 48px; height: auto;"
                                     onerror="this.src='{{ asset('images/logo.png') }}'">
                                <div>
                                    <h6 class="fw-extrabold mb-0 fs-6 text-main">Pemda Solok Selatan</h6>
                                    <small class="text-muted-custom fs-8">Portal Layanan Terpadu</small>
                                </div>
                            </div>

                            <!-- Feature Badges -->
                            <div class="d-flex flex-column gap-2 mb-4">
                                <div class="auth-badge-pill">
                                    <i class="bi bi-shield-check text-success"></i> SIPD & E-Gov Solsel
                                </div>
                                <div class="auth-badge-pill">
                                    <i class="bi bi-file-earmark-check text-primary"></i> Perizinan & Publik
                                </div>
                                <div class="auth-badge-pill">
                                    <i class="bi bi-star-fill text-warning"></i> Saluak Sekata Barat Daya
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Form Controls -->
                <div class="col-12 col-lg-7">
                    <div class="ps-lg-2">
                        <!-- Top Navigation & Theme Switcher -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-lg-none d-flex align-items-center gap-2">
                                <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Solsel" style="width: 36px; height: auto;">
                                <span class="fw-bold text-main fs-7">Pemda Solsel</span>
                            </div>
                            <div class="ms-auto d-flex align-items-center gap-3">
                                @yield('top-nav')

                                <!-- Single Click Theme Switcher Toggle -->
                                <button class="btn btn-glass-icon d-flex align-items-center justify-content-center p-2 rounded-circle"
                                        id="theme-toggle-btn"
                                        type="button"
                                        title="Ubah Tema (Terang/Gelap)"
                                        style="width: 38px; height: 38px;">
                                    <i class="bi bi-moon-stars-fill fs-6 text-primary" id="theme-toggle-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Dynamic Form Content (Login/Register) -->
                        <div class="my-auto py-2">
                            @yield('content')
                        </div>

                        <!-- Footer Info -->
                        <div class="mt-4 pt-3 border-top text-center text-lg-start" style="border-color: var(--card-sub-bg) !important;">
                            <p class="text-muted-custom fs-8 mb-0">
                                Dengan melanjutkan, Anda menyetujui <a href="#" class="text-decoration-none fw-semibold" style="color: #4c87ba;">Syarat & Ketentuan</a> serta <a href="#" class="text-decoration-none fw-semibold" style="color: #4c87ba;">Kebijakan Privasi</a> Pemda Kabupaten Solok Selatan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Toggle Warna Mode Terang/Gelap Otomatis -->
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
                    icon.className = 'bi bi-sun-fill text-warning fs-6'
                } else {
                    icon.className = 'bi bi-moon-stars-fill text-primary fs-6'
                }
            }

            setTheme(getPreferredTheme())

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
        })()

        // Helper Password Visibility Toggle
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordInput && toggleIcon) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                }
            }
        }
    </script>

    @yield('scripts')
</body>
</html>
