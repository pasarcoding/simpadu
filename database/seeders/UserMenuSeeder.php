<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Appearance\App\Models\AppearanceMenu;

class UserMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== Header =====
        // Profil Desa
        AppearanceMenu::create([
            'id' => 1,
            'name' => 'Profil Desa',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-0',
            'order' => '1',
        ]);
        AppearanceMenu::create([
            'id' => 2,
            'parent_id' => 1,
            'name' => 'Aparatur Desa',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-1',
            'order' => '1',
        ]);
        AppearanceMenu::create([
            'id' => 3,
            'parent_id' => 1,
            'name' => 'Sejarah Desa',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-2',
            'order' => '2',
        ]);
        AppearanceMenu::create([
            'id' => 4,
            'parent_id' => 1,
            'name' => 'Visi & Misi Desa',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-3',
            'order' => '3',
        ]);

        // Informasi Desa
        AppearanceMenu::create([
            'id' => 5,
            'name' => 'Informasi Desa',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-0',
            'order' => '2',
        ]);
        AppearanceMenu::create([
            'id' => 6,
            'parent_id' => 5,
            'name' => 'Pengumuman',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-4',
            'order' => '1',
        ]);
        AppearanceMenu::create([
            'id' => 7,
            'parent_id' => 5,
            'name' => 'Berita',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-5',
            'order' => '2',
        ]);

        // Data Statistik
        AppearanceMenu::create([
            'id' => 8,
            'name' => 'Data Statistik',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-6',
            'order' => '3',
        ]);

        // Kontak
        AppearanceMenu::create([
            'id' => 9,
            'name' => 'Kontak',
            'type' => 'header',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-7',
            'order' => '4',
        ]);

        // ===== Footer =====
        // Pengumuman
        AppearanceMenu::create([
            'id' => 10,
            'name' => 'Pengumuman',
            'type' => 'footer',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-4',
            'order' => '5',
        ]);
        // Visi & Misi Desa
        AppearanceMenu::create([
            'id' => 11,
            'name' => 'Visi & Misi Desa',
            'type' => 'footer',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-3',
            'order' => '6',
        ]);
        // Sejarah Desa
        AppearanceMenu::create([
            'id' => 12,
            'name' => 'Sejarah Desa',
            'type' => 'footer',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-2',
            'order' => '7',
        ]);
        // Aparatur Desa
        AppearanceMenu::create([
            'id' => 13,
            'name' => 'Aparatur Desa',
            'type' => 'footer',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-1',
            'order' => '8',
        ]);
        // Produk
        AppearanceMenu::create([
            'id' => 14,
            'name' => 'Produk Desa',
            'type' => 'footer',
            'behaviour_target' => 'keep',
            'page_origin' => 'in',
            'default_page_id' => 'um-8',
            'order' => '9',
        ]);
        $this->command->info("✅ User Menu berhasil dibuat.");
    }
}
