<?php

namespace App\Http\Controllers;

use App\Models\Unduhan;
use App\Models\KategoriUnduhan;
use App\Models\JenisUnduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnduhanController extends Controller
{
    public function index(Request $request)
    {
        $query = Unduhan::with(['kategoriUnduhan', 'jenisUnduhan']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_unduhan_id', $request->input('kategori'));
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_unduhan_id', $request->input('jenis'));
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->input('status') === '1');
        }

        $unduhans = $query->latest()->paginate(10)->withQueryString();
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();

        return view('admin.unduhan.index', compact('unduhans', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();
        return view('admin.unduhan.create', compact('kategoris'));
    }

    public function publicIndex(Request $request)
    {
        $query = Unduhan::with(['kategoriUnduhan', 'jenisUnduhan'])
            ->where('aktif', true);

        if ($request->filled('kategori')) {
            $query->byKategori($request->input('kategori'));
        }

        if ($request->filled('jenis')) {
            $query->byJenis($request->input('jenis'));
        }

        if ($request->filled('tahun')) {
            $query->byTahun($request->input('tahun'));
        }

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $unduhans = $query->latest()->paginate(12);
        $kategoris = KategoriUnduhan::withCount('unduhans')->aktif()->ordered()->get();

        // Get available years for filter
        $tahuns = Unduhan::where('aktif', true)
            ->whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.unduhan.index', compact('unduhans', 'kategoris', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request, true);

        // Auto generate title, description & slug
        $validated['title'] = $validated['judul'];
        $validated['description'] = $validated['deskripsi'] ?? null;
        $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        $validated['aktif'] = $request->boolean('aktif');

        // Set default tanggal publikasi jika tidak diisi
        if (empty($validated['tanggal_publikasi'])) {
            $validated['tanggal_publikasi'] = now();
        }

        Unduhan::create($validated);

        return redirect()->route('unduhan.index')->with('success', 'Dokumen unduhan berhasil ditambahkan!');
    }

    public function edit(Unduhan $unduhan)
    {
        $kategoris = KategoriUnduhan::aktif()->ordered()->get();
        $jenises = [];

        if ($unduhan->kategori_unduhan_id) {
            $jenises = JenisUnduhan::where('kategori_unduhan_id', $unduhan->kategori_unduhan_id)
                ->aktif()
                ->ordered()
                ->get();
        }

        return view('admin.unduhan.edit', compact('unduhan', 'kategoris', 'jenises'));
    }

    public function update(Request $request, Unduhan $unduhan)
    {
        $validated = $this->validateData($request);
        $validated['title'] = $validated['judul'];
        $validated['description'] = $validated['deskripsi'] ?? null;
        $validated['aktif'] = $request->boolean('aktif');

        // Auto generate slug jika judul berubah
        if ($request->input('judul') !== $unduhan->judul) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        }

        $unduhan->update($validated);

        return redirect()->route('unduhan.index')->with('success', 'Dokumen unduhan berhasil diperbarui!');
    }

    public function destroy(Unduhan $unduhan)
    {
        $unduhan->delete();

        return redirect()->route('unduhan.index')->with('success', 'Dokumen unduhan berhasil dihapus!');
    }

    /**
     * Download/redirect ke Google Drive dengan tracking.
     */
    public function download(string $slug)
    {
        $unduhan = Unduhan::where('slug', $slug)->where('aktif', true)->firstOrFail();

        // Log the download attempt for analytics (optional)
        \Log::info('Document download attempt', [
            'document_id' => $unduhan->id,
            'document_title' => $unduhan->judul ?: $unduhan->title,
            'user_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Increment download count
        $unduhan->incrementDownload();

        // Jika ada Google Drive URL, redirect ke sana (direct download jika memungkinkan)
        if ($unduhan->hasGoogleDrive()) {
            return redirect()->away($unduhan->getDirectDownloadUrl());
        }

        // Fallback: jika ada file lokal (backward compatibility)
        if ($unduhan->file && Storage::disk('public')->exists($unduhan->file)) {
            return response()->download(
                Storage::disk('public')->path($unduhan->file),
                ($unduhan->judul ?: $unduhan->title) . '.' . pathinfo($unduhan->file, PATHINFO_EXTENSION)
            );
        }

        // Fallback untuk URL lama (backward compatibility)
        if ($unduhan->url) {
            return redirect()->away($unduhan->url);
        }

        abort(404, 'File unduhan tidak ditemukan.');
    }

    private function validateData(Request $request, bool $isCreate = false): array
    {
        $rules = [
            'kategori_unduhan_id' => 'required|exists:kategori_unduhans,id',
            'jenis_unduhan_id'    => 'required|exists:jenis_unduhans,id',
            'judul'               => 'required|string|max:255',
            'tahun'               => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'deskripsi'           => 'nullable|string',
            'google_drive_url'    => 'required|url|max:500',
            'tanggal_publikasi'   => 'nullable|date',
            'aktif'               => 'nullable|boolean',
        ];

        $messages = [
            'kategori_unduhan_id.required' => 'Kategori wajib dipilih.',
            'jenis_unduhan_id.required'    => 'Jenis dokumen wajib dipilih.',
            'judul.required'               => 'Judul dokumen wajib diisi.',
            'google_drive_url.required'    => 'Link Google Drive wajib diisi.',
            'google_drive_url.url'         => 'Format link Google Drive tidak valid.',
            'tahun.integer'                => 'Tahun harus berupa angka.',
            'tahun.min'                    => 'Tahun tidak valid.',
            'tahun.max'                    => 'Tahun tidak valid.',
        ];

        return $request->validate($rules, $messages);
    }
}
