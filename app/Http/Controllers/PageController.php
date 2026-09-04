<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Tampilkan daftar halaman.
     */
    public function index(Request $request)
    {
        $pages = Page::with('menu')
            ->latest()
            ->paginate(10);

        return view('admin.page.index', compact('pages'));
    }

    /**
     * Tampilkan form tambah halaman.
     */
    public function create()
    {
        $menus = Menu::orderBy('urutan')->get();

        return view('admin.page.create', compact('menus'));
    }

    /**
     * Simpan halaman baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id'    => 'required|exists:menus,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'konten'     => 'nullable|string',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->judul);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        if ($request->hasFile('thumbnail')) {

            $file = $request->file('thumbnail');

            if ($file->isValid()) {

                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                $validated['thumbnail'] = $file->storeAs(
                    'pages',
                    $filename,
                    'public'
                );
            }
        }

        Page::create($validated);

        return redirect()
            ->route('page.index')
            ->with('success', 'Halaman berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit halaman.
     */
    public function edit(Page $page)
    {
        $menus = Menu::orderBy('urutan')->get();

        return view('admin.page.edit', compact('page', 'menus'));
    }

    /**
     * Update halaman.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'menu_id'    => 'required|exists:menus,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'konten'     => 'nullable|string',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->judul);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        if ($request->hasFile('thumbnail')) {

            if (!empty($page->thumbnail)) {
                Storage::disk('public')->delete($page->thumbnail);
            }

            $file = $request->file('thumbnail');

            if ($file->isValid()) {

                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                $validated['thumbnail'] = $file->storeAs(
                    'pages',
                    $filename,
                    'public'
                );
            }
        }

        $page->update($validated);

        return redirect()
            ->route('page.index')
            ->with('success', 'Halaman berhasil diperbarui!');
    }

    /**
     * Hapus halaman.
     */
    public function destroy(Page $page)
    {
        if (!empty($page->thumbnail)) {
            Storage::disk('public')->delete($page->thumbnail);
        }

        $page->delete();

        return redirect()
            ->route('page.index')
            ->with('success', 'Halaman berhasil dihapus!');
    }
}