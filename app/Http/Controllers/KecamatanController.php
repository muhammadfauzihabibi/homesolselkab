<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Tampilkan daftar Kecamatan.
     */
    public function index(Request $request)
    {
        $query = Kecamatan::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $kecamatans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kecamatan.index', compact('kecamatans'));
    }

    /**
     * Tampilkan form tambah Kecamatan baru.
     */
    public function create()
    {
        return view('admin.kecamatan.create');
    }

    /**
     * Simpan data Kecamatan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url'  => 'required|url|max:255',
        ], [
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.max'      => 'Nama kecamatan maksimal 255 karakter.',
            'url.required'  => 'URL website/subdomain wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
        ]);

        Kecamatan::create($validated);

        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit Kecamatan.
     */
    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Perbarui data Kecamatan di database.
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url'  => 'required|url|max:255',
        ], [
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.max'      => 'Nama kecamatan maksimal 255 karakter.',
            'url.required'  => 'URL website/subdomain wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
        ]);

        $kecamatan->update($validated);

        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil diperbarui!');
    }

    /**
     * Hapus data Kecamatan dari database.
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil dihapus!');
    }
}
