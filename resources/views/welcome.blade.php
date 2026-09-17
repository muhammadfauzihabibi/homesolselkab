<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Layanan Utama - Pemda Kabupaten Solok Selatan</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Frost UI Dark Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/frostui.css') }}">
    
    <style>
        .welcome-wrapper {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            z-index: 1;
        }

        .frost-navbar {
            background: var(--frost-card-bg);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid var(--frost-card-border);
            border-radius: 24px;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
            box-shadow: var(--frost-card-shadow);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .brand-logo img {
            height: 48px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        .brand-title {
            font-family: var(--font-heading);
            font-size: 18px;
            font-weight: 800;
            color: var(--frost-text-main);
            letter-spacing: -0.2px;
        }

        .brand-sub {
            font-size: 11px;
            color: #34d399;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .frost-hero {
            background: var(--frost-card-bg);
            backdrop-filter: blur(28px) saturate(190%);
            -webkit-backdrop-filter: blur(28px) saturate(190%);
            border: 1px solid var(--frost-card-border);
            border-radius: 32px;
            padding: 48px 40px;
            box-shadow: var(--frost-card-shadow);
            margin-bottom: 36px;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 700;
            color: #34d399;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        .hero-title {
            font-family: var(--font-heading);
            font-size: 38px;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .hero-desc {
            font-size: 16px;
            color: var(--frost-text-muted);
            max-width: 680px;
            margin: 0 auto 32px;
            line-height: 1.6;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .service-card {
            background: var(--frost-card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--frost-card-border);
            border-radius: 24px;
            padding: 30px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: rgba(16, 185, 129, 0.4);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5), 0 0 25px rgba(16, 185, 129, 0.2);
        }

        .service-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #34d399;
            margin-bottom: 20px;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.2);
        }

        .service-title {
            font-family: var(--font-heading);
            font-size: 19px;
            font-weight: 700;
            color: var(--frost-text-main);
            margin-bottom: 8px;
        }

        .service-desc {
            font-size: 13.5px;
            color: var(--frost-text-muted);
            line-height: 1.5;
        }

        .user-welcome-box {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 20px;
            padding: 16px 24px;
            display: inline-flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <!-- Frost Aurora Background -->
    <div class="frost-bg-aurora">
        <div class="aurora-blob blob-1"></div>
        <div class="aurora-blob blob-2"></div>
        <div class="aurora-blob blob-3"></div>
        <div class="aurora-blob blob-4"></div>
    </div>

    <div class="welcome-wrapper">
        <!-- Frost Navigation Bar -->
        <nav class="frost-navbar">
            <a href="{{ url('/') }}" class="brand-logo">
                <img src="{{ asset('images/lambangsolsel.png') }}" alt="Logo Pemda Solsel" onerror="this.src='{{ asset('images/logo.png') }}'">
                <div>
                    <div class="brand-title">Pemda Solok Selatan</div>
                    <div class="brand-sub">Saluak Sekata Barat Daya</div>
                </div>
            </a>
            
            <div class="nav-actions">
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="frost-link-pill" style="border:none; cursor:pointer;">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="frost-link-pill">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="frost-btn frost-btn-primary" style="padding: 8px 20px; font-size: 13.5px; width: auto;">
                        <i class="fa-solid fa-user-plus"></i> Daftar
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Hero Card -->
        <section class="frost-hero">
            @auth
                <div class="user-welcome-box">
                    <i class="fa-solid fa-circle-user" style="font-size: 28px; color: #34d399;"></i>
                    <div style="text-align: left;">
                        <div style="font-size: 12px; color: #94a3b8; font-weight: 600;">Selamat Datang Kembali,</div>
                        <div style="font-size: 17px; font-weight: 800; color: #ffffff;">{{ Auth::user()->name }} ({{ Auth::user()->username }})</div>
                    </div>
                </div>
            @endauth

            <div class="hero-badge">
                <i class="fa-solid fa-sparkles"></i> Frost UI Dark Experience
            </div>
            
            <h1 class="hero-title">Portal Layanan Terpadu Kabupaten Solok Selatan</h1>
            <p class="hero-desc">
                Selamat datang di portal pelayanan digital terintegrasi Pemerintah Kabupaten Solok Selatan. Akses informasi publik, administrasi kepegawaian, dan perizinan secara cepat, aman, dan modern.
            </p>

            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                @auth
                    <a href="#" class="frost-btn frost-btn-primary" style="width: auto; padding: 14px 32px;">
                        <i class="fa-solid fa-gauge-high"></i> Buka Dashboard Utama
                    </a>
                @else
                    <a href="{{ route('login') }}" class="frost-btn frost-btn-primary" style="width: auto; padding: 14px 32px;">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Akun Saya
                    </a>
                    <a href="{{ route('register') }}" class="frost-link-pill" style="padding: 14px 28px; font-size: 14.5px;">
                        <i class="fa-solid fa-user-plus"></i> Buat Akun Portal
                    </a>
                @endauth
            </div>
        </section>

        <!-- Services Grid -->
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><i class="fa-solid fa-building-columns"></i></div>
                <h2 class="service-title">Layanan Pemerintahan</h2>
                <p class="service-desc">Integrasi data antar dinas dan tata kelola administrasi daerah transparan.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fa-solid fa-file-signature"></i></div>
                <h2 class="service-title">Perizinan Online</h2>
                <p class="service-desc">Permohonan izin usaha dan publik terverifikasi secara digital dan cepat.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fa-solid fa-bullhorn"></i></div>
                <h2 class="service-title">Pengaduan Masyarakat</h2>
                <p class="service-desc">Sampaikan aspirasi dan laporan publik langsung ke OPD terkait.</p>
            </div>
        </div>
    </div>
</body>
</html>
