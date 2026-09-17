<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriUnduhan;
use App\Models\JenisUnduhan;

class KategoriJenisUnduhanSeeder extends Seeder
{
    public function run(): void
    {
        $dataKategori = [
            [
                'nama' => 'Anggaran',
                'slug' => 'anggaran',
                'deskripsi' => 'Dokumen anggaran daerah dan perencanaan keuangan',
                'icon' => 'bi-cash-coin',
                'urutan' => 1,
                'jenis' => [
                    ['nama' => 'SSH', 'slug' => 'ssh', 'deskripsi' => 'Standar Satuan Harga', 'urutan' => 1],
                    ['nama' => 'HSPK', 'slug' => 'hspk', 'deskripsi' => 'Harga Satuan Pokok Kegiatan', 'urutan' => 2],
                    ['nama' => 'ASB', 'slug' => 'asb', 'deskripsi' => 'Analisis Standar Belanja', 'urutan' => 3],
                    ['nama' => 'APBD', 'slug' => 'apbd', 'deskripsi' => 'Anggaran Pendapatan dan Belanja Daerah', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Laporan',
                'slug' => 'laporan',
                'deskripsi' => 'Laporan kinerja dan pertanggungjawaban pemerintah daerah',
                'icon' => 'bi-file-earmark-text',
                'urutan' => 2,
                'jenis' => [
                    ['nama' => 'IKPD', 'slug' => 'ikpd', 'deskripsi' => 'Indeks Kinerja Pemerintah Daerah', 'urutan' => 1],
                    ['nama' => 'LKPJ', 'slug' => 'lkpj', 'deskripsi' => 'Laporan Keterangan Pertanggungjawaban', 'urutan' => 2],
                    ['nama' => 'LPPD', 'slug' => 'lppd', 'deskripsi' => 'Laporan Penyelenggaraan Pemerintahan Daerah', 'urutan' => 3],
                    ['nama' => 'LAKIP', 'slug' => 'lakip', 'deskripsi' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Perencanaan',
                'slug' => 'perencanaan',
                'deskripsi' => 'Dokumen perencanaan pembangunan daerah',
                'icon' => 'bi-clipboard-data',
                'urutan' => 3,
                'jenis' => [
                    ['nama' => 'RPJMD', 'slug' => 'rpjmd', 'deskripsi' => 'Rencana Pembangunan Jangka Menengah Daerah', 'urutan' => 1],
                    ['nama' => 'RPJPD', 'slug' => 'rpjpd', 'deskripsi' => 'Rencana Pembangunan Jangka Panjang Daerah', 'urutan' => 2],
                    ['nama' => 'RKPD', 'slug' => 'rkpd', 'deskripsi' => 'Rencana Kerja Pemerintah Daerah', 'urutan' => 3],
                    ['nama' => 'Renstra', 'slug' => 'renstra', 'deskripsi' => 'Rencana Strategis OPD', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Regulasi',
                'slug' => 'regulasi',
                'deskripsi' => 'Peraturan daerah dan produk hukum lainnya',
                'icon' => 'bi-journal-text',
                'urutan' => 4,
                'jenis' => [
                    ['nama' => 'Perda', 'slug' => 'perda', 'deskripsi' => 'Peraturan Daerah', 'urutan' => 1],
                    ['nama' => 'Perbup', 'slug' => 'perbup', 'deskripsi' => 'Peraturan Bupati', 'urutan' => 2],
                    ['nama' => 'SK', 'slug' => 'sk', 'deskripsi' => 'Surat Keputusan', 'urutan' => 3],
                    ['nama' => 'SE', 'slug' => 'se', 'deskripsi' => 'Surat Edaran', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Statistik',
                'slug' => 'statistik',
                'deskripsi' => 'Data statistik dan infografis daerah',
                'icon' => 'bi-bar-chart',
                'urutan' => 5,
                'jenis' => [
                    ['nama' => 'BPS', 'slug' => 'bps', 'deskripsi' => 'Data Badan Pusat Statistik', 'urutan' => 1],
                    ['nama' => 'Infografis', 'slug' => 'infografis', 'deskripsi' => 'Infografis Data Daerah', 'urutan' => 2],
                    ['nama' => 'Demografi', 'slug' => 'demografi', 'deskripsi' => 'Data Kependudukan', 'urutan' => 3],
                    ['nama' => 'Ekonomi', 'slug' => 'ekonomi', 'deskripsi' => 'Data Ekonomi Daerah', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Publikasi',
                'slug' => 'publikasi',
                'deskripsi' => 'Publikasi dan dokumen informasi publik',
                'icon' => 'bi-newspaper',
                'urutan' => 6,
                'jenis' => [
                    ['nama' => 'Buletin', 'slug' => 'buletin', 'deskripsi' => 'Buletin Berkala', 'urutan' => 1],
                    ['nama' => 'Majalah', 'slug' => 'majalah', 'deskripsi' => 'Majalah Daerah', 'urutan' => 2],
                    ['nama' => 'Booklet', 'slug' => 'booklet', 'deskripsi' => 'Booklet Informasi', 'urutan' => 3],
                    ['nama' => 'Lainnya', 'slug' => 'lainnya', 'deskripsi' => 'Publikasi Lainnya', 'urutan' => 4],
                ]
            ],
        ];

        foreach ($dataKategori as $kategoriData) {
            $jenisData = $kategoriData['jenis'];
            unset($kategoriData['jenis']);

            $kategori = KategoriUnduhan::create($kategoriData);

            foreach ($jenisData as $jenis) {
                $kategori->jenisUnduhans()->create($jenis);
            }
        }

        $this->command->info('✓ Seeded ' . count($dataKategori) . ' kategori unduhan');
        $this->command->info('✓ Total ' . JenisUnduhan::count() . ' jenis dokumen created');
    }
}
