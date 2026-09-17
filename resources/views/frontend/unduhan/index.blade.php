@extends('layouts.frontend')

@section('title', 'Pusat Unduhan Dokumen')

@section('content')
    <!-- Bento Banner -->
    <section class="bento-page-banner position-relative text-white overflow-hidden">
        <x-frontend-hero-background />
        <div class="hero-bento-overlay"></div>

        <div class="container position-relative" style="z-index: 5;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pusat Unduhan</li>
                </ol>
            </nav>

            <span class="bento-eyebrow bento-eyebrow-accent mb-2">TRANSPARANSI TATA KELOLA</span>
            <h1 class="bento-page-title">Pusat Unduhan Dokumen Resmi</h1>
            <p class="bento-page-subtitle">Akses terbuka dokumen regulasi, pelaporan keuangan, kinerja daerah, dan informasi publik Pemerintah Kabupaten Solok Selatan</p>
        </div>
    </section>

    <div class="container bento-overlap-container pb-5">
        <!-- Bento Filter Card -->
        <div class="bento-card mb-4 p-4">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-primary"></i> Filter Dokumen Publik
            </h6>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('frontend.unduhan.index') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="kategori" class="form-select rounded-pill fs-7" id="filter-kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->slug }}" {{ request('kategori') == $kategori->slug ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="jenis" class="form-select rounded-pill fs-7" id="filter-jenis">
                        <option value="">Semua Jenis</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="tahun" class="form-select rounded-pill fs-7">
                        <option value="">Semua Tahun</option>
                        @foreach($tahuns as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control rounded-start-pill fs-7" placeholder="Judul dokumen..." value="{{ request('search') }}">
                        <button type="submit" class="btn-bento btn-bento-primary rounded-end-pill px-3">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    @if(request()->hasAny(['kategori', 'jenis', 'tahun', 'search']))
                        <a href="{{ route('frontend.unduhan.index') }}" class="btn-bento btn-bento-outline w-100 justify-content-center" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Categories Bento Grid (shown when not filtering) -->
        @if(!request()->hasAny(['kategori', 'jenis', 'tahun', 'search']))
            <div class="bento-card mb-4 p-4 p-md-4.5">
                <h6 class="fw-bold mb-3.5 d-flex align-items-center gap-2 fs-6">
                    <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Kategori Dokumen
                </h6>
                <div class="row g-3.5 g-md-4 mt-2">
                    @foreach($kategoris as $kategori)
                        <div class="col-xl-4 col-md-6 col-12">
                            <a href="{{ route('frontend.unduhan.index', ['kategori' => $kategori->slug]) }}" class="text-decoration-none">
                                <div class="bento-card bento-card-interactive p-4 h-100 border border-subtle">
                                    <div class="d-flex align-items-center gap-3.5">
                                        @if($kategori->icon)
                                            <div class="bento-doc-icon-wrap mb-0 flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.35rem; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $kategori->icon }}"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="fw-bold mb-1 fs-6 text-truncate text-body-emphasis">{{ $kategori->nama }}</h6>
                                            @if($kategori->deskripsi)
                                                <small class="text-muted-custom fs-7 line-clamp-1 d-block mb-1.5">{{ $kategori->deskripsi }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Documents Bento List -->
        <div class="bento-card p-4 p-md-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
                <h6 class="fw-bold mb-0 fs-5 d-flex align-items-center gap-2">
                    <i class="bi bi-files text-primary"></i> Daftar Dokumen
                    @if(request('kategori'))
                        <span class="text-primary fs-6 fw-semibold">- {{ $kategoris->where('slug', request('kategori'))->first()?->nama }}</span>
                    @endif
                </h6>
                <div class="d-flex align-items-center gap-3">
                    @if($unduhans->count() > 0)
                        <div class="btn-group btn-group-sm" role="group" aria-label="Pilihan Tampilan">
                            <button type="button" class="btn btn-bento-primary btn-bento-sm active" id="btnViewCard" title="Tampilan Kartu">
                                <i class="bi bi-view-stacked"></i> <span class="d-none d-sm-inline ms-1">Kartu</span>
                            </button>
                            <button type="button" class="btn btn-bento-outline btn-bento-sm" id="btnViewTable" title="Tampilan Tabel">
                                <i class="bi bi-table"></i> <span class="d-none d-sm-inline ms-1">Tabel</span>
                            </button>
                        </div>
                    @endif
                    <span class="bento-badge px-3 py-1.5 fs-7">{{ number_format($unduhans->total()) }} dokumen tersedia</span>
                </div>
            </div>

            @if($unduhans->count() > 0)
                <!-- Card View -->
                <div id="unduhanCardView" class="d-flex flex-column gap-4 pt-2">
                    @foreach($unduhans as $unduhan)
                        <div class="bento-card p-4 p-md-4.5 border border-subtle shadow-xs">
                            <div class="row align-items-center g-4">
                                <!-- Document Info -->
                                <div class="col-lg-8 col-xl-9">
                                    <div class="d-flex align-items-start gap-3.5 gap-md-4">
                                        <div class="p-3 rounded-4 bg-danger-subtle text-danger flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                            <i class="bi bi-file-earmark-pdf-fill fs-2"></i>
                                        </div>

                                        <div class="flex-grow-1 min-w-0">
                                            <h5 class="fw-bold fs-6 mb-2 text-body-emphasis">{{ $unduhan->judul }}</h5>

                                            <!-- Meta Badges -->
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                @if($unduhan->kategoriUnduhan)
                                                    <span class="bento-badge bento-badge-primary px-3 py-1 fs-7">
                                                        @if($unduhan->kategoriUnduhan->icon)
                                                            <i class="{{ $unduhan->kategoriUnduhan->icon }} me-1"></i>
                                                        @endif
                                                        {{ $unduhan->kategoriUnduhan->nama }}
                                                    </span>
                                                @endif

                                                @if($unduhan->jenisUnduhan)
                                                    <span class="bento-badge px-3 py-1 fs-7">
                                                        {{ $unduhan->jenisUnduhan->nama }}
                                                    </span>
                                                @endif

                                                @if($unduhan->tahun)
                                                    <span class="bento-badge px-3 py-1 fs-7">
                                                        Tahun {{ $unduhan->tahun }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if($unduhan->deskripsi)
                                                <p class="text-muted-custom fs-7 mb-3 line-clamp-2 leading-relaxed">{{ $unduhan->deskripsi }}</p>
                                            @endif

                                            <div class="d-flex flex-wrap gap-4 fs-7 text-muted-custom pt-2 border-top border-subtle border-opacity-50">
                                                @if($unduhan->tanggal_publikasi)
                                                    <span><i class="bi bi-calendar3 me-1.5 text-primary"></i>{{ $unduhan->tanggal_publikasi->format('d M Y') }}</span>
                                                @endif
                                                <span><i class="bi bi-download me-1.5 text-primary"></i>{{ number_format($unduhan->jumlah_unduhan ?? 0) }} kali diunduh</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Download Button -->
                                <div class="col-lg-4 col-xl-3 text-lg-end">
                                    @if($unduhan->google_drive_url)
                                        <a href="{{ route('frontend.unduhan.download', $unduhan->slug) }}" class="btn-bento btn-bento-primary px-4 py-2.5 rounded-pill fs-7 d-inline-flex align-items-center gap-2 shadow-sm">
                                            <i class="bi bi-download"></i> Unduh Dokumen
                                        </a>
                                    @else
                                        <span class="bento-badge bento-badge-warning px-3.5 py-2 fs-7">
                                            <i class="bi bi-exclamation-circle me-1"></i>Link belum tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Table View (Standard Solsel Table) -->
                <div id="unduhanTableView" class="table-solsel-wrap d-none">
                    <table class="table-solsel">
                        <thead>
                            <tr>
                                <th style="width: 55px;" class="text-center">No</th>
                                <th>Nama Dokumen Resmi</th>
                                <th>Kategori / Jenis</th>
                                <th style="width: 100px;">Tahun</th>
                                <th style="width: 120px;">Tgl Rilis</th>
                                <th class="text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unduhans as $index => $unduhan)
                                <tr>
                                    <td class="text-center fw-semibold text-muted-custom">{{ $unduhans->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-body-emphasis mb-1">{{ $unduhan->judul }}</div>
                                        @if($unduhan->deskripsi)
                                            <small class="text-muted-custom line-clamp-1 fs-8">{{ $unduhan->deskripsi }}</small>
                                        @endif
                                        <small class="text-muted-custom d-block mt-1 fs-8">
                                            <i class="bi bi-download me-1 text-primary"></i>{{ number_format($unduhan->jumlah_unduhan ?? 0) }} kali diunduh
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if($unduhan->kategoriUnduhan)
                                                <span class="bento-badge bento-badge-primary px-2 py-0.5 fs-8 align-self-start">{{ $unduhan->kategoriUnduhan->nama }}</span>
                                            @endif
                                            @if($unduhan->jenisUnduhan)
                                                <span class="bento-badge px-2 py-0.5 fs-8 align-self-start">{{ $unduhan->jenisUnduhan->nama }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $unduhan->tahun ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="fs-8 text-muted-custom">{{ $unduhan->tanggal_publikasi ? $unduhan->tanggal_publikasi->format('d/m/Y') : '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($unduhan->google_drive_url)
                                            <a href="{{ route('frontend.unduhan.download', $unduhan->slug) }}" class="btn-bento btn-bento-primary btn-bento-sm d-inline-flex align-items-center gap-1 shadow-sm">
                                                <i class="bi bi-download"></i> Unduh
                                            </a>
                                        @else
                                            <span class="bento-badge bento-badge-warning px-2 py-1 fs-8">
                                                Belum ada file
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($unduhans->hasPages())
                    <div class="d-flex justify-content-center mt-4 pt-3 border-top border-subtle pagination-wrapper">
                        {{ $unduhans->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="text-center py-5 text-muted-custom">
                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                    <h6 class="fw-semibold mb-2">Belum Ada Dokumen</h6>
                    <p class="mb-0 fs-8">
                        @if(request()->hasAny(['kategori', 'jenis', 'tahun', 'search']))
                            Tidak ada dokumen yang sesuai dengan kriteria pencarian Anda.
                            <br>
                            <a href="{{ route('frontend.unduhan.index') }}" class="btn-bento btn-bento-outline btn-bento-sm mt-3">
                                <i class="bi bi-arrow-left me-1"></i>Lihat Semua Dokumen
                            </a>
                        @else
                            Belum ada dokumen yang dipublikasikan saat ini.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        {{-- Bottom Navigation --}}
        <div class="mt-5 pt-4 border-top border-subtle d-flex justify-content-center">
            <a href="{{ route('home') }}" class="btn-bento btn-bento-ghost">
                <i class="bi bi-house-door"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('filter-kategori');
    const jenisSelect = document.getElementById('filter-jenis');

    if (kategoriSelect && jenisSelect) {
        kategoriSelect.addEventListener('change', function() {
            const kategoriSlug = this.value;
            jenisSelect.innerHTML = '<option value="">Semua Jenis</option>';

            if (kategoriSlug) {
                const kategoris = @json($kategoris);
                const kategori = kategoris.find(k => k.slug === kategoriSlug);

                if (kategori) {
                    fetch(`{{ route('admin.unduhan.jenis.by-kategori') }}?kategori_id=${kategori.id}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(jenis => {
                                const option = document.createElement('option');
                                option.value = jenis.slug;
                                option.textContent = jenis.nama;
                                if ('{{ request("jenis") }}' === jenis.slug) {
                                    option.selected = true;
                                }
                                jenisSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching jenis:', error));
                }
            }
        });

        if (kategoriSelect.value) {
            kategoriSelect.dispatchEvent(new Event('change'));
        }
    }

    // View switcher (Card vs Table)
    const btnViewCard = document.getElementById('btnViewCard');
    const btnViewTable = document.getElementById('btnViewTable');
    const cardView = document.getElementById('unduhanCardView');
    const tableView = document.getElementById('unduhanTableView');

    if (btnViewCard && btnViewTable && cardView && tableView) {
        function setViewMode(mode) {
            if (mode === 'table') {
                cardView.classList.add('d-none');
                tableView.classList.remove('d-none');
                btnViewTable.classList.add('active', 'btn-bento-primary');
                btnViewTable.classList.remove('btn-bento-outline');
                btnViewCard.classList.remove('active', 'btn-bento-primary');
                btnViewCard.classList.add('btn-bento-outline');
            } else {
                tableView.classList.add('d-none');
                cardView.classList.remove('d-none');
                btnViewCard.classList.add('active', 'btn-bento-primary');
                btnViewCard.classList.remove('btn-bento-outline');
                btnViewTable.classList.remove('active', 'btn-bento-primary');
                btnViewTable.classList.add('btn-bento-outline');
            }
            try {
                localStorage.setItem('unduhan_view_mode', mode);
            } catch (e) {}
        }

        btnViewCard.addEventListener('click', () => setViewMode('card'));
        btnViewTable.addEventListener('click', () => setViewMode('table'));

        // Restore user preference if saved
        try {
            const savedMode = localStorage.getItem('unduhan_view_mode');
            if (savedMode === 'table') {
                setViewMode('table');
            }
        } catch (e) {}
    }
});
</script>
@endsection
