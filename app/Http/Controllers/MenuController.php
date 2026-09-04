<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Tampilkan daftar menu.
     */
    public function index(Request $request)
    {
        $query = Menu::with(['parent', 'children', 'page']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $menus = $query->orderBy('urutan')->get();

        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')
            ->orderBy('urutan')
            ->get();

        return view('admin.menu.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'urutan'    => 'required|integer|min:1',
            'tipe'      => 'required|in:parent,internal,external',
            'url'       => 'nullable|string|max:255',
        ]);

        $exists = Menu::where('parent_id', $request->parent_id)
            ->where('urutan', $request->urutan)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'urutan' => 'Urutan sudah digunakan pada level menu ini.'
                ]);
        }

        Menu::create([
            'nama'      => $validated['nama'],
            'slug'      => Str::slug($validated['nama']),
            'parent_id' => $validated['parent_id'],
            'urutan'    => $validated['urutan'],
            'tipe'      => $validated['tipe'],
            'url'       => $validated['url'] ?? null,
            'aktif'     => true,
        ]);

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('urutan')
            ->get();

        return view('admin.menu.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'urutan'    => 'required|integer|min:1',
            'tipe'      => 'required|in:parent,internal,external',
            'url'       => 'nullable|string|max:255',
        ]);

        $exists = Menu::where('parent_id', $request->parent_id)
            ->where('urutan', $request->urutan)
            ->where('id', '!=', $menu->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'urutan' => 'Urutan sudah digunakan pada level menu ini.'
                ]);
        }

        $menu->update([
            'nama'      => $validated['nama'],
            'slug'      => Str::slug($validated['nama']),
            'parent_id' => $validated['parent_id'],
            'urutan'    => $validated['urutan'],
            'tipe'      => $validated['tipe'],
            'url'       => $validated['url'] ?? null,
        ]);

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        // Proteksi 1: Cek apakah menu memiliki submenu
        if ($menu->children()->count() > 0) {
            return redirect()
                ->route('menu.index')
                ->with('error', 'Menu tidak dapat dihapus karena masih memiliki submenu.');
        }

        // Proteksi 2: Cek apakah menu digunakan oleh sebuah Page
        if ($menu->page()->count() > 0) {
            return redirect()
                ->route('menu.index')
                ->with('error', 'Menu tidak dapat dihapus karena sedang digunakan oleh halaman (Page).');
        }

        $menu->delete();

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}