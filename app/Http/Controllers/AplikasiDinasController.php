<?php

namespace App\Http\Controllers;

use App\Models\AplikasiDinas;
use Illuminate\Http\Request;

class AplikasiDinasController extends Controller
{
    /**
     * Tampilkan daftar Aplikasi Dinas.
     */
    public function index(Request $request)
    {
        $query = AplikasiDinas::query();

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

        $aplikasiDinasList = $query->orderBy('urutan', 'asc')->latest()->paginate(10)->withQueryString();

        return view('admin.aplikasi_dinas.index', compact('aplikasiDinasList'));
    }

    /**
     * Tampilkan form tambah Aplikasi Dinas baru.
     */
    public function create()
    {
        return view('admin.aplikasi_dinas.create');
    }

    /**
     * Simpan data Aplikasi Dinas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'url'    => 'required|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama aplikasi wajib diisi.',
            'nama.max'      => 'Nama aplikasi maksimal 255 karakter.',
            'url.required'  => 'URL aplikasi wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
            'urutan.integer'=> 'Urutan harus berupa angka.',
            'urutan.min'    => 'Urutan tidak boleh kurang dari 0.',
        ]);

        $validated['urutan'] = $request->input('urutan', 0);
        $validated['aktif']  = $request->has('aktif') ? true : false;

        AplikasiDinas::create($validated);

        return redirect()->route('aplikasi-dinas.index')->with('success', 'Data Aplikasi Dinas berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit Aplikasi Dinas.
     */
    public function edit(AplikasiDinas $aplikasiDinas)
    {
        return view('admin.aplikasi_dinas.edit', compact('aplikasiDinas'));
    }

    /**
     * Perbarui data Aplikasi Dinas di database.
     */
    public function update(Request $request, AplikasiDinas $aplikasiDinas)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'url'    => 'required|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama aplikasi wajib diisi.',
            'nama.max'      => 'Nama aplikasi maksimal 255 karakter.',
            'url.required'  => 'URL aplikasi wajib diisi.',
            'url.url'       => 'Format URL tidak valid (gunakan http:// atau https://).',
            'url.max'       => 'URL maksimal 255 karakter.',
            'urutan.integer'=> 'Urutan harus berupa angka.',
            'urutan.min'    => 'Urutan tidak boleh kurang dari 0.',
        ]);

        $validated['urutan'] = $request->input('urutan', 0);
        $validated['aktif']  = $request->has('aktif') ? true : false;

        $aplikasiDinas->update($validated);

        return redirect()->route('aplikasi-dinas.index')->with('success', 'Data Aplikasi Dinas berhasil diperbarui!');
    }

    /**
     * Hapus data Aplikasi Dinas dari database.
     */
    public function destroy(AplikasiDinas $aplikasiDinas)
    {
        $aplikasiDinas->delete();

        return redirect()->route('aplikasi-dinas.index')->with('success', 'Data Aplikasi Dinas berhasil dihapus!');
    }
}
