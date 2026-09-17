<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan website.
     */
    public function index()
    {
        // Ambil semua data pengaturan dari database
        $settings = Setting::pluck('value', 'key')->all();

        // Ambil array gambar hero dari database
        $heroImages = json_decode($settings['hero_images'] ?? '[]', true) ?: [];

        // Ambil array tautan media sosial dari database
        $sosmedLinks = json_decode($settings['sosmed_links'] ?? '[]', true) ?: [];

        return view('admin.setting.index', compact('settings', 'heroImages', 'sosmedLinks'));
    }

    /**
     * Simpan pengaturan website ke database.
     */
    public function update(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'hero_file.*'          => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'navbar_marquee_text'  => 'nullable|string|max:3000',
            'footer_address'      => 'nullable|string|max:1000',
            'footer_email'        => 'nullable|string|max:200',
            'footer_phone'        => 'nullable|string|max:100',
            'footer_google_maps'  => 'nullable|string|max:5000',
        ]);

        // 2. Simpan gambar latar hero (maksimal 4 gambar)
        $this->handleHeroImages($request);

        // 3. Simpan tautan media sosial
        $this->handleSosmedLinks($request);

        // 4. Simpan informasi footer
        $this->handleFooter($request);

        // 5. Simpan pengaturan navbar (marquee)
        $this->handleNavbar($request);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Helper untuk mengelola upload, ganti, dan hapus gambar hero (maksimal 4 slot).
     */
    private function handleHeroImages(Request $request)
    {
        // Gambar bawaan sistem yang tidak boleh dihapus dari disk
        $defaultImages = [
            'images/bg1.jpeg',
            'images/bg2.jpeg',
            'images/bg3.jpeg',
            'images/bg4.jpeg',
        ];

        $finalHeroImages = [];

        // Periksa 4 slot hero (indeks 0 sampai 3)
        for ($i = 0; $i < 4; $i++) {
            $isDeleted    = $request->input("hero_delete.$i") === '1';
            $existingPath = $request->input("hero_existing.$i");
            $hasNewFile   = $request->hasFile("hero_file.$i");

            // KASUS 1: Pengguna mengunggah gambar baru untuk slot ini
            if ($hasNewFile && !$isDeleted) {
                $file = $request->file("hero_file.$i");
                if ($file->isValid()) {
                    // Hapus gambar lama jika ada dan bukan gambar bawaan sistem
                    if ($existingPath && !in_array($existingPath, $defaultImages)) {
                        $oldFullPath = public_path($existingPath);
                        if (file_exists($oldFullPath)) {
                            @unlink($oldFullPath);
                        }
                    }

                    // Simpan file baru ke public/images/
                    $filename = 'hero_' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $uploadPath = public_path('images');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $file->move($uploadPath, $filename);

                    $finalHeroImages[] = 'images/' . $filename;
                }
            }
            // KASUS 2: Tidak ada upload baru, gambar lama tetap dipertahankan
            elseif ($existingPath && !$isDeleted) {
                $finalHeroImages[] = $existingPath;
            }
            // KASUS 3: Slot ditandai untuk dihapus
            elseif ($isDeleted && $existingPath) {
                // Hapus file dari server jika bukan gambar bawaan sistem
                if (!in_array($existingPath, $defaultImages)) {
                    $oldFullPath = public_path($existingPath);
                    if (file_exists($oldFullPath)) {
                        @unlink($oldFullPath);
                    }
                }
            }
        }

        // Ambil maksimal 4 gambar dan rapikan indeks array
        $finalHeroImages = array_values(array_slice($finalHeroImages, 0, 4));

        // Simpan ke tabel settings dengan key hero_images
        Setting::updateOrCreate(
            ['key' => 'hero_images'],
            ['value' => json_encode($finalHeroImages)]
        );
    }

    /**
     * Helper untuk menyimpan daftar media sosial.
     */
    private function handleSosmedLinks(Request $request)
    {
        $sosmedLinks = [];
        $icons  = $request->input('sosmed_icon', []);
        $labels = $request->input('sosmed_label', []);
        $urls   = $request->input('sosmed_url', []);

        foreach ($icons as $idx => $icon) {
            // Hanya simpan jika URL diisi
            if (!empty($urls[$idx])) {
                $sosmedLinks[] = [
                    'icon'  => $icon,
                    'label' => $labels[$idx] ?? '',
                    'url'   => $urls[$idx],
                ];
            }
        }

        Setting::updateOrCreate(
            ['key' => 'sosmed_links'],
            ['value' => json_encode($sosmedLinks)]
        );
    }

    /**
     * Helper untuk menyimpan field informasi footer.
     */
    private function handleFooter(Request $request)
    {
        $fields = ['footer_address', 'footer_email', 'footer_phone', 'footer_google_maps'];

        foreach ($fields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $request->input($field) ?? '']
            );
        }
    }

    /**
     * Helper untuk menyimpan pengaturan teks berjalan navbar.
     */
    private function handleNavbar(Request $request)
    {
        Setting::updateOrCreate(
            ['key' => 'navbar_marquee_enabled'],
            ['value' => $request->has('navbar_marquee_enabled') ? '1' : '0']
        );

        Setting::updateOrCreate(
            ['key' => 'navbar_marquee_text'],
            ['value' => $request->input('navbar_marquee_text') ?? '']
        );
    }
}
