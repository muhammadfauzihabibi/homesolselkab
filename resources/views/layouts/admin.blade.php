<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Pemda Solok Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/lambangsolsel.png') }}">

    <!-- Google Fonts: Noto Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Solsel Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-bootstrap5.css') }}?v={{ time() }}">

    <!-- Sidebar Dropdown & Override CSS -->
    <style>
        .sidebar-dropdown {
            background: var(--card-bg);
            border: 1px solid rgba(76, 135, 186, 0.15);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px 0;
            margin-top: 8px;
            min-width: 220px;
        }

        .sidebar-dropdown .dropdown-item {
            padding: 10px 16px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 10px;
            margin: 2px 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .sidebar-dropdown .dropdown-item:hover {
            background: rgba(76, 135, 186, 0.12);
            color: var(--solsel-primary);
            transform: translateX(4px);
        }

        .sidebar-dropdown .dropdown-item.active {
            background: var(--solsel-primary);
            color: white;
        }

        .sidebar-dropdown .dropdown-item i {
            width: 18px;
            font-size: 14px;
        }

        .sidebar-arrow {
            display: none !important;
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-wrapper.expanded .sidebar-arrow {
            display: inline-flex !important;
            align-items: center;
        }

        .sidebar-link[aria-expanded="true"] .sidebar-arrow,
        .sidebar-link.dropdown-toggle[aria-expanded="true"] .sidebar-arrow {
            transform: rotate(180deg);
        }

        /* Hilangkan backdrop / frame hitam di belakang modal popup */
        .modal-backdrop,
        .modal-backdrop.show,
        .modal-backdrop.fade {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        .modal-dialog {
            filter: drop-shadow(0 20px 45px rgba(0, 0, 0, 0.22));
        }
    </style>

    @yield('styles')
</head>

<body class="glass-bg d-flex flex-column min-vh-100 p-2 p-lg-3">

    <!-- Header Navbar Container -->
    <div class="px-2 px-lg-3 pt-2">
        <x-navbar />
    </div>

    <!-- Main Flexbox Layout Wrapper -->
    <div class="container-fluid px-2 px-lg-3 flex-grow-1 mt-3">
        <div class="admin-layout-wrapper gap-3 gap-lg-4">

            <!-- Sidebar Wrapper -->
            <aside id="sidebarWrapper" class="sidebar-wrapper flex-shrink-0 d-none d-md-block">
                <x-sidebar />
            </aside>

            <!-- Main Content Area -->
            <main class="main-content-wrapper overflow-hidden pb-4">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Footer Component -->
    <x-footer />

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none border-0" tabindex="-1" id="mobileSidebar"
        aria-labelledby="mobileSidebarLabel" style="width: 280px; background: transparent;">
        <div class="offcanvas-body p-0">
            <div class="sidebar-wrapper expanded w-100 position-static h-100 p-2">
                <x-sidebar />
            </div>
        </div>
    </div>

    @stack('modals')

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Control Expand/Collapse Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.getElementById('sidebarWrapper');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const toggleIcon = document.getElementById('toggleIcon');

            const syncSidebarToggleIcon = () => {
                if (!sidebarWrapper || !toggleIcon) return;

                const isExpanded = sidebarWrapper.classList.contains('expanded');
                toggleIcon.classList.remove('bi-chevron-left', 'bi-chevron-right');
                toggleIcon.classList.add(isExpanded ? 'bi-chevron-left' : 'bi-chevron-right');

                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', String(isExpanded));
                    toggleBtn.setAttribute('title', isExpanded ? 'Tutup Sidebar' : 'Buka Sidebar');
                }
            };

            if (sidebarWrapper && toggleBtn) {
                const isExpanded = localStorage.getItem('admin_sidebar_expanded') === 'true';

                if (isExpanded) {
                    sidebarWrapper.classList.add('expanded');
                }

                syncSidebarToggleIcon();

                toggleBtn.addEventListener('click', function() {
                    sidebarWrapper.classList.toggle('expanded');
                    const currentState = sidebarWrapper.classList.contains('expanded');
                    localStorage.setItem('admin_sidebar_expanded', currentState);
                    syncSidebarToggleIcon();
                });
            }
        });
    </script>

    <!-- Script Toggle Mode Terang/Gelap -->
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
                        title: "Keluar dari sistem?",
                        text: "Anda akan dipindahkan ke halaman login setelah logout.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4c87ba",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, keluar",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }

            const navbarLogoutForm = document.getElementById('logout-navbar-form');
            if (navbarLogoutForm) {
                navbarLogoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Keluar dari sistem?",
                        text: "Anda akan dipindahkan ke halaman login setelah logout.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4c87ba",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, keluar",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            navbarLogoutForm.submit();
                        }
                    });
                });
            }

            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: "{!! session('success') !!}",
                    icon: "success",
                    confirmButtonColor: "#4c87ba"
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: "Gagal!",
                    text: "{!! session('error') !!}",
                    icon: "error",
                    confirmButtonColor: "#4c87ba"
                });
            @endif

            // Menutup pop-up modal ketika mengklik area di luar dialog modal
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                    const modalInstance = bootstrap.Modal.getInstance(e.target);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });
        });
    </script>

    @vite(['resources/js/editor.js'])
    @stack('scripts')
    @yield('scripts')
</body>

</html>
