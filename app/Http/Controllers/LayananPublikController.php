<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LayananPublik;

class LayananPublikController extends Controller
{
    /**
     * Tampilkan daftar Layanan Publik.
     */
    public function index(Request $request)
    {
        $query = LayananPublik::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === '1' ? true : false;
            $query->where('aktif', $status);
        }

        $layananPublikList = $query->orderBy('urutan', 'asc')->latest()->paginate(10)->withQueryString();

        return view('admin.layanan_publik.index', compact('layananPublikList'));
    }

    /**
     * Tampilkan form tambah Layanan Publik baru.
     */
    public function create()
    {
        return view('admin.layanan_publik.create');
    }

    /**
     * Simpan data Layanan Publik baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'url'    => 'required|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama layanan publik wajib diisi.',
            'nama.max'      => 'Nama layanan publik maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'url.required'  => 'URL layanan publik wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
            'urutan.integer'=> 'Urutan harus berupa angka.',
            'urutan.min'    => 'Urutan tidak boleh kurang dari 0.',
        ]);

        $validated['urutan'] = $request->input('urutan', 0);
        $validated['aktif']  = $request->has('aktif') ? true : false;

        LayananPublik::create($validated);

        return redirect()->route('layanan-publik.index')->with('success', 'Data Layanan Publik berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit Layanan Publik.
     */
    public function edit(LayananPublik $layananPublik)
    {
        return view('admin.layanan_publik.edit', compact('layananPublik'));
    }

    /**
     * Perbarui data Layanan Publik di database.
     */
    public function update(Request $request, LayananPublik $layananPublik)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'url'    => 'required|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama layanan publik wajib diisi.',
            'nama.max'      => 'Nama layanan publik maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'url.required'  => 'URL layanan publik wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
            'urutan.integer'=> 'Urutan harus berupa angka.',
            'urutan.min'    => 'Urutan tidak boleh kurang dari 0.',
        ]);

        $validated['urutan'] = $request->input('urutan', 0);
        $validated['aktif']  = $request->has('aktif') ? true : false;

        $layananPublik->update($validated);

        return redirect()->route('layanan-publik.index')->with('success', 'Data Layanan Publik berhasil diperbarui!');
    }

    /**
     * Hapus data Layanan Publik dari database.
     */
    public function destroy(LayananPublik $layananPublik)
    {
        $layananPublik->delete();

        return redirect()->route('aplikasi-dinas.index')->with('success', 'Data Aplikasi Dinas berhasil dihapus!');
    }
}
