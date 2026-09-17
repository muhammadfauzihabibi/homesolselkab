<?php

namespace App\Http\Controllers;

use App\Models\KategoriUnduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriUnduhanController extends Controller
{
    /**
     * Tampilkan daftar kategori unduhan.
     */
    public function index(Request $request)
    {
        $query = KategoriUnduhan::withCount('jenisUnduhans', 'unduhans');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.unduhan.kategori.index', compact('kategoris'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.unduhan.kategori.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_unduhans,nama',
            'deskripsi' => 'nullable|string|max:500',
            'icon'      => 'nullable|string|max:50',
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
        ]);

        // Auto generate slug
        $validated['slug'] = Str::slug($request->nama);
        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        KategoriUnduhan::create($validated);

        return redirect()->route('admin.unduhan.kategori.index')->with('success', 'Kategori unduhan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit(KategoriUnduhan $kategori)
    {
        return view('admin.unduhan.kategori.edit', compact('kategori'));
    }

    /**
     * Update kategori di database.
     */
    public function update(Request $request, KategoriUnduhan $kategori)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_unduhans,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500',
            'icon'      => 'nullable|string|max:50',
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
        ]);

        // Auto generate slug jika nama berubah
        if ($request->nama !== $kategori->nama) {
            $validated['slug'] = Str::slug($request->nama);
        }

        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        $kategori->update($validated);

        return redirect()->route('admin.unduhan.kategori.index')->with('success', 'Kategori unduhan berhasil diperbarui!');
    }

    /**
     * Hapus kategori dari database.
     */
    public function destroy(KategoriUnduhan $kategori)
    {
        // Cek apakah kategori memiliki jenis atau dokumen
        if ($kategori->jenisUnduhans()->count() > 0) {
            return redirect()->route('admin.unduhan.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki jenis dokumen!');
        }

        if ($kategori->unduhans()->count() > 0) {
            return redirect()->route('admin.unduhan.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen!');
        }

        $kategori->delete();

        return redirect()->route('admin.unduhan.kategori.index')->with('success', 'Kategori unduhan berhasil dihapus!');
    }

    /**
     * Update urutan kategori via AJAX.
     */
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:kategori_unduhans,id',
            'items.*.urutan' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            KategoriUnduhan::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui!']);
    }
}
