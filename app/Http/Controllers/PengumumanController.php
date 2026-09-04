<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    /**
     * Tampilkan daftar pengumuman.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === '1';
            $query->where('aktif', $status);
        }

        $pengumumen = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    /**
     * Tampilkan form tambah pengumuman baru.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Simpan pengumuman baru beserta upload gambar thumbnail.
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title'     => 'required|string|max:255',
    //         'content'   => 'required|string',
    //         'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'aktif'     => 'nullable|boolean',
    //     ], [
    //         'title.required'   => 'Judul pengumuman wajib diisi.',
    //         'title.max'        => 'Judul pengumuman maksimal 255 karakter.',
    //         'content.required' => 'Isi pengumuman wajib diisi.',
    //         'thumbnail.image'  => 'File harus berupa gambar.',
    //         'thumbnail.mimes'  => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
    //         'thumbnail.max'    => 'Ukuran gambar maksimal 2MB.',
    //     ]);

    //     $validated['slug']  = Str::slug($request->title) . '-' . Str::random(5);
    //     $validated['aktif'] = $request->boolean('aktif');

    //     // Cek file fisik sebelum diproses ke storeAs() untuk mencegah ValueError di PHP 8.4
    //     if ($request->hasFile('thumbnail')) {
    //         $file = $request->file('thumbnail');
    //         dd([
    //             'class' => get_class($file),
    //             'name' => $file->getClientOriginalName(),
    //             'size' => $file->getSize(),
    //             'mime' => $file->getMimeType(),
    //             'valid' => $file->isValid(),
    //             'error' => $file->getError(),
    //             'errorMessage' => $file->getErrorMessage(),
    //             'path' => $file->path(),
    //             'realPath' => $file->getRealPath(),
    //         ]);
    //         if ($file->isValid()) {
    //             $ext = $file->getClientOriginalExtension();
    //             $name = time().'_'.Str::random(10).'.'.$ext;
    //             $validated['thumbnail'] = Storage::disk('public')->
    //             $file = $request->file('thumbnail');putFileAs('pengumuman', $file, $name);
    //         }
    //     }

    //     dd($validated);
    //     Pengumuman::create($validated);

    //     return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    // }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title'     => 'required|string|max:255',
        'content'   => 'required|string',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'aktif'     => 'nullable|boolean',
    ], [
        'title.required'   => 'Judul pengumuman wajib diisi.',
        'title.max'        => 'Judul pengumuman maksimal 255 karakter.',
        'content.required' => 'Isi pengumuman wajib diisi.',
        'thumbnail.image'  => 'File harus berupa gambar.',
        'thumbnail.mimes'  => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
        'thumbnail.max'    => 'Ukuran gambar maksimal 2MB.',
    ]);

    $validated['slug']  = Str::slug($request->title) . '-' . Str::random(5);
    $validated['aktif'] = $request->boolean('aktif');

    if ($request->hasFile('thumbnail')) {
        $file = $request->file('thumbnail');

        if ($file->isValid()) {
            $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
            $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);

            $validated['thumbnail'] = $file->storeAs('pengumuman', $name, 'public');
        } else {
            unset($validated['thumbnail']);
        }
    } else {
        unset($validated['thumbnail']);
    }

    Pengumuman::create($validated);

    return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
}

    /**
     * Tampilkan form edit pengumuman.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Perbarui pengumuman di database beserta penggantian gambar.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'aktif'     => 'nullable|boolean',
        ], [
            'title.required'   => 'Judul pengumuman wajib diisi.',
            'title.max'        => 'Judul pengumuman maksimal 255 karakter.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'thumbnail.image'  => 'File harus berupa gambar.',
            'thumbnail.mimes'  => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'thumbnail.max'    => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->title !== $pengumuman->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        $validated['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $realPath = $file ? $file->getRealPath() : null;

            if ($file && $file->isValid() && !empty($realPath) && file_exists($realPath)) {
                $this->deleteThumbnail($pengumuman->thumbnail);

                $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['thumbnail'] = $file->storeAs('pengumuman', $name, 'public');
            } else {
                unset($validated['thumbnail']);
            }
        } else {
            unset($validated['thumbnail']);
        }

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus pengumuman beserta file gambar thumbnail dari storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $this->deleteThumbnail($pengumuman->thumbnail);

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * Hapus file thumbnail dari storage secara aman (bebas dari ValueError).
     */
    private function deleteThumbnail(?string $path): void
    {
        if (!empty($path) && is_string($path) && strlen(trim($path)) > 0) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}