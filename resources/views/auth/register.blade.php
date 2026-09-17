@extends('layouts.auth')

@section('title', 'Registrasi - Pemda Kabupaten Solok Selatan')

@section('top-nav')
    <span class="fs-8 text-muted-custom">
        Sudah memiliki akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #10b981;">Masuk</a>
    </span>
@endsection

@section('content')
<div class="mb-4">
    <h2 class="h3 fw-extrabold mb-1 text-main">Daftar Akun Baru</h2>
    <p class="text-muted-custom fs-7 mb-0">Lengkapi formulir di bawah ini untuk membuat akun portal Pemda Solsel.</p>
</div>

<!-- Flash Message Errors -->
@if($errors->any())
    <div class="alert glass-card border-0 text-danger alert-dismissible fade show rounded-4 p-3 shadow-sm mb-4" role="alert" style="background: rgba(239, 68, 68, 0.15);">
        <div class="d-flex align-items-center fs-7">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
            <span>Silakan periksa kembali data yang Anda masukkan.</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf

    <!-- Nama Lengkap -->
    <div class="mb-3">
        <label for="name" class="form-label fw-bold fs-7 text-main">Nama Lengkap <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                <i class="bi bi-person-badge"></i>
            </span>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('name') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                   placeholder="Nama Lengkap beserta Gelar"
                   value="{{ old('name') }}"
                   required
                   autofocus>
        </div>
        @error('name')
            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Username -->
    <div class="mb-3">
        <label for="username" class="form-label fw-bold fs-7 text-main">Username <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                <i class="bi bi-person"></i>
            </span>
            <input type="text"
                   name="username"
                   id="username"
                   class="form-control border-0 py-2.5 px-3 fs-7 @error('username') is-invalid @enderror"
                   style="background: var(--card-sub-bg); color: var(--text-dark); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                   placeholder="Masukkan Username"
                   value="{{ old('username') }}"
                   required>
        </div>
        @error('username')
            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kata Sandi -->
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
                   placeholder="Minimal 6 Karakter"
                   required>
            <button class="btn border-0 ps-2 pe-3"
                    type="button"
                    style="background: var(--card-sub-bg); color: var(--text-muted); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                    onclick="togglePassword('password', 'toggleIcon1')"
                    title="Tampilkan/Sembunyikan Kata Sandi">
                <i class="bi bi-eye" id="toggleIcon1"></i>
            </button>
        </div>
        @error('password')
            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Konfirmasi Kata Sandi -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-bold fs-7 text-main">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text border-0 ps-3" style="background: var(--card-sub-bg); color: var(--text-muted); border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                <i class="bi bi-shield-lock"></i>
            </span>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="form-control border-0 py-2.5 px-3 fs-7"
                   style="background: var(--card-sub-bg); color: var(--text-dark);"
                   placeholder="Ulangi Kata Sandi"
                   required>
            <button class="btn border-0 ps-2 pe-3"
                    type="button"
                    style="background: var(--card-sub-bg); color: var(--text-muted); border-top-right-radius: 16px; border-bottom-right-radius: 16px;"
                    onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                    title="Tampilkan/Sembunyikan Kata Sandi">
                <i class="bi bi-eye" id="toggleIcon2"></i>
            </button>
        </div>
    </div>

    <!-- Terms Checkbox -->
    <div class="form-check d-flex align-items-center gap-2 ps-0 mb-4 fs-7">
        <input class="form-check-input ms-0 mt-0" type="checkbox" name="terms" id="terms" style="width: 1.2em; height: 1.2em;" required checked>
        <label class="form-check-label text-muted-custom fw-semibold" for="terms">
            Saya menyetujui Ketentuan Layanan & Kebijakan Privasi
        </label>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-dark-pill w-100 py-2.5 fs-7 d-flex align-items-center justify-content-center gap-2">
        <span>Daftar Akun</span>
        <i class="bi bi-person-plus"></i>
    </button>
</form>
@endsection
