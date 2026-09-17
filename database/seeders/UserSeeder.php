<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Super Administrator',
                'username'  => 'superadmin',
                'password'  => '12345678',
                'is_active' => true,
                'role'      => 'Super Admin',
            ],
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'password'  => '12345678',
                'is_active' => true,
                'role'      => 'Admin',
            ],
            [
                'name'      => 'Editor Konten',
                'username'  => 'editor',
                'password'  => '12345678',
                'is_active' => true,
                'role'      => 'Editor',
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role'];
            unset($userData['role']);

            $role = Role::where('name', $roleName)->first();

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                [
                    'name'      => $userData['name'],
                    'password'  => Hash::make($userData['password']),
                    'is_active' => $userData['is_active'],
                    'role_id'   => $role?->id,
                ]
            );

            // Assign role via Spatie
            if ($role && !$user->hasRole($roleName)) {
                $user->assignRole($role);
            }

            $this->command->info("✅ User '{$userData['username']}' dengan role '{$roleName}' siap.");
        }

        $this->command->newLine();
        $this->command->warn('📋 Daftar akun:');
        $this->command->table(
            ['Username', 'Password', 'Role'],
            collect($users)->map(fn ($u) => [$u['username'], '12345678', $u['role'] ?? '-'])
        );
    }
}
