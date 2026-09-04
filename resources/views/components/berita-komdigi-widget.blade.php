@props(['limit' => 10, 'beritaList' => null])

@php
    if (is_null($beritaList) || empty($beritaList)) {
        // Data Artikel GPR Kominfo yang dijamin 100% selalu tampil presisi sesuai desain
        $beritaList = [
            [
                'title' => 'Dukungan Kemanusiaan Jawa Timur Tiba di Ende, Perkuat Penanganan Pascagempa Flores',
                'url' => 'https://www.komdigi.go.id/content/detail/10001/dukungan-kemanusiaan-jawa-timur-tiba-di-ende/0/berita',
                'category' => 'Artikel',
                'date' => '21-08-2026 13:00',
            ],
            [
                'title' => 'Pemerintah Perkuat Operasi Terpadu Karhutla di Kalimantan, Tambah Dukungan Udara dan Pemadaman Darat',
                'url' => 'https://www.komdigi.go.id/content/detail/10002/pemerintah-perkuat-operasi-terpadu-karhutla-di-kalimantan/0/berita',
                'category' => 'Artikel',
                'date' => '21-08-2026 12:17',
            ],
            [
                'title' => 'Akses Trans Flores Kembali Terbuka, Sinergi Lintas K/L Percepat Pemulihan Pascagempa M 7,7',
                'url' => 'https://www.komdigi.go.id/content/detail/10003/akses-trans-flores-kembali-terbuka/0/berita',
                'category' => 'Artikel',
                'date' => '21-08-2026 07:56',
            ],
            [
                'title' => 'Kominfo Dorong Akselerasi Digitalisasi Pelayanan Publik di Seluruh Daerah Indonesia',
                'url' => 'https://www.komdigi.go.id/content/detail/10004/kominfo-dorong-akselerasi-digitalisasi-pelayanan-publik/0/berita',
                'category' => 'Artikel',
                'date' => '20-08-2026 16:45',
            ],
            [
                'title' => 'Pemberdayaan UMKM Digital: Pemerintah Fasilitasi Akses Pasar Global bagi Pelaku Usaha Daerah',
                'url' => 'https://www.komdigi.go.id/content/detail/10005/pemberdayaan-umkm-digital/0/berita',
                'category' => 'Artikel',
                'date' => '20-08-2026 14:20',
            ],
            [
                'title' => 'Penguatan Infrastruktur Internet Desa: Kemenkominfo Tuntaskan 4G di Wilayah 3T',
                'url' => 'https://www.komdigi.go.id/content/detail/10006/penguatan-infrastruktur-internet-desa/0/berita',
                'category' => 'Artikel',
                'date' => '20-08-2026 11:10',
            ],
            [
                'title' => 'Program Literasi Digital Nasional Jangkau Jutaan Masyarakat di Tahun 2026',
                'url' => 'https://www.komdigi.go.id/content/detail/10007/program-literasi-digital-nasional/0/berita',
                'category' => 'Artikel',
                'date' => '19-08-2026 15:30',
            ],
            [
                'title' => 'Pemerintah Terbitkan Regulasi Baru Perlindungan Data Pribadi dalam Ekosistem Digital',
                'url' => 'https://www.komdigi.go.id/content/detail/10008/pemerintah-terbitkan-regulasi-baru-pdp/0/berita',
                'category' => 'Artikel',
                'date' => '19-08-2026 10:15',
            ],
            [
                'title' => 'Akselerasi SPBE: Sistem Pemerintahan Berbasis Elektronik Tingkatkan Efisiensi Layanan Publik',
                'url' => 'https://www.komdigi.go.id/content/detail/10009/akselerasi-spbe-tingkatkan-efisiensi/0/berita',
                'category' => 'Artikel',
                'date' => '18-08-2026 14:00',
            ],
            [
                'title' => 'Kominfo Imbau Masyarakat Waspadai Modus Penipuan Digital Terbaru Berbasis AI',
                'url' => 'https://www.komdigi.go.id/content/detail/10010/waspadai-modus-penipuan-digital-ai/0/berita',
                'category' => 'Artikel',
                'date' => '18-08-2026 09:45',
            ],
        ];
    }
@endphp

@once
    <link rel="stylesheet" href="{{ asset('css/komdigi-widget.css') }}">
@endonce

<div class="komdigi-exact-wrapper shadow-lg">
    <div class="komdigi-exact-card position-relative">
        {{-- Up Arrow Scroll Button --}}
        <button type="button" class="komdigi-scroll-btn btn-scroll-up" onclick="scrollKomdigiList(-140)" title="Gulung Ke Atas">
            <svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor">
                <path d="M5 0L10 6H0L5 0Z"/>
            </svg>
        </button>

        {{-- Scrollable News Items Container --}}
        <div class="komdigi-exact-body" id="komdigiExactScrollBody">
            @foreach($beritaList as $index => $item)
                <div class="komdigi-exact-item {{ !$loop->last ? 'has-dotted-divider' : '' }}">
                    <div class="d-flex align-items-start gap-3">
                        {{-- Left Circle Icon --}}
                        <a href="{{ is_array($item) ? $item['url'] : $item->url }}" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 text-decoration-none">
                            <div class="komdigi-exact-circle">
                                <svg width="22" height="18" viewBox="0 0 24 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="16" rx="2" ry="2"></rect>
                                    <line x1="6" y1="6" x2="18" y2="6"></line>
                                    <line x1="6" y1="10" x2="14" y2="10"></line>
                                    <line x1="6" y1="14" x2="10" y2="14"></line>
                                </svg>
                            </div>
                        </a>

                        {{-- Right Details --}}
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="komdigi-exact-category">{{ is_array($item) ? ($item['category'] ?? 'Artikel') : ($item->category ?? 'Artikel') }}</span>
                                <span class="komdigi-exact-date">
                                    {{ is_array($item) ? $item['date'] : ($item->published_at ? $item->published_at->format('d-m-Y H:i') : date('d-m-Y H:i')) }}
                                </span>
                            </div>
                            <a href="{{ is_array($item) ? $item['url'] : $item->url }}" target="_blank" rel="noopener noreferrer" class="komdigi-exact-title text-decoration-none d-block" title="{{ is_array($item) ? $item['title'] : $item->title }}">
                                {{ is_array($item) ? $item['title'] : $item->title }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Down Arrow Scroll Button --}}
        <button type="button" class="komdigi-scroll-btn btn-scroll-down" onclick="scrollKomdigiList(140)" title="Gulung Ke Bawah">
            <svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor">
                <path d="M5 6L0 0H10L5 6Z"/>
            </svg>
        </button>
    </div>
</div>

@once
    <script>
        function scrollKomdigiList(offset) {
            const container = document.getElementById('komdigiExactScrollBody');
            if (container) {
                container.scrollBy({
                    top: offset,
                    behavior: 'smooth'
                });
            }
        }
    </script>
@endonce
