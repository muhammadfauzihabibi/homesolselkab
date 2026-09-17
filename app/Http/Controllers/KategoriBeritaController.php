<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBerita::withCount('beritas');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.berita.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.berita.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_beritas,nama',
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->nama);
        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        KategoriBerita::create($validated);

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berita berhasil ditambahkan!');
    }

    public function edit(KategoriBerita $kategori)
    {
        return view('admin.berita.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBerita $kategori)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_beritas,nama,' . $kategori->id,
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
        ]);

        if ($request->nama !== $kategori->nama) {
            $validated['slug'] = Str::slug($request->nama);
        }

        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        $kategori->update($validated);

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berita berhasil diperbarui!');
    }

    public function destroy(KategoriBerita $kategori)
    {
        if ($kategori->beritas()->count() > 0) {
            return redirect()->route('admin.berita.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki berita!');
        }

        $kategori->delete();

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berita berhasil dihapus!');
    }
}
