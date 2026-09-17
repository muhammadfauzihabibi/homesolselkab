<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar nama menu/modul yang ada di sistem
        $modules = [
            'berita',
            'poster',
            'opd',
            'kecamatan',
            'aplikasi-dinas',
            'layanan-publik',
            'pengumuman',
            'agenda',
            'dokumentasi',
            'unduhan',
            'menu',
            'page',
            'sarana-prasarana',
        ];

        foreach ($modules as $module) {
            Permission::firstOrCreate(['name' => $module, 'guard_name' => 'web']);
        }

        $this->command->info('✅ Permission berdasarkan modul/menu berhasil dibuat!');
    }
}
