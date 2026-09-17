<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role Super Admin jika belum ada
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Cek apakah user SuperAdmin sudah ada
        $superAdmin = User::where('username', 'superadmin')->first();

        if (!$superAdmin) {
            $password = '12345678';

            $superAdmin = User::create([
                'name'      => 'Super Administrator',
                'username'  => 'superadmin',
                'password'  => Hash::make($password),
                'is_active' => true,
                'role_id'   => $role->id,
            ]);

            $this->command->info('✅ Akun Super Admin berhasil dibuat!');
            $this->command->warn('Username : superadmin');
            $this->command->warn('Password : ' . $password);
        } else {
            $superAdmin->update([
                'password' => Hash::make('12345678'),
                'role_id'  => $role->id,
            ]);
            $this->command->info('⚡ Akun Super Admin sudah ada di database. Password telah di-reset menjadi: 12345678');
        }

        // Assign role ke user
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole($role);
            $this->command->info('✅ Role Super Admin berhasil di-assign ke user.');
        }
    }
}
