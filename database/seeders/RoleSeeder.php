<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $editor     = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);

        // Ambil semua permission
        $allPermissions = Permission::all();

        // Super Admin mendapat semua permission
        $superAdmin->syncPermissions($allPermissions);

        // Admin mendapat semua permission kecuali yang sensitif (bisa disesuaikan)
        $admin->syncPermissions($allPermissions);

        // Editor hanya bisa akses modul konten
        $editorPermissions = Permission::whereIn('name', [
            'berita',
            'poster',
            'pengumuman',
            'agenda',
            'dokumentasi',
            'unduhan',
            'page',
        ])->get();
        $editor->syncPermissions($editorPermissions);

        $this->command->info('✅ Roles berhasil dibuat: Super Admin, Admin, Editor');
    }
}
