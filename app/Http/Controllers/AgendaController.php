<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    /**
     * Tampilkan daftar agenda.
     */
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === '1' ? true : false;
            $query->where('aktif', $status);
        }

        $agendas = $query->orderBy('start_date', 'asc')->latest('id')->paginate(10)->withQueryString();

        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Tampilkan form tambah agenda baru.
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Simpan agenda baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'aktif'       => 'nullable|boolean',
        ], [
            'title.required'          => 'Judul agenda wajib diisi.',
            'title.max'               => 'Judul agenda maksimal 255 karakter.',
            'start_date.required'     => 'Tanggal mulai agenda wajib diisi.',
            'start_date.date'         => 'Format tanggal mulai tidak valid.',
            'end_date.required'       => 'Tanggal selesai agenda wajib diisi.',
            'end_date.date'           => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
        ]);

        $validated['slug']  = Str::slug($request->title) . '-' . Str::random(5);
        $validated['aktif'] = $request->has('aktif') ? true : false;

        Agenda::create($validated);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit agenda.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    /**
     * Perbarui data agenda di database.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'aktif'       => 'nullable|boolean',
        ], [
            'title.required'          => 'Judul agenda wajib diisi.',
            'title.max'               => 'Judul agenda maksimal 255 karakter.',
            'start_date.required'     => 'Tanggal mulai agenda wajib diisi.',
            'start_date.date'         => 'Format tanggal mulai tidak valid.',
            'end_date.required'       => 'Tanggal selesai agenda wajib diisi.',
            'end_date.date'           => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
        ]);

        if ($request->title !== $agenda->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        $validated['aktif'] = $request->has('aktif') ? true : false;

        $agenda->update($validated);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Hapus data agenda dari database.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus!');
    }
}
