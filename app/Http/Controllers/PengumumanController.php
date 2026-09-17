<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
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
     * Simpan pengumuman baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'aktif'     => 'nullable|boolean',
        ], [
            'title.required'   => 'Judul pengumuman wajib diisi.',
            'title.max'        => 'Judul pengumuman maksimal 255 karakter.',
            'content.required' => 'Isi pengumuman wajib diisi.',
        ]);

        $validated['slug']  = Str::slug($request->title) . '-' . Str::random(5);
        $validated['aktif'] = $request->boolean('aktif');

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
     * Perbarui pengumuman di database.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'aktif'     => 'nullable|boolean',
        ], [
            'title.required'   => 'Judul pengumuman wajib diisi.',
            'title.max'        => 'Judul pengumuman maksimal 255 karakter.',
            'content.required' => 'Isi pengumuman wajib diisi.',
        ]);

        if ($request->title !== $pengumuman->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        $validated['aktif'] = $request->boolean('aktif');

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus pengumuman dari database.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}