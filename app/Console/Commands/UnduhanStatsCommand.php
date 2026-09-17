<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Unduhan;
use App\Models\KategoriUnduhan;

class UnduhanStatsCommand extends Command
{
    protected $signature = 'unduhan:stats 
                           {--top=10 : Number of top documents to show}
                           {--kategori= : Filter by kategori slug}';

    protected $description = 'Display download statistics for documents';

    public function handle()
    {
        $top = $this->option('top');
        $kategoriSlug = $this->option('kategori');

        $this->info('📊 Statistik Download Center');
        $this->line('');

        // Overall stats
        $totalDokumen = Unduhan::where('aktif', true)->count();
        $totalDownload = Unduhan::where('aktif', true)->sum('jumlah_unduhan');
        
        $this->line("Total Dokumen Aktif: <fg=green>{$totalDokumen}</>");
        $this->line("Total Download: <fg=green>" . number_format($totalDownload) . "</>");
        $this->line('');

        // Stats per kategori
        $this->line('📁 Statistik per Kategori:');
        $kategoris = KategoriUnduhan::withCount(['unduhans' => function($query) {
                $query->where('aktif', true);
            }])
            ->aktif()
            ->ordered()
            ->get();

        $headers = ['Kategori', 'Dokumen', 'Total Download'];
        $rows = [];

        foreach ($kategoris as $kategori) {
            $totalKategoriDownload = Unduhan::where('kategori_unduhan_id', $kategori->id)
                ->where('aktif', true)
                ->sum('jumlah_unduhan');
                
            $rows[] = [
                $kategori->nama,
                $kategori->unduhans_count,
                number_format($totalKategoriDownload ?: 0)
            ];
        }

        $this->table($headers, $rows);
        $this->line('');

        // Top downloaded documents
        $query = Unduhan::with(['kategoriUnduhan', 'jenisUnduhan'])
            ->where('aktif', true)
            ->orderByDesc('jumlah_unduhan');

        if ($kategoriSlug) {
            $query->whereHas('kategoriUnduhan', function($q) use ($kategoriSlug) {
                $q->where('slug', $kategoriSlug);
            });
            $this->line("🏆 Top {$top} Dokumen Terpopuler - Kategori: {$kategoriSlug}");
        } else {
            $this->line("🏆 Top {$top} Dokumen Terpopuler:");
        }

        $topDokumen = $query->take($top)->get();

        $headers = ['Judul', 'Kategori', 'Jenis', 'Download'];
        $rows = [];

        foreach ($topDokumen as $dokumen) {
            $rows[] = [
                \Str::limit($dokumen->judul ?: $dokumen->title, 40),
                $dokumen->kategoriUnduhan?->nama ?: '-',
                $dokumen->jenisUnduhan?->nama ?: '-',
                number_format($dokumen->jumlah_unduhan ?: 0)
            ];
        }

        if (empty($rows)) {
            $this->warn('Tidak ada data dokumen ditemukan.');
        } else {
            $this->table($headers, $rows);
        }

        $this->line('');
        $this->info('✅ Statistik berhasil ditampilkan');
        
        return 0;
    }
}