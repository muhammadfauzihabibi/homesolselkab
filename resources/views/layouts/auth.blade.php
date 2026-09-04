<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - Pemda Solok Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/lambangsolsel.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Soft Organic Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-bootstrap5.css') }}">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background-color: var(--bg-main, #f4f6f8);
            color: var(--text-dark, #1e293b);
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .auth-card {
            width: 100%;
            max-width: 960px;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            background: var(--card-bg, rgba(255, 255, 255, 0.85));
            backdrop-filter: blur(12px);
        }

        .auth-branding-panel {
            background: linear-gradient(135deg, #ccfbf1 0%, #e0e7ff 50%, #fef3c7 100%);
            border-radius: 20px;
            padding: 2.5rem;
            display: flex;
            flex-column: column;
            justify-content: space-between;
            height: 100%;
            color: #0f172a;
        }

        [data-bs-theme="dark"] .auth-branding-panel {
            background: linear-gradient(135deg, #064e3b 0%, #1e1b4b 50%, #78350f 100%);
            color: #f8fafc;
        }

        .auth-badge-pill {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 999px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        [data-bs-theme="dark"] .auth-badge-pill {
            background: rgba(15, 23, 42, 0.6);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .form-control, .form-select {
            background-color: var(--card-sub-bg, #f8fafc);
            border: 1px solid transparent;
            color: var(--text-dark, #1e293b);
            border-radius: 16px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--card-sub-bg, #ffffff);
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .btn-dark-pill {
            background-color: #0f172a;
            color: #ffffff;
            border-radius: 999px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-dark-pill:hover {
            background-color: #1e293b;
            color: #ffffff;
            transform: translateY(-1px);
        }

        [data-bs-theme="dark"] .btn-dark-pill {
            background-color: #f8fafc;
            color: #0f172a;
        }

        [data-bs-theme="dark"] .btn-dark-pill:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="auth-container">
        <div class="auth-card p-3 p-md-4">
            <div class="row g-4 align-items-stretch">
                
                <!-- Left Panel: Branding & Information (Hidden on mobile) -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="auth-branding-panel">
                        <div>
                            <!-- Header Logo & Name -->
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="{{ asset('images/lambangsolsel.png') }}" 
                                     alt="Logo Pemda Solok Selatan" 
                                     style="width: 48px; height: auto;" 
                                     onerror="this.src='{{ asset('images/logo.png') }}'">
                                <div>
                                    <h6 class="fw-extrabold mb-0 fs-6">Pemda Solok Selatan</h6>
                                    <small class="opacity-75 fs-8">Portal Layanan Terpadu</small>
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

                <!-- Right Panel: Auth Form & Controls -->
                <div class="col-12 col-lg-7 d-flex flex-column justify-content-between p-3 p-md-4">
                    
                    <!-- Top Navigation & Theme Switcher -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-lg-none d-flex align-items-center gap-2">
                            <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Solsel" style="width: 36px; height: auto;">
                            <span class="fw-bold text-main fs-7">Pemda Solsel</span>
                        </div>
                        <div class="ms-auto d-flex align-items-center gap-2">
                            @yield('top-nav')
                            <!-- Single Click Theme Switcher Toggle -->
                            <button class="btn btn-glass-icon d-flex align-items-center justify-content-center p-2 rounded-circle" 
                                    id="theme-toggle-btn" 
                                    type="button" 
                                    title="Ubah Tema (Terang/Gelap)"
                                    style="width: 38px; height: 38px;">
                                <i class="bi bi-moon-stars-fill fs-6" id="theme-toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Dynamic Form Content -->
                    <div class="my-auto py-2">
                        @yield('content')
                    </div>

                    <!-- Footer Info -->
                    <div class="mt-4 pt-3 border-top text-center text-lg-start" style="border-color: var(--card-sub-bg) !important;">
                        <p class="text-muted-custom fs-8 mb-0">
                            Dengan melanjutkan, Anda menyetujui <a href="#" class="text-decoration-none fw-semibold">Syarat & Ketentuan</a> serta <a href="#" class="text-decoration-none fw-semibold">Kebijakan Privasi</a> Pemda Kabupaten Solok Selatan.
                        </p>
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
                    icon.className = 'bi bi-moon-stars-fill text-info fs-6'
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