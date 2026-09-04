<?php

namespace App\Http\Controllers;

use App\Models\SaranaPrasarana;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaranaPrasaranaController extends Controller
{
    /**
     * Tampilkan daftar sarana & prasarana (admin).
     */
    public function index(Request $request)
    {
        $query = SaranaPrasarana::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('sub_kategori', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('pengelola', 'like', "%{$search}%");
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

        if ($request->filled('status_operasional')) {
            $query->where('status_operasional', $request->input('status_operasional'));
        }

        $items = $query->latest('id')->paginate(10)->withQueryString();

        $kategoris = SaranaPrasarana::distinct()->pluck('kategori')->filter();
        $kecamatans = Kecamatan::orderBy('nama')->get();

        return view('admin.sarana_prasarana.index', compact('items', 'kategoris', 'kecamatans'));
    }

    /**
     * Tampilkan form tambah sarana & prasarana baru.
     */
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama')->get();
        return view('admin.sarana_prasarana.create', compact('kecamatans'));
    }

    /**
     * Simpan sarana & prasarana baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'kategori'           => 'required|string|max:100',
            'sub_kategori'       => 'nullable|string|max:100',
            'alamat_lengkap'     => 'required|string',
            'nagari'             => 'nullable|string|max:100',
            'kecamatan'          => 'required|string|max:100',
            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',
            'google_maps_url'    => 'nullable|string',
            'rute_layanan'       => 'nullable|string',
            'jenis_kendaraan'    => 'nullable|string|max:255',
            'spesifikasi'        => 'nullable|string',
            'tarif_retribusi'    => 'nullable|string',
            'kondisi'            => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status_operasional' => 'required|in:Aktif,Dalam Perbaikan,Tidak Beroperasi',
            'pengelola'          => 'required|string|max:255',
            'kontak_pengelola'   => 'nullable|string|max:50',
            'foto_utama'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'galeri_foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $validated['slug'] = Str::slug($request->nama) . '-' . Str::random(5);

        // Upload Foto Utama
        if ($request->hasFile('foto_utama')) {
            $file = $request->file('foto_utama');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['foto_utama'] = $file->storeAs('sarana_prasarana', $name, 'public');
            }
        }

        // Upload Galeri Foto
        $galeriPaths = [];
        if ($request->hasFile('galeri_foto')) {
            foreach ($request->file('galeri_foto') as $gFile) {
                if ($gFile->isValid()) {
                    $ext = $gFile->getClientOriginalExtension() ?: 'jpg';
                    $gName = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                    $galeriPaths[] = $gFile->storeAs('sarana_prasarana/galeri', $gName, 'public');
                }
            }
        }
        $validated['galeri_foto'] = $galeriPaths;

        SaranaPrasarana::create($validated);

        return redirect()->route('sarana-prasarana.index')->with('success', 'Data Sarana & Prasarana berhasil ditambahkan!');
    }

    /**
     * Detail Sarana & Prasarana (admin view).
     */
    public function show(SaranaPrasarana $saranaPrasarana)
    {
        return view('admin.sarana_prasarana.show', ['item' => $saranaPrasarana]);
    }

    /**
     * Tampilkan form edit sarana & prasarana.
     */
    public function edit(SaranaPrasarana $saranaPrasarana)
    {
        $kecamatans = Kecamatan::orderBy('nama')->get();
        return view('admin.sarana_prasarana.edit', [
            'item' => $saranaPrasarana,
            'kecamatans' => $kecamatans
        ]);
    }

    /**
     * Update data sarana & prasarana di database.
     */
    public function update(Request $request, SaranaPrasarana $saranaPrasarana)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'kategori'           => 'required|string|max:100',
            'sub_kategori'       => 'nullable|string|max:100',
            'alamat_lengkap'     => 'required|string',
            'nagari'             => 'nullable|string|max:100',
            'kecamatan'          => 'required|string|max:100',
            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',
            'google_maps_url'    => 'nullable|string',
            'rute_layanan'       => 'nullable|string',
            'jenis_kendaraan'    => 'nullable|string|max:255',
            'spesifikasi'        => 'nullable|string',
            'tarif_retribusi'    => 'nullable|string',
            'kondisi'            => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status_operasional' => 'required|in:Aktif,Dalam Perbaikan,Tidak Beroperasi',
            'pengelola'          => 'required|string|max:255',
            'kontak_pengelola'   => 'nullable|string|max:50',
            'foto_utama'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'galeri_foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->nama !== $saranaPrasarana->nama) {
            $validated['slug'] = Str::slug($request->nama) . '-' . Str::random(5);
        }

        // Upload Foto Utama baru jika ada
        if ($request->hasFile('foto_utama')) {
            $file = $request->file('foto_utama');
            if ($file->isValid()) {
                $this->deleteImage($saranaPrasarana->foto_utama);
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['foto_utama'] = $file->storeAs('sarana_prasarana', $name, 'public');
            }
        }

        // Handle Galeri Foto (Pertahankan yang lama kecuali diminta hapus / ditambahi)
        $existingGaleri = $saranaPrasarana->galeri_foto ?? [];
        if ($request->has('deleted_galeri')) {
            $deletedFiles = $request->input('deleted_galeri', []);
            foreach ($deletedFiles as $delPath) {
                $this->deleteImage($delPath);
                $existingGaleri = array_values(array_filter($existingGaleri, fn($path) => $path !== $delPath));
            }
        }

        if ($request->hasFile('galeri_foto')) {
            foreach ($request->file('galeri_foto') as $gFile) {
                if ($gFile->isValid()) {
                    $ext = $gFile->getClientOriginalExtension() ?: 'jpg';
                    $gName = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                    $existingGaleri[] = $gFile->storeAs('sarana_prasarana/galeri', $gName, 'public');
                }
            }
        }
        $validated['galeri_foto'] = $existingGaleri;

        $saranaPrasarana->update($validated);

        return redirect()->route('sarana-prasarana.index')->with('success', 'Data Sarana & Prasarana berhasil diperbarui!');
    }

    /**
     * Hapus data sarana & prasarana dari database.
     */
    public function destroy(SaranaPrasarana $saranaPrasarana)
    {
        // Hapus foto utama
        $this->deleteImage($saranaPrasarana->foto_utama);

        // Hapus semua foto galeri
        if (is_array($saranaPrasarana->galeri_foto)) {
            foreach ($saranaPrasarana->galeri_foto as $gPath) {
                $this->deleteImage($gPath);
            }
        }

        $saranaPrasarana->delete();

        return redirect()->route('sarana-prasarana.index')->with('success', 'Data Sarana & Prasarana berhasil dihapus!');
    }

    /**
     * Helper Hapus file gambar secara aman.
     */
    private function deleteImage(?string $path): void
    {
        if (!empty($path) && is_string($path) && strlen(trim($path)) > 0) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
