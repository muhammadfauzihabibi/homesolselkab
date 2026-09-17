<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Opd;
use App\Models\Kecamatan;
use App\Models\AplikasiDinas;
use App\Models\Pengumuman;
use App\Models\LayananPublik;
use App\Models\Dokumentasi;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'berita' => Berita::count(),
            'layanan_publik' => LayananPublik::count(),
            'opd' => Opd::count(),
            'kecamatan' => Kecamatan::count(),
            'aplikasi_dinas' => AplikasiDinas::count(),
            'pengumuman' => Pengumuman::count(),
            'agenda' => Agenda::count(),
            'dokumentasi' => Dokumentasi::count(),
            'page' => Page::count(),
            'menu' => Menu::count(),
        ];

        $today = now()->toDateString();

        $agendas = Agenda::where('aktif', 1)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // Statistik berita per bulan tahun ini
        $beritaBulanan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $beritaBulanan[] = Berita::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $bulan)
                ->count();
        }

        $totalVisitors = Visitor::count();

        $todayVisitors = Visitor::whereDate(
            'visited_at',
            today()
        )->count();

        $onlineVisitors = Visitor::where(
            'visited_at',
            '>=',
            now()->subMinutes(15)
        )->count();

        $browserStats = Visitor::select(
        'browser',
            DB::raw('count(*) as total')
        )
        ->groupBy('browser')
        ->orderByDesc('total')
        ->take(5)
        ->get();

        $deviceStats = Visitor::select(
            'device_type',
            DB::raw('count(*) as total')
        )
        ->groupBy('device_type')
        ->get();

        $visitorChart = Visitor::select(
            DB::raw('DATE(visited_at) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->whereDate(
            'visited_at',
            '>=',
            now()->subDays(30)
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        

    $visitorLabels = $visitorChart->pluck('date');
    $visitorData = $visitorChart->pluck('total');

        return view('admin.dashboard', compact(
            'counts',
            'agendas',
            'today',
            'beritaBulanan',

            'totalVisitors',
            'todayVisitors',
            'onlineVisitors',
            'browserStats',
            'deviceStats',
            'visitorLabels',
            'visitorData'
        ));
    }
}