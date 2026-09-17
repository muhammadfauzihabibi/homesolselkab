<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Tampilkan daftar berita (index).
     */
    public function index(Request $request)
    {
        $query = Berita::with('kategoriBerita');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('ringkas', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_berita_id', $request->input('kategori'));
        }

        $beritas = $query->latest()->paginate(10)->withQueryString();
        $kategoris = KategoriBerita::aktif()->ordered()->get();

        return view('admin.berita.index', compact('beritas', 'kategoris'));
    }

    /**
     * Tampilkan form tambah berita (create).
     */
    public function create()
    {
        $kategoris = KategoriBerita::aktif()->ordered()->get();

        return view('admin.berita.create', compact('kategoris'));
    }

    /**
     * Simpan berita baru ke database (store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'ringkas'            => 'required|string|max:500',
            'konten'             => 'nullable|string',
            'kategori_berita_id' => 'nullable|exists:kategori_beritas,id',
            'tanggal_terbit'     => 'required|date',
            'terbit'             => 'nullable|boolean',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $kategoriBerita = $request->filled('kategori_berita_id')
            ? KategoriBerita::find($request->input('kategori_berita_id'))
            : null;

        $validated['kategori'] = $kategoriBerita ? $kategoriBerita->nama : ($request->input('kategori') ?? 'Umum');
        $validated['kategori_berita_id'] = $kategoriBerita?->id;
        $validated['slug'] = Str::slug($request->judul) . '-' . Str::random(5);
        $validated['terbit'] = $request->has('terbit') ? true : false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);

                $validated['image'] = $file->storeAs('berita', $name, 'public');
            } else {
                unset($validated['image']);
            }
        } else {
            unset($validated['image']);
        }

        Berita::create($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit berita (edit).
     */
    public function edit(Berita $berita)
    {
        $kategoris = KategoriBerita::aktif()->ordered()->get();

        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    /**
     * Update berita di database (update).
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'ringkas'            => 'required|string|max:500',
            'konten'             => 'nullable|string',
            'kategori_berita_id' => 'nullable|exists:kategori_beritas,id',
            'tanggal_terbit'     => 'required|date',
            'terbit'             => 'nullable|boolean',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $kategoriBerita = $request->filled('kategori_berita_id')
            ? KategoriBerita::find($request->input('kategori_berita_id'))
            : null;

        $validated['kategori'] = $kategoriBerita ? $kategoriBerita->nama : ($request->input('kategori') ?? $berita->kategori ?? 'Umum');
        $validated['kategori_berita_id'] = $kategoriBerita?->id;
        $validated['slug'] = Str::slug($request->judul) . '-' . Str::random(5);
        $validated['terbit'] = $request->has('terbit') ? true : false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $realPath = $file ? $file->getRealPath() : null;

            if ($file && $file->isValid() && !empty($realPath) && file_exists($realPath)) {
                $this->deleteImage($berita->image);

                $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['image'] = $file->storeAs('berita', $name, 'public');
            } else {
                unset($validated['image']);
            }
        } else {
            unset($validated['image']);
        }

        $berita->update($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita dari database (destroy).
     */
    public function destroy(Berita $berita)
    {
        $this->deleteImage($berita->image);

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Hapus file image dari storage secara aman.
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
