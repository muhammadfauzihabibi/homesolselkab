<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Opd;
use App\Models\AplikasiDinas;
use App\Models\Dokumentasi;
use App\Models\LayananPublik;
use App\Models\Menu;
use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Models\Unduhan;
use App\Models\Page;
use App\Models\Poster;
use App\Models\SaranaPrasarana;
use App\Models\KategoriUnduhan;
use App\Models\JenisUnduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Mengambil data kependudukan & demografi real-time dari API SIMSALABIM
     */
    public static function fetchSimsalabimData($forceFresh = false)
    {
        $cacheKey = 'simsalabim_realtime_data_v1';

        if (!$forceFresh && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $geoMetadata = [
            1 => ['name' => 'Kecamatan Sangir', 'area' => '632,99 km²', 'luas_num' => 632.99, 'nagari' => 7, 'kategori' => 'Kategori Sangat Tinggi'],
            5 => ['name' => 'Kecamatan Sungai Pagu', 'area' => '144,38 km²', 'luas_num' => 144.38, 'nagari' => 11, 'kategori' => 'Kategori Sangat Tinggi'],
            7 => ['name' => 'Kecamatan Koto Parik Gadang Diateh', 'area' => '442,16 km²', 'luas_num' => 442.16, 'nagari' => 8, 'kategori' => 'Kategori Tinggi'],
            2 => ['name' => 'Kecamatan Sangir Jujuan', 'area' => '277,15 km²', 'luas_num' => 277.15, 'nagari' => 5, 'kategori' => 'Kategori Aktif'],
            4 => ['name' => 'Kecamatan Sangir Batang Hari', 'area' => '280,00 km²', 'luas_num' => 280.00, 'nagari' => 7, 'kategori' => 'Kategori Aktif'],
            6 => ['name' => 'Kecamatan Pauh Duo', 'area' => '312,81 km²', 'luas_num' => 312.81, 'nagari' => 5, 'kategori' => 'Kategori Tinggi'],
            3 => ['name' => 'Kecamatan Sangir Balai Janggo', 'area' => '1.256,71 km²', 'luas_num' => 1256.71, 'nagari' => 4, 'kategori' => 'Kategori Aktif'],
        ];

        try {
            $response = Http::timeout(5)->withoutVerifying()->get('https://simsalabim.solselkab.go.id/chart-data?level=kecamatan');
            if ($response->successful()) {
                $rawKecamatan = $response->json();

                $totalWarga = 0;
                $totalRumah = 0;
                $totalKk = 0;
                $totalDasawisma = 0;
                $kecamatanMap = [];

                foreach ($rawKecamatan as $item) {
                    $id = (int) $item['id'];
                    $meta = $geoMetadata[$id] ?? [
                        'name' => 'Kecamatan ' . ucwords(strtolower($item['name'])),
                        'area' => '- km²',
                        'luas_num' => 1,
                        'nagari' => 5,
                        'kategori' => 'Kategori Aktif'
                    ];

                    $warga = (int) ($item['warga'] ?? 0);
                    $rumah = (int) ($item['rumah'] ?? 0);
                    $kk = (int) ($item['kk'] ?? 0);
                    $dasawisma = (int) ($item['dasawisma'] ?? 0);

                    $totalWarga += $warga;
                    $totalRumah += $rumah;
                    $totalKk += $kk;
                    $totalDasawisma += $dasawisma;

                    $density = $meta['luas_num'] > 0 ? number_format($warga / $meta['luas_num'], 2, ',', '.') . ' Jiwa/km²' : '-';

                    $kecamatanMap[(string) $id] = [
                        'id' => $id,
                        'name' => $meta['name'],
                        'shortTitle' => 'Kecamatan',
                        'area' => $meta['area'],
                        'warga' => $warga,
                        'rumah' => $rumah,
                        'kk' => $kk,
                        'dasawisma' => $dasawisma,
                        'nagari' => $meta['nagari'],
                        'kategori' => $meta['kategori'],
                        'density' => $density,
                    ];
                }

                $totalArea = '3.346 hingga 3.346 km²';
                $totalDensity = number_format($totalWarga / 3346.20, 2, ',', '.') . ' Jiwa/km²';

                $result = [
                    'all' => [
                        'id' => 'all',
                        'name' => 'Kabupaten Solok Selatan',
                        'shortTitle' => 'Keseluruhan Wilayah',
                        'area' => $totalArea,
                        'warga' => $totalWarga,
                        'rumah' => $totalRumah,
                        'kk' => $totalKk,
                        'dasawisma' => $totalDasawisma,
                        'nagari' => 47,
                        'kategori' => 'Kategori Sangat Tinggi',
                        'density' => $totalDensity,
                    ],
                    'updated_at' => now()->translatedFormat('d M Y, H:i:s') . ' WIB',
                    'timestamp' => now()->timestamp,
                    'source' => 'SIMSALABIM Live'
                ];

                foreach ($kecamatanMap as $k => $v) {
                    $result[$k] = $v;
                }

                // Cache 60 detik untuk menjamin update cepat bila ada perubahan di SIMSALABIM
                Cache::put($cacheKey, $result, now()->addSeconds(60));
                Cache::forever('simsalabim_backup_data', $result);

                return $result;
            }
        } catch (\Throwable $e) {
            Log::warning('SIMSALABIM live fetch failed: ' . $e->getMessage());
        }

        return Cache::get('simsalabim_backup_data', static::getFallbackSimsalabimData());
    }

    /**
     * Fallback data jika server SIMSALABIM sedang tidak terjangkau
     */
    protected static function getFallbackSimsalabimData()
    {
        return [
            'all' => [
                'id' => 'all',
                'name' => 'Kabupaten Solok Selatan',
                'shortTitle' => 'Keseluruhan Wilayah',
                'area' => '3.346 hingga 3.346 km²',
                'warga' => 160468,
                'rumah' => 47617,
                'kk' => 47363,
                'dasawisma' => 2695,
                'nagari' => 47,
                'kategori' => 'Kategori Sangat Tinggi',
                'density' => '47,96 Jiwa/km²'
            ],
            '1' => ['id' => 1, 'name' => 'Kecamatan Sangir', 'shortTitle' => 'Kecamatan', 'area' => '632,99 km²', 'warga' => 41512, 'rumah' => 12147, 'kk' => 11989, 'dasawisma' => 681, 'nagari' => 7, 'kategori' => 'Kategori Sangat Tinggi', 'density' => '65,58 Jiwa/km²'],
            '5' => ['id' => 5, 'name' => 'Kecamatan Sungai Pagu', 'shortTitle' => 'Kecamatan', 'area' => '144,38 km²', 'warga' => 30487, 'rumah' => 9226, 'kk' => 9231, 'dasawisma' => 528, 'nagari' => 11, 'kategori' => 'Kategori Sangat Tinggi', 'density' => '211,16 Jiwa/km²'],
            '7' => ['id' => 7, 'name' => 'Kecamatan Koto Parik Gadang Diateh', 'shortTitle' => 'Kecamatan', 'area' => '442,16 km²', 'warga' => 24084, 'rumah' => 7467, 'kk' => 7276, 'dasawisma' => 407, 'nagari' => 8, 'kategori' => 'Kategori Tinggi', 'density' => '54,47 Jiwa/km²'],
            '2' => ['id' => 2, 'name' => 'Kecamatan Sangir Jujuan', 'shortTitle' => 'Kecamatan', 'area' => '277,15 km²', 'warga' => 13484, 'rumah' => 3772, 'kk' => 4137, 'dasawisma' => 220, 'nagari' => 5, 'kategori' => 'Kategori Aktif', 'density' => '48,65 Jiwa/km²'],
            '4' => ['id' => 4, 'name' => 'Kecamatan Sangir Batang Hari', 'shortTitle' => 'Kecamatan', 'area' => '280,00 km²', 'warga' => 15467, 'rumah' => 3868, 'kk' => 4540, 'dasawisma' => 223, 'nagari' => 7, 'kategori' => 'Kategori Aktif', 'density' => '55,24 Jiwa/km²'],
            '6' => ['id' => 6, 'name' => 'Kecamatan Pauh Duo', 'shortTitle' => 'Kecamatan', 'area' => '312,81 km²', 'warga' => 18582, 'rumah' => 5107, 'kk' => 5300, 'dasawisma' => 288, 'nagari' => 5, 'kategori' => 'Kategori Tinggi', 'density' => '59,40 Jiwa/km²'],
            '3' => ['id' => 3, 'name' => 'Kecamatan Sangir Balai Janggo', 'shortTitle' => 'Kecamatan', 'area' => '1.256,71 km²', 'warga' => 16852, 'rumah' => 6030, 'kk' => 4890, 'dasawisma' => 348, 'nagari' => 4, 'kategori' => 'Kategori Aktif', 'density' => '13,41 Jiwa/km²'],
            'updated_at' => 'Cached',
            'timestamp' => time(),
            'source' => 'SIMSALABIM Cache'
        ];
    }

    /**
     * Endpoint API JSON publik untuk polling realtime frontend
     */
    public function getSimsalabimApi(Request $request)
    {
        $data = static::fetchSimsalabimData($request->boolean('fresh'));
        return response()->json($data);
    }

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

        $posters = Poster::where('aktif', true)
            ->orderByDesc('tanggal_publikasi')
            ->take(6)
            ->get();

        $opds = Opd::where('aktif', true)
            ->orderBy('nama')
            ->get();

        $aplikasis = AplikasiDinas::where('aktif', true)
            ->latest()
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
            ->latest()
            ->get();

        // Menggunakan kolom 'end_date' agar agenda yang sedang berlangsung tetap muncul
        $agendas = Agenda::where('aktif', true)
            ->where('end_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(4)
            ->get();

        $pengumumen = Pengumuman::where('aktif', true)
            ->latest()
            ->take(4)
            ->get();

        $unduhans = Unduhan::where('aktif', true)
            ->with(['kategoriUnduhan', 'jenisUnduhan'])
            ->latest()
            ->get();

        $unduhanKategoris = KategoriUnduhan::with([
            'jenisUnduhans' => function ($query) {
                $query->aktif()->ordered();
            },
        ])
            ->withCount(['unduhans' => function ($query) {
                $query->where('aktif', true);
            }])
            ->aktif()
            ->ordered()
            ->get();

        $unduhanJenises = JenisUnduhan::with('kategoriUnduhan')
            ->withCount(['unduhans' => function ($query) {
                $query->where('aktif', true);
            }])
            ->where('aktif', true)
            ->orderBy('urutan')
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

        // Ambil data kependudukan real-time dari SIMSALABIM
        $simsalabimData = static::fetchSimsalabimData();

        return view('frontend.index', compact(
            'menus',
            'beritas',
            'posters',
            'beritaTerpopuler',
            'opds',
            'aplikasis',
            'saranaPrasaranas',
            'videos',
            'galeris',
            'layanans',
            'agendas',
            'pengumumen',
            'unduhans',
            'unduhanKategoris',
            'unduhanJenises',
            'simsalabimData'
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

        $agendas = Agenda::where('aktif', true)
            ->where('end_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(4)
            ->get();

        $pengumumen = Pengumuman::where('aktif', true)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.page', compact('page', 'agendas', 'pengumumen'));
    }

    /**
     * Halaman Semua Berita
     */
    public function semuaBerita()
    {
        $beritas = Berita::where('terbit', true)
            ->orderByDesc('tanggal_terbit')
            ->paginate(9);

        return view('frontend.berita.index', compact('beritas'));
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
     * Halaman Semua Poster Digital
     */
    public function semuaPoster()
    {
        $posters = Poster::where('aktif', true)
            ->orderByDesc('tanggal_publikasi')
            ->paginate(9);

        return view('frontend.poster.index', compact('posters'));
    }

    /**
     * Halaman Detail Poster Digital
     */
    public function detailPoster($slug)
    {
        $poster = Poster::where('aktif', true)->where('slug', $slug)->firstOrFail();

        $sessionKey = 'viewed_poster_' . $poster->id;
        if (!session()->has($sessionKey)) {
            $poster->increment('views_count');
            session()->put($sessionKey, true);
        }

        $posterTerpopuler = Poster::where('aktif', true)
            ->where('id', '!=', $poster->id)
            ->orderByDesc('views_count')
            ->orderByDesc('tanggal_publikasi')
            ->take(5)
            ->get();

        return view('frontend.poster.detail', compact('poster', 'posterTerpopuler'));
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
     * Halaman Semua Pengumuman
     */
    public function semuaPengumuman()
    {
        $pengumumen = Pengumuman::where('aktif', true)
            ->latest()
            ->paginate(10);

        return view('frontend.pengumuman.index', compact('pengumumen'));
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

    /**
     * Halaman Detail Pengumuman
     */
    public function detailPengumuman($slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        return view('frontend.pengumuman.detail', compact('pengumuman'));
    }
}
