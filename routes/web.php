<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\AplikasiDinasController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananPublikController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\EditorUploadController;


use App\Http\Controllers\SaranaPrasaranaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('track.visitor')->group(function () {

    // Halaman Utama & Statis
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/halaman/{slug}', [HomeController::class, 'showPage'])->name('page.show');

    // Berita Public
    Route::get('semua/berita', [HomeController::class, 'semuaBerita'])
        ->name('frontend.berita.index');

    Route::get('detail/berita/{slug}', [HomeController::class, 'detailBerita'])
        ->name('frontend.berita.detail');

    // Sarana & Prasarana Public
    Route::get('semua/sarana-prasarana', [HomeController::class, 'semuaSaranaPrasarana'])
        ->name('frontend.sarana_prasarana.index');

    Route::get('detail/sarana-prasarana/{slug}', [HomeController::class, 'detailSaranaPrasarana'])
        ->name('frontend.sarana_prasarana.detail');

    // Galeri & Video Public
    Route::get('semua/galeri', [HomeController::class, 'semuaGaleri'])
        ->name('frontend.galeri.index');

    Route::get('detail/galeri/{slug}', [HomeController::class, 'detailGaleri'])
        ->name('frontend.galeri.detail');

    Route::get('semua/video', [HomeController::class, 'semuaVideo'])
        ->name('frontend.video.index');

    Route::get('detail/video/{slug}', [HomeController::class, 'detailVideo'])
        ->name('frontend.video.detail');

    // Agenda Public
    Route::get('semua/agenda', [HomeController::class, 'semuaAgenda'])
        ->name('frontend.agenda.index');

    Route::get('detail/agenda/{slug}', [HomeController::class, 'detailAgenda'])
        ->name('frontend.agenda.detail');
});

Route::middleware(['auth', 'check.active'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // ========================================================================
    // MANAJEMEN KONTEN & DATA (Per Menu Permission)
    // ========================================================================
    
    // Berita Routes
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // OPD Routes
    Route::get('/opd', [OpdController::class, 'index'])->name('opd.index');
    Route::get('/opd/create', [OpdController::class, 'create'])->name('opd.create');
    Route::post('/opd', [OpdController::class, 'store'])->name('opd.store');
    Route::get('/opd/{opd}', [OpdController::class, 'show'])->name('opd.show');
    Route::get('/opd/{opd}/edit', [OpdController::class, 'edit'])->name('opd.edit');
    Route::put('/opd/{opd}', [OpdController::class, 'update'])->name('opd.update');
    Route::delete('/opd/{opd}', [OpdController::class, 'destroy'])->name('opd.destroy');

    // Kecamatan Routes
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::get('/kecamatan/create', [KecamatanController::class, 'create'])->name('kecamatan.create');
    Route::post('/kecamatan', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::get('/kecamatan/{kecamatan}', [KecamatanController::class, 'show'])->name('kecamatan.show');
    Route::get('/kecamatan/{kecamatan}/edit', [KecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::put('/kecamatan/{kecamatan}', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{kecamatan}', [KecamatanController::class, 'destroy'])->name('kecamatan.destroy');

    // Aplikasi Dinas Routes
    Route::get('/aplikasi-dinas', [AplikasiDinasController::class, 'index'])->name('aplikasi-dinas.index');
    Route::get('/aplikasi-dinas/create', [AplikasiDinasController::class, 'create'])->name('aplikasi-dinas.create');
    Route::post('/aplikasi-dinas', [AplikasiDinasController::class, 'store'])->name('aplikasi-dinas.store');
    Route::get('/aplikasi-dinas/{aplikasiDinas}', [AplikasiDinasController::class, 'show'])->name('aplikasi-dinas.show');
    Route::get('/aplikasi-dinas/{aplikasiDinas}/edit', [AplikasiDinasController::class, 'edit'])->name('aplikasi-dinas.edit');
    Route::put('/aplikasi-dinas/{aplikasiDinas}', [AplikasiDinasController::class, 'update'])->name('aplikasi-dinas.update');
    Route::delete('/aplikasi-dinas/{aplikasiDinas}', [AplikasiDinasController::class, 'destroy'])->name('aplikasi-dinas.destroy');

    // Layanan Publik Routes
    Route::get('/layanan-publik', [LayananPublikController::class, 'index'])->name('layanan-publik.index');
    Route::get('/layanan-publik/create', [LayananPublikController::class, 'create'])->name('layanan-publik.create');
    Route::post('/layanan-publik', [LayananPublikController::class, 'store'])->name('layanan-publik.store');
    Route::get('/layanan-publik/{layananPublik}', [LayananPublikController::class, 'show'])->name('layanan-publik.show');
    Route::get('/layanan-publik/{layananPublik}/edit', [LayananPublikController::class, 'edit'])->name('layanan-publik.edit');
    Route::put('/layanan-publik/{layananPublik}', [LayananPublikController::class, 'update'])->name('layanan-publik.update');
    Route::delete('/layanan-publik/{layananPublik}', [LayananPublikController::class, 'destroy'])->name('layanan-publik.destroy');

    // Pengumuman Routes
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Agenda Routes
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{agenda}', [AgendaController::class, 'show'])->name('agenda.show');
    Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/agenda/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    
    // Dokumentasi Routes
    Route::get('/dokumentasi', [\App\Http\Controllers\DokumentasiController::class, 'index'])->name('dokumentasi.index');
    Route::get('/dokumentasi/create', [\App\Http\Controllers\DokumentasiController::class, 'create'])->name('dokumentasi.create');
    Route::post('/dokumentasi', [\App\Http\Controllers\DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::get('/dokumentasi/{dokumentasi}', [\App\Http\Controllers\DokumentasiController::class, 'show'])->name('dokumentasi.show');
    Route::get('/dokumentasi/{dokumentasi}/edit', [\App\Http\Controllers\DokumentasiController::class, 'edit'])->name('dokumentasi.edit');
    Route::put('/dokumentasi/{dokumentasi}', [\App\Http\Controllers\DokumentasiController::class, 'update'])->name('dokumentasi.update');
    Route::delete('/dokumentasi/{dokumentasi}', [\App\Http\Controllers\DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');

    // Menu Routes
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Page Routes
    Route::get('/page', [PageController::class, 'index'])->name('page.index');
    Route::get('/page/create', [PageController::class, 'create'])->name('page.create');
    Route::post('/page', [PageController::class, 'store'])->name('page.store');
    Route::get('/page/{page}', [PageController::class, 'show'])->name('page.show');
    Route::get('/page/{page}/edit', [PageController::class, 'edit'])->name('page.edit');
    Route::put('/page/{page}', [PageController::class, 'update'])->name('page.update');
    Route::delete('/page/{page}', [PageController::class, 'destroy'])->name('page.destroy');

    // Sarana Prasarana Routes
    Route::get('/sarana-prasarana', [SaranaPrasaranaController::class, 'index'])->name('sarana-prasarana.index');
    Route::get('/sarana-prasarana/create', [SaranaPrasaranaController::class, 'create'])->name('sarana-prasarana.create');
    Route::post('/sarana-prasarana', [SaranaPrasaranaController::class, 'store'])->name('sarana-prasarana.store');
    Route::get('/sarana-prasarana/{saranaPrasarana}', [SaranaPrasaranaController::class, 'show'])->name('sarana-prasarana.show');
    Route::get('/sarana-prasarana/{saranaPrasarana}/edit', [SaranaPrasaranaController::class, 'edit'])->name('sarana-prasarana.edit');
    Route::put('/sarana-prasarana/{saranaPrasarana}', [SaranaPrasaranaController::class, 'update'])->name('sarana-prasarana.update');
    Route::delete('/sarana-prasarana/{saranaPrasarana}', [SaranaPrasaranaController::class, 'destroy'])->name('sarana-prasarana.destroy');

    // Editor Uploads (Dapat diakses oleh siapa saja yang bisa masuk admin)
    Route::post('/editor/upload-image', [EditorUploadController::class, 'uploadImage'])->name('editor.upload-image');
    Route::post('/editor/upload-pdf', [EditorUploadController::class, 'uploadPdf'])->name('editor.upload-pdf');

    // ========================================================================
    // MANAJEMEN SISTEM (User, Role, Activity Log)
    // ========================================================================

    // User Management
    Route::prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::put('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Role Management
        Route::resource('roles', RoleController::class)->except(['show']);

        // Activity Log
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});
