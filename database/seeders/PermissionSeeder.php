<?php

namespace Database\Seeders;

use App\Constants\PermissionName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionNames = PermissionName::names();

        foreach ($permissionNames as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        $this->command->info('✅ Permissions berhasil dibuat/diperbarui.');
    }
}
