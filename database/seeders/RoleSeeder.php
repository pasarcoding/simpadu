<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['id' => '1'],
            [
                'id' => '1',
                'email' => 'admin@admin.com',
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
            ]
        );
        $this->command->info("✅ User Admin '{$adminUser->email}' berhasil dibuat/ditemukan.");

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $this->command->info('✅ Role Admin berhasil dibuat.');

        $allPermissions = Permission::pluck('name');
        $adminRole->syncPermissions($allPermissions);
        $this->command->info('✅ Semua Permissions disinkronkan ke Role Admin.');

        if ($adminUser) {
            $adminUser->syncRoles(['admin']);
            $this->command->info("✅ Role 'admin' ditugaskan ke User: " . $adminUser->email);
        }
    }
}
