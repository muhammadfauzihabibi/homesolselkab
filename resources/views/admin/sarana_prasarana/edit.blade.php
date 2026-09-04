@extends('layouts.admin')

@section('title', 'Edit Sarana & Prasarana')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h2 fw-extrabold mb-1 text-main">Edit Sarana & Prasarana</h1>
      <p class="text-muted-custom mb-0 fs-6">Perbarui informasi sarana atau prasarana {{ $item->nama }}.</p>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-3 fs-7">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <form action="{{ route('sarana-prasarana.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
      <!-- Kolom Kiri: Informasi Utama -->
      <div class="col-lg-8">
        <div class="glass-card p-4 mb-4 shadow-sm">
          <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">Informasi Dasar</h5>

          <div class="mb-3">
            <label for="nama" class="form-label fw-semibold text-main">Nama Sarana / Prasarana <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama" class="form-control rounded-3 @error('nama') is-invalid @enderror" value="{{ old('nama', $item->nama) }}" required>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="kategori" class="form-label fw-semibold text-main">Kategori <span class="text-danger">*</span></label>
              <input type="text" name="kategori" id="kategori" list="kategori_list" class="form-control rounded-3 @error('kategori') is-invalid @enderror" value="{{ old('kategori', $item->kategori) }}" required>
              <datalist id="kategori_list">
                <option value="Gedung & Aula">
                <option value="Fasilitas Olahraga">
                <option value="Taman & RTH">
                <option value="Kendaraan Dinas & Transportasi">
                <option value="Alat Berat & Mesin">
                <option value="Fasilitas Kesehatan">
                <option value="Pariwisata & Kebudayaan">
              </datalist>
              @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="sub_kategori" class="form-label fw-semibold text-main">Sub Kategori</label>
              <input type="text" name="sub_kategori" id="sub_kategori" class="form-control rounded-3 @error('sub_kategori') is-invalid @enderror" value="{{ old('sub_kategori', $item->sub_kategori) }}">
              @error('sub_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat_lengkap" class="form-label fw-semibold text-main">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="form-control rounded-3 @error('alamat_lengkap') is-invalid @enderror" required>{{ old('alamat_lengkap', $item->alamat_lengkap) }}</textarea>
            @error('alamat_lengkap')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="kecamatan" class="form-label fw-semibold text-main">Kecamatan <span class="text-danger">*</span></label>
              <input type="text" name="kecamatan" id="kecamatan" list="kecamatan_list" class="form-control rounded-3 @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan', $item->kecamatan) }}" required>
              <datalist id="kecamatan_list">
                @foreach($kecamatans as $kec)
                  <option value="{{ $kec->nama }}">
                @endforeach
              </datalist>
              @error('kecamatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="nagari" class="form-label fw-semibold text-main">Nagari</label>
              <input type="text" name="nagari" id="nagari" class="form-control rounded-3 @error('nagari') is-invalid @enderror" value="{{ old('nagari', $item->nagari) }}">
              @error('nagari')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="latitude" class="form-label fw-semibold text-main">Latitude (Koordinat Y)</label>
              <input type="number" step="any" name="latitude" id="latitude" class="form-control rounded-3 @error('latitude') is-invalid @enderror" value="{{ old('latitude', $item->latitude) }}">
              @error('latitude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="longitude" class="form-label fw-semibold text-main">Longitude (Koordinat X)</label>
              <input type="number" step="any" name="longitude" id="longitude" class="form-control rounded-3 @error('longitude') is-invalid @enderror" value="{{ old('longitude', $item->longitude) }}">
              @error('longitude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="google_maps_url" class="form-label fw-semibold text-main">Link Google Maps</label>
            <input type="url" name="google_maps_url" id="google_maps_url" class="form-control rounded-3 @error('google_maps_url') is-invalid @enderror" value="{{ old('google_maps_url', $item->google_maps_url) }}">
            @error('google_maps_url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="glass-card p-4 mb-4 shadow-sm">
          <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">Detail Spesifikasi & Layanan</h5>

          <div class="mb-3">
            <label for="jenis_kendaraan" class="form-label fw-semibold text-main">Jenis / Merk Kendaraan (opsional)</label>
            <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" class="form-control rounded-3 @error('jenis_kendaraan') is-invalid @enderror" value="{{ old('jenis_kendaraan', $item->jenis_kendaraan) }}">
            @error('jenis_kendaraan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="spesifikasi" class="form-label fw-semibold text-main">Spesifikasi Fasilitas</label>
            <textarea name="spesifikasi" id="spesifikasi" rows="4" class="form-control rounded-3 @error('spesifikasi') is-invalid @enderror">{{ old('spesifikasi', $item->spesifikasi) }}</textarea>
            @error('spesifikasi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="tarif_retribusi" class="form-label fw-semibold text-main">Tarif / Retribusi</label>
            <textarea name="tarif_retribusi" id="tarif_retribusi" rows="3" class="form-control rounded-3 @error('tarif_retribusi') is-invalid @enderror">{{ old('tarif_retribusi', $item->tarif_retribusi) }}</textarea>
            @error('tarif_retribusi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="rute_layanan" class="form-label fw-semibold text-main">Rute Layanan / Jangkauan Operasional</label>
            <textarea name="rute_layanan" id="rute_layanan" rows="3" class="form-control rounded-3 @error('rute_layanan') is-invalid @enderror">{{ old('rute_layanan', $item->rute_layanan) }}</textarea>
            @error('rute_layanan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Pengelola & Foto -->
      <div class="col-lg-4">
        <div class="glass-card p-4 mb-4 shadow-sm">
          <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">Status & Pengelola</h5>

          <div class="mb-3">
            <label for="kondisi" class="form-label fw-semibold text-main">Kondisi Fasilitas <span class="text-danger">*</span></label>
            <select name="kondisi" id="kondisi" class="form-select rounded-3 @error('kondisi') is-invalid @enderror" required>
              <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
              <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
              <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            @error('kondisi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="status_operasional" class="form-label fw-semibold text-main">Status Operasional <span class="text-danger">*</span></label>
            <select name="status_operasional" id="status_operasional" class="form-select rounded-3 @error('status_operasional') is-invalid @enderror" required>
              <option value="Aktif" {{ old('status_operasional', $item->status_operasional) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="Dalam Perbaikan" {{ old('status_operasional', $item->status_operasional) == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
              <option value="Tidak Beroperasi" {{ old('status_operasional', $item->status_operasional) == 'Tidak Beroperasi' ? 'selected' : '' }}>Tidak Beroperasi</option>
            </select>
            @error('status_operasional')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="pengelola" class="form-label fw-semibold text-main">Instansi / Pengelola <span class="text-danger">*</span></label>
            <input type="text" name="pengelola" id="pengelola" class="form-control rounded-3 @error('pengelola') is-invalid @enderror" value="{{ old('pengelola', $item->pengelola) }}" required>
            @error('pengelola')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="kontak_pengelola" class="form-label fw-semibold text-main">Kontak Pengelola</label>
            <input type="text" name="kontak_pengelola" id="kontak_pengelola" class="form-control rounded-3 @error('kontak_pengelola') is-invalid @enderror" value="{{ old('kontak_pengelola', $item->kontak_pengelola) }}">
            @error('kontak_pengelola')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="glass-card p-4 mb-4 shadow-sm">
          <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">Foto & Dokumentasi</h5>

          <div class="mb-3">
            <label for="foto_utama" class="form-label fw-semibold text-main">Foto Utama</label>
            @if($item->foto_utama)
              <div class="mb-2 rounded-3 overflow-hidden" style="max-height: 160px;">
                <img src="{{ asset('storage/' . $item->foto_utama) }}" alt="{{ $item->nama }}" class="w-100 h-100 object-fit-cover">
              </div>
            @endif
            <input type="file" name="foto_utama" id="foto_utama" class="form-control rounded-3 @error('foto_utama') is-invalid @enderror" accept="image/*">
            <small class="text-muted-custom d-block mt-1">Upload gambar baru jika ingin mengganti foto utama.</small>
            @error('foto_utama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="galeri_foto" class="form-label fw-semibold text-main">Galeri Foto</label>
            @if(!empty($item->galeri_foto) && is_array($item->galeri_foto))
              <div class="row g-2 mb-3">
                @foreach($item->galeri_foto as $gPath)
                  <div class="col-4 position-relative">
                    <div class="rounded-2 overflow-hidden border" style="height: 70px;">
                      <img src="{{ asset('storage/' . $gPath) }}" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="form-check mt-1">
                      <input class="form-check-input" type="checkbox" name="deleted_galeri[]" value="{{ $gPath }}" id="del_g_{{ $loop->index }}">
                      <label class="form-check-label fs-8 text-danger" for="del_g_{{ $loop->index }}">Hapus</label>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
            <input type="file" name="galeri_foto[]" id="galeri_foto" class="form-control rounded-3 @error('galeri_foto.*') is-invalid @enderror" accept="image/*" multiple>
            <small class="text-muted-custom d-block mt-1">Tambah foto baru ke dalam galeri.</small>
            @error('galeri_foto.*')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-bold shadow-sm">
            <i class="bi bi-arrow-repeat me-1"></i> Perbarui Data
          </button>
          <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill py-2 fw-semibold border">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection
