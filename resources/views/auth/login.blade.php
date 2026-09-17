@extends('layouts.auth')

@section('title', 'Login - Pemda Kabupaten Solok Selatan')

@section('top-nav')
    <span class="fs-8 text-muted-custom">
        Belum memiliki akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #10b981;">Daftar</a>
    </span>
@endsection

@section('content')
<div class="mb-4">
    <h2 class="h3 fw-extrabold mb-1 text-main">Masuk ke Portal</h2>
    <p class="text-muted-custom fs-7 mb-0">Silakan masukkan username/NIP dan kata sandi Anda untuk mengakses akun.</p>
</div>

<!-- Flash Message Success -->
@if(session('success'))
    <div class="alert glass-card border-0 text-success alert-dismissible fade show rounded-4 p-3 shadow-sm mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15);">
        <div class="d-flex align-items-center fs-7">
            <i class="bi bi-check-circle-fill me-2 fs-6"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Flash Message Errors -->
@if($errors->any())
    <div class="alert glass-card border-0 text-danger alert-dismissible fade show rounded-4 p-3 shadow-sm mb-4" role="alert" style="background: rgba(239, 68, 68, 0.15);">
        <div class="d-flex align-items-center fs-7">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <!-- Username / NIP -->
    <div class="mb-3">
        <label for="username" class="form-label fw-bold fs-7 text-main">Username / NIP <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                <i class="bi bi-person"></i>
            </span>
            <input type="text"
                   name="username"
                   id="username"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('username') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                   placeholder="Masukkan Username atau NIP"
                   value="{{ old('username') }}"
                   required
                   autofocus>
        </div>
        @error('username')
            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label fw-bold fs-7 text-main">Kata Sandi <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password"
                   name="password"
                   id="password"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('password') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark);"
                   placeholder="Masukkan Kata Sandi"
                   required>
            <button class="btn border-0 ps-2 pe-3"
                    type="button"
                    style="background: var(--card-sub-bg); color: var(--text-muted); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                    onclick="togglePassword('password', 'toggleIcon')"
                    title="Tampilkan/Sembunyikan Kata Sandi">
                <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Options: Remember Me & Forgot Password -->
    <div class="d-flex justify-content-between align-items-center mb-4 fs-7">
        <div class="form-check d-flex align-items-center gap-2 ps-0">
            <input class="form-check-input ms-0 mt-0" type="checkbox" name="remember" id="remember" style="width: 1.2em; height: 1.2em;" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label text-muted-custom fw-semibold" for="remember">
                Ingat Saya
            </label>
        </div>
        <a href="#" class="text-decoration-none fw-semibold fs-8" style="color: #38bdf8;" onclick="alert('Silakan hubungi Diskominfo Solok Selatan untuk reset kata sandi.'); return false;">
            Lupa kata sandi?
        </a>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-dark-pill w-100 py-2.5 fs-7 d-flex align-items-center justify-content-center gap-2">
        <span>Masuk Sekarang</span>
        <i class="bi bi-arrow-right"></i>
    </button>
</form>
@endsection
