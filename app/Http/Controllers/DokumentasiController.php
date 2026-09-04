<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumentasiController extends Controller
{
    /**
     * Tampilkan daftar dokumentasi (index) dengan fitur pencarian dan filter tipe.
     */
    public function index(Request $request)
    {
        $query = Dokumentasi::query();

        // Pencarian Berdasarkan Judul
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }

        // Filter Berdasarkan Tipe Media (gambar / video)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }

        // Ambil data terbaru dengan pagination & pertahankan query parameter
        $dokumentasis = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('admin.dokumentasi.index', compact('dokumentasis'));
    }

    /**
     * Tampilkan form tambah dokumentasi (create).
     */
    public function create()
    {
        return view('admin.dokumentasi.create');
    }

    /**
     * Simpan dokumentasi baru ke database (store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'tanggal'   => 'required|date',
            'tipe'      => 'required|in:gambar,video',
            'file_path' => 'nullable|required_if:tipe,gambar|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'url'       => 'nullable|required_if:tipe,video|url',
        ]);

        if ($request->tipe === 'gambar' && $request->hasFile('file_path')) {
            $file = $request->file('file_path');

            if ($file && $file->isValid()) {
                $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);

                $validated['file_path'] = $file->storeAs('dokumentasi', $name, 'public');
            } else {
                unset($validated['file_path']);
            }
            $validated['url'] = null;
        } elseif ($request->tipe === 'video') {
            $validated['file_path'] = null;
        }

        Dokumentasi::create($validated);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit dokumentasi (edit).
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        return view('admin.dokumentasi.edit', compact('dokumentasi'));
    }

    /**
     * Update dokumentasi di database (update).
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'tanggal'   => 'required|date',
            'tipe'      => 'required|in:gambar,video',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'url'       => 'nullable|required_if:tipe,video|url',
        ]);

        if ($request->tipe === 'gambar') {
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $realPath = $file ? $file->getRealPath() : null;

                if ($file && $file->isValid() && !empty($realPath) && file_exists($realPath)) {
                    // Hapus file gambar lama jika ada
                    $this->deleteFile($dokumentasi->file_path);

                    $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                    $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                    $validated['file_path'] = $file->storeAs('dokumentasi', $name, 'public');
                } else {
                    unset($validated['file_path']);
                }
            } else {
                // Pertahankan file_path lama jika tidak mengunggah file baru
                $validated['file_path'] = $dokumentasi->file_path;
            }
            $validated['url'] = null;
        } elseif ($request->tipe === 'video') {
            // Hapus gambar lama jika tipe diubah dari gambar menjadi video
            if ($dokumentasi->file_path) {
                $this->deleteFile($dokumentasi->file_path);
            }
            $validated['file_path'] = null;
        }

        $dokumentasi->update($validated);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    /**
     * Hapus dokumentasi dari database (destroy).
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        $this->deleteFile($dokumentasi->file_path);

        $dokumentasi->delete();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus!');
    }

    /**
     * Helper untuk menghapus file dari storage secara aman.
     */
    private function deleteFile(?string $path): void
    {
        if (!empty($path) && is_string($path) && strlen(trim($path)) > 0) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}