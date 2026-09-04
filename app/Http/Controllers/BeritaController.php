<?php

namespace App\Http\Controllers;

use App\Models\Berita;
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
        $query = Berita::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('ringkas', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $beritas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Tampilkan form tambah berita (create).
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Simpan berita baru ke database (store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'ringkas'        => 'required|string|max:500',
            'konten'         => 'nullable|string',
            'kategori'       => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'terbit'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

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
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update berita di database (update).
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'ringkas'        => 'required|string|max:500',
            'konten'         => 'nullable|string',
            'kategori'       => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'terbit'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

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
