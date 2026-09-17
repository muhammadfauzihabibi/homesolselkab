<?php

namespace App\Http\Controllers;

use App\Models\JenisUnduhan;
use App\Models\KategoriUnduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisUnduhanController extends Controller
{
    /**
     * Tampilkan daftar jenis dokumen.
     */
    public function index(Request $request)
    {
        $query = JenisUnduhan::with('kategoriUnduhan')->withCount('unduhans');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_unduhan_id', $request->input('kategori'));
        }

        $jenises = $query->ordered()->paginate(10)->withQueryString();
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();

        return view('admin.unduhan.jenis.index', compact('jenises', 'kategoris'));
    }

    /**
     * Tampilkan form tambah jenis dokumen.
     */
    public function create()
    {
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();
        return view('admin.unduhan.jenis.create', compact('kategoris'));
    }

    /**
     * Simpan jenis dokumen baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_unduhan_id' => 'required|exists:kategori_unduhans,id',
            'nama'                => 'required|string|max:100',
            'deskripsi'           => 'nullable|string|max:500',
            'urutan'              => 'nullable|integer|min:0',
            'aktif'               => 'nullable|boolean',
        ]);

        // Auto generate slug
        $validated['slug'] = Str::slug($request->nama);
        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        JenisUnduhan::create($validated);

        return redirect()->route('admin.unduhan.jenis.index')->with('success', 'Jenis dokumen berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit jenis dokumen.
     */
    public function edit(JenisUnduhan $jenis)
    {
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();
        return view('admin.unduhan.jenis.edit', compact('jenis', 'kategoris'));
    }

    /**
     * Update jenis dokumen di database.
     */
    public function update(Request $request, JenisUnduhan $jenis)
    {
        $validated = $request->validate([
            'kategori_unduhan_id' => 'required|exists:kategori_unduhans,id',
            'nama'                => 'required|string|max:100',
            'deskripsi'           => 'nullable|string|max:500',
            'urutan'              => 'nullable|integer|min:0',
            'aktif'               => 'nullable|boolean',
        ]);

        // Auto generate slug jika nama berubah
        if ($request->nama !== $jenis->nama) {
            $validated['slug'] = Str::slug($request->nama);
        }

        $validated['aktif'] = $request->has('aktif') ? true : false;
        $validated['urutan'] = $request->urutan ?? 0;

        $jenis->update($validated);

        return redirect()->route('admin.unduhan.jenis.index')->with('success', 'Jenis dokumen berhasil diperbarui!');
    }

    /**
     * Hapus jenis dokumen dari database.
     */
    public function destroy(JenisUnduhan $jenis)
    {
        // Cek apakah jenis memiliki dokumen
        if ($jenis->unduhans()->count() > 0) {
            return redirect()->route('admin.unduhan.jenis.index')->with('error', 'Jenis dokumen tidak dapat dihapus karena masih memiliki dokumen!');
        }

        $jenis->delete();

        return redirect()->route('admin.unduhan.jenis.index')->with('success', 'Jenis dokumen berhasil dihapus!');
    }

    /**
     * Update urutan jenis via AJAX.
     */
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:jenis_unduhans,id',
            'items.*.urutan' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            JenisUnduhan::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui!']);
    }

    /**
     * Get jenis by kategori via AJAX untuk dropdown dinamis.
     */
    public function getByKategori(Request $request)
    {
        $kategoriId = $request->kategori_id;
        $kategoriSlug = $request->kategori_slug;
        
        $query = JenisUnduhan::aktif()->ordered();
        
        if ($kategoriId) {
            $query->where('kategori_unduhan_id', $kategoriId);
        } elseif ($kategoriSlug) {
            $query->whereHas('kategoriUnduhan', function($q) use ($kategoriSlug) {
                $q->where('slug', $kategoriSlug);
            });
        }
        
        $jenises = $query->get(['id', 'nama', 'slug']);

        return response()->json($jenises);
    }
}
