@extends('layouts.admin')

@section('title', 'Tambah Sarana & Prasarana')

@section('content')
  <!-- Header Page Title -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="admin-page-title">Tambah Sarana & Prasarana</h1>
      <p class="admin-page-subtitle">Isi formulir berikut untuk menambahkan data fasilitas atau prasarana baru.</p>
    </div>
  </div>

  <form action="{{ route('sarana-prasarana.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
      <!-- Kolom Kiri: Informasi Utama -->
      <div class="col-lg-8">
        <div class="glass-card p-4 mb-4">
          <h5 class="fw-bold  mb-3 pb-2 border-bottom">Informasi Dasar</h5>

          <div class="mb-3">
            <label for="nama" class="form-label fw-bold ">Nama Sarana / Prasarana <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Gedung Olahraga Koto Parik Gadang Diateh" required autofocus>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="kategori" class="form-label fw-bold ">Kategori <span class="text-danger">*</span></label>
              <input type="text" name="kategori" id="kategori" list="kategori_list" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Pilih / ketik kategori (misal: Olahraga, Gedung, Transportasi)" required>
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
              <label for="sub_kategori" class="form-label fw-bold ">Sub Kategori</label>
              <input type="text" name="sub_kategori" id="sub_kategori" class="form-control @error('sub_kategori') is-invalid @enderror" value="{{ old('sub_kategori') }}" placeholder="Contoh: Lapangan Futsal, Bus Sekolah, Ambulans">
              @error('sub_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat_lengkap" class="form-label fw-bold ">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="form-control @error('alamat_lengkap') is-invalid @enderror" placeholder="Tuliskan jalan, nomor, patokan alamat..." required>{{ old('alamat_lengkap') }}</textarea>
            @error('alamat_lengkap')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="kecamatan" class="form-label fw-bold ">Kecamatan <span class="text-danger">*</span></label>
              <input type="text" name="kecamatan" id="kecamatan" list="kecamatan_list" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan') }}" placeholder="Pilih atau masukkan nama Kecamatan" required>
              <datalist id="kecamatan_list">
                @foreach($kecamatans as $kec)
                  <option value="{{ $kec->nama }}">
                @endforeach
                <option value="Sangir">
                <option value="Sangir Jujuan">
                <option value="Sangir Balai Janggo">
                <option value="Sangir Batang Hari">
                <option value="Sungai Pagu">
                <option value="Koto Parik Gadang Diateh">
                <option value="Pauah Duo">
              </datalist>
              @error('kecamatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="nagari" class="form-label fw-bold ">Nagari</label>
              <input type="text" name="nagari" id="nagari" class="form-control @error('nagari') is-invalid @enderror" value="{{ old('nagari') }}" placeholder="Contoh: Pasir Talang, Luak Kapau">
              @error('nagari')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="latitude" class="form-label fw-bold ">Latitude (Koordinat Y)</label>
              <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" placeholder="-1.512345">
              @error('latitude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="longitude" class="form-label fw-bold ">Longitude (Koordinat X)</label>
              <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" placeholder="101.245678">
              @error('longitude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="google_maps_url" class="form-label fw-bold ">Link Google Maps</label>
            <input type="url" name="google_maps_url" id="google_maps_url" class="form-control @error('google_maps_url') is-invalid @enderror" value="{{ old('google_maps_url') }}" placeholder="https://maps.google.com/?q=...">
            @error('google_maps_url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="glass-card p-4 mb-4">
          <h5 class="fw-bold  mb-3 pb-2 border-bottom">Detail Spesifikasi & Layanan</h5>

          <div class="mb-3">
            <label for="jenis_kendaraan" class="form-label fw-bold ">Jenis / Merk Kendaraan (opsional)</label>
            <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" class="form-control @error('jenis_kendaraan') is-invalid @enderror" value="{{ old('jenis_kendaraan') }}" placeholder="Contoh: Toyota HiAce, Caterpillar Excavator 320">
            @error('jenis_kendaraan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="spesifikasi" class="form-label fw-bold ">Spesifikasi Fasilitas</label>
            <textarea name="spesifikasi" id="spesifikasi" rows="4" class="form-control @error('spesifikasi') is-invalid @enderror" placeholder="Tuliskan spesifikasi teknis, luas bangunan, kapasitas penonton, daya listrik, dll...">{{ old('spesifikasi') }}</textarea>
            @error('spesifikasi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="tarif_retribusi" class="form-label fw-bold ">Tarif / Retribusi</label>
            <textarea name="tarif_retribusi" id="tarif_retribusi" rows="3" class="form-control @error('tarif_retribusi') is-invalid @enderror" placeholder="Contoh: Rp 100.000 / jam (Siang), Rp 150.000 / jam (Malam). Gratis untuk kegiatan pemda.">{{ old('tarif_retribusi') }}</textarea>
            @error('tarif_retribusi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="rute_layanan" class="form-label fw-bold ">Rute Layanan / Jangkauan Operasional</label>
            <textarea name="rute_layanan" id="rute_layanan" rows="3" class="form-control @error('rute_layanan') is-invalid @enderror" placeholder="Contoh: Padang Aro - Muaralabuh, melayani seluruh kecamatan di Solok Selatan.">{{ old('rute_layanan') }}</textarea>
            @error('rute_layanan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Pengelola & Foto -->
      <div class="col-lg-4">
        <div class="glass-card p-4 mb-4">
          <h5 class="fw-bold  mb-3 pb-2 border-bottom">Status & Pengelola</h5>

          <div class="mb-3">
            <label for="kondisi" class="form-label fw-bold ">Kondisi Fasilitas <span class="text-danger">*</span></label>
            <select name="kondisi" id="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
              <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
              <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
              <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            @error('kondisi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="status_operasional" class="form-label fw-bold ">Status Operasional <span class="text-danger">*</span></label>
            <select name="status_operasional" id="status_operasional" class="form-select @error('status_operasional') is-invalid @enderror" required>
              <option value="Aktif" {{ old('status_operasional') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="Dalam Perbaikan" {{ old('status_operasional') == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
              <option value="Tidak Beroperasi" {{ old('status_operasional') == 'Tidak Beroperasi' ? 'selected' : '' }}>Tidak Beroperasi</option>
            </select>
            @error('status_operasional')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="pengelola" class="form-label fw-bold ">Instansi / Pengelola <span class="text-danger">*</span></label>
            <input type="text" name="pengelola" id="pengelola" class="form-control @error('pengelola') is-invalid @enderror" value="{{ old('pengelola') }}" placeholder="Contoh: Dinas Pariwisata & Kebudayaan" required>
            @error('pengelola')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="kontak_pengelola" class="form-label fw-bold ">Kontak Pengelola</label>
            <input type="text" name="kontak_pengelola" id="kontak_pengelola" class="form-control @error('kontak_pengelola') is-invalid @enderror" value="{{ old('kontak_pengelola') }}" placeholder="Contoh: 0812-3456-7890 / (0755) 12345">
            @error('kontak_pengelola')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="glass-card p-4 mb-4">
          <h5 class="fw-bold  mb-3 pb-2 border-bottom">Foto & Dokumentasi</h5>

          <div class="mb-3">
            <label for="foto_utama" class="form-label fw-bold ">Foto Utama</label>
            <input type="file" name="foto_utama" id="foto_utama" class="form-control @error('foto_utama') is-invalid @enderror" accept="image/*">
            <small class="text-muted d-block mt-1 fs-8">Format: JPG, PNG, WEBP (Max 4MB)</small>
            @error('foto_utama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="galeri_foto" class="form-label fw-bold ">Galeri Foto Tambahan</label>
            <input type="file" name="galeri_foto[]" id="galeri_foto" class="form-control @error('galeri_foto.*') is-invalid @enderror" accept="image/*" multiple>
            <small class="text-muted d-block mt-1 fs-8">Bisa memilih lebih dari 1 file gambar.</small>
            @error('galeri_foto.*')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="glass-card p-3 d-flex flex-column gap-2">
          <button type="submit" class="btn btn-primary w-100 py-2 fs-7">
            Simpan Data Sarana
          </button>
          <a href="{{ route('sarana-prasarana.index') }}" class="btn btn-glass-pill w-100 py-2 fs-7 text-center">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection
