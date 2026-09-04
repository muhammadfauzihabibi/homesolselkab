<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Opd;
use App\Models\AplikasiDinas;
use App\Models\Dokumentasi;
use App\Models\LayananPublik;
use App\Models\Menu;
use App\Models\Agenda;
use App\Models\Page;
use App\Models\SaranaPrasarana;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Halaman Utama / Homepage
     */
    public function index()
    {
        // Ambil 3 berita terbaru untuk halaman beranda
        $beritas = Berita::where('terbit', true)
            ->orderByDesc('tanggal_terbit')
            ->take(9)
            ->get();

        $opds = Opd::where('aktif', true)
            ->orderBy('nama')
            ->get();

        $aplikasis = AplikasiDinas::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        $saranaPrasaranas = SaranaPrasarana::where('status_operasional', '!=', 'Tidak Beroperasi')
            ->latest()
            ->take(10)
            ->get();

        $videos = Dokumentasi::where('tipe', 'video')
            ->latest()
            ->take(4)
            ->get();

        $galeris = Dokumentasi::where('tipe', 'gambar')
            ->latest()
            ->take(8)
            ->get();

        $layanans = LayananPublik::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // Menggunakan kolom 'end_date' agar agenda yang sedang berlangsung tetap muncul
        $agendas = Agenda::where('aktif', true)
            ->where('end_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(4)
            ->get();

        $menus = Menu::with([
            'page' => function ($query) {
                $query->where('aktif', true)
                    ->orderBy('judul');
            }
        ])
        ->whereNull('parent_id')
        ->where('aktif', true)
        ->orderBy('urutan')
        ->get();

        // Ambil 5 berita terpopuler berdasarkan jumlah tayangan/klik
        $beritaTerpopuler = Berita::terpopuler(5)->get();

        return view('frontend.index', compact(
            'menus',
            'beritas',
            'beritaTerpopuler',
            'opds',
            'aplikasis',
            'saranaPrasaranas',
            'videos',
            'galeris',
            'layanans',
            'agendas'
        ));
    }

    /**
     * Halaman Statis / Custom Page
     */
    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        return view('frontend.page', compact('page'));
    }

    /**
     * Halaman Semua Berita
     */
    public function semuaBerita()
    {
        $beritas = Berita::where('terbit', true)
            ->orderByDesc('tanggal_terbit')
            ->paginate(9);

        $beritaTerpopuler = Berita::terpopuler(5)->get();

        return view('frontend.berita.index', compact('beritas', 'beritaTerpopuler'));
    }

    /**
     * Halaman Detail Berita
     */
    public function detailBerita($slug)
    {
        $berita = Berita::where('terbit', true)->where('slug', $slug)->firstOrFail();

        // Increment views_count (menggunakan session agar tidak spam per session view)
        $sessionKey = 'viewed_berita_' . $berita->id;
        if (!session()->has($sessionKey)) {
            $berita->increment('views_count');
            session()->put($sessionKey, true);
        }

        // Ambil 5 Berita Terpopuler lainnya
        $beritaTerpopuler = Berita::terpopuler(5)
            ->where('id', '!=', $berita->id)
            ->get();

        return view('frontend.berita.detail', compact('berita', 'beritaTerpopuler'));
    }

    /**
     * Halaman Semua Sarana & Prasarana (Public Catalog)
     */
    public function semuaSaranaPrasarana(Request $request)
    {
        $query = SaranaPrasarana::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('sub_kategori', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('alamat_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->input('kecamatan'));
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->input('kondisi'));
        }

        $items = $query->latest('id')->paginate(12)->withQueryString();
        $kategoris = SaranaPrasarana::distinct()->pluck('kategori')->filter();
        $kecamatans = SaranaPrasarana::distinct()->pluck('kecamatan')->filter();

        return view('frontend.sarana_prasarana.index', compact('items', 'kategoris', 'kecamatans'));
    }

    /**
     * Halaman Detail Sarana & Prasarana (Public Detail)
     */
    public function detailSaranaPrasarana($slug)
    {
        $item = SaranaPrasarana::where('slug', $slug)->firstOrFail();

        $relatedItems = SaranaPrasarana::where('id', '!=', $item->id)
            ->where('kategori', $item->kategori)
            ->take(4)
            ->get();

        return view('frontend.sarana_prasarana.detail', compact('item', 'relatedItems'));
    }

    /**
     * Halaman Semua Galeri Foto
     */
    public function semuaGaleri()
    {
        $galeris = Dokumentasi::where('tipe', 'gambar')
            ->latest()
            ->paginate(12);

        return view('frontend.galeri.index', compact('galeris'));
    }

    /**
     * Halaman Semua Video
     */
    public function semuaVideo()
    {
        $videos = Dokumentasi::where('tipe', 'video')
            ->latest()
            ->paginate(9);

        return view('frontend.video.index', compact('videos'));
    }

    /**
     * Halaman Semua Agenda
     */
    public function semuaAgenda()
    {
        $agendas = Agenda::where('aktif', true)
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('frontend.agenda.index', compact('agendas'));
    }

    /**
     * Halaman Detail Agenda
     */
    public function detailAgenda($slug)
    {
        $agenda = Agenda::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        return view('frontend.agenda.detail', compact('agenda'));
    }
}