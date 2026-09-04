<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Tampilkan daftar OPD.
     */
    public function index(Request $request)
    {
        $query = Opd::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $opds = $query->latest()->paginate(10)->withQueryString();

        return view('admin.opd.index', compact('opds'));
    }

    /**
     * Tampilkan form tambah OPD baru.
     */
    public function create()
    {
        return view('admin.opd.create');
    }

    /**
     * Simpan OPD baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'url'       => 'required|url|max:255',
            'kategori'  => 'required|in:Dinas,Badan,Sekretariat,Layanan',
            'deskripsi' => 'required|string|max:500',
            'aktif'     => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        Opd::create($validated);

        return redirect()->route('opd.index')->with('success', 'Data OPD berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit OPD.
     */
    public function edit(Opd $opd)
    {
        return view('admin.opd.edit', compact('opd'));
    }

    /**
     * Perbarui data OPD di database.
     */
    public function update(Request $request, Opd $opd)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'url'       => 'required|url|max:255',
            'kategori'  => 'required|in:Dinas,Badan,Sekretariat,Layanan',
            'deskripsi' => 'required|string|max:500',
            'aktif'     => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        $opd->update($validated);

        return redirect()->route('opd.index')->with('success', 'Data OPD berhasil diperbarui!');
    }

    /**
     * Hapus data OPD dari database.
     */
    public function destroy(Opd $opd)
    {
        $opd->delete();

        return redirect()->route('opd.index')->with('success', 'Data OPD berhasil dihapus!');
    }
}
