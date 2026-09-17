<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PosterController extends Controller
{
    public function index(Request $request)
    {
        $query = Poster::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $posters = $query->latest('tanggal_publikasi')->paginate(10)->withQueryString();

        return view('admin.poster.index', compact('posters'));
    }

    public function create()
    {
        return view('admin.poster.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'aktif' => 'nullable|boolean',
            'foto_poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->judul) . '-' . Str::random(6);
        $validated['aktif'] = $request->has('aktif') ? true : false;

        if ($request->hasFile('foto_poster')) {
            $file = $request->file('foto_poster');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['foto_poster'] = $file->storeAs('poster', $name, 'public');
            }
        }

        Poster::create($validated);

        return redirect()->route('poster.index')->with('success', 'Poster Digital berhasil ditambahkan!');
    }

    public function edit(Poster $poster)
    {
        return view('admin.poster.edit', compact('poster'));
    }

    public function update(Request $request, Poster $poster)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'aktif' => 'nullable|boolean',
            'foto_poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->judul) . '-' . Str::random(6);
        $validated['aktif'] = $request->has('aktif') ? true : false;

        if ($request->hasFile('foto_poster')) {
            $file = $request->file('foto_poster');
            if ($file->isValid()) {
                $this->deleteImage($poster->foto_poster);
                $ext = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
                $name = time() . '_' . Str::random(10) . '.' . strtolower($ext);
                $validated['foto_poster'] = $file->storeAs('poster', $name, 'public');
            }
        } else {
            unset($validated['foto_poster']);
        }

        $poster->update($validated);

        return redirect()->route('poster.index')->with('success', 'Poster Digital berhasil diperbarui!');
    }

    public function destroy(Poster $poster)
    {
        $this->deleteImage($poster->foto_poster);

        $poster->delete();

        return redirect()->route('poster.index')->with('success', 'Poster Digital berhasil dihapus!');
    }

    private function deleteImage(?string $path): void
    {
        if (!empty($path) && is_string($path) && strlen(trim($path)) > 0) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
