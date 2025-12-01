<?php

namespace App\Constants;

use PDO;

class PermissionName
{

    public static $PERMISSIONS = [
        // Hak Akses Dashboard
        'dashboard_view' => 'Lihat Dashboard',

        // Hak Akses Data Penduduk
        'resident_view' => 'Lihat Data Penduduk',
        'resident_create' => 'Tambah Data Penduduk',
        'resident_edit' => 'Edit Data Penduduk',
        'resident_delete' => 'Hapus Data Penduduk',
        'resident_detail_view' => 'Lihat Detail Data Penduduk',
        'resident_import_view' => 'Import Data Penduduk',
        'resident_export_view' => 'Export Data Penduduk',
        'resident_form_view' => 'Lihat Form Tambahan Data Penduduk',
        'resident_form_create' => 'Tambah Form Tambahan Data Penduduk',
        'resident_form_edit' => 'Edit Form Tambahan Data Penduduk',
        'resident_form_delete' => 'Hapus Form Tambahan Data Penduduk',

        // Hak Akses Pengumuman
        'information_view' => 'Lihat Pengumuman',
        'information_create' => 'Tambah Pengumuman',
        'information_edit' => 'Edit Pengumuman',
        'information_delete' => 'Hapus Pengumuman',

        // Hak Akses Berita
        'news_view' => 'Lihat Berita',
        'news_create' => 'Tambah Berita',
        'news_edit' => 'Edit Berita',
        'news_delete' => 'Hapus Berita',
        'news_comment_view' => 'Lihat Komentar Berita',
        'news_comment_delete' => 'Hapus Komentar Berita',

        // Hak Akses Aparatur Desa
        // Submenu: Sambutan
        'village_official_greeting_view' => 'Lihat Sambutan Kepala Desa',
        'village_official_greeting_edit' => 'Edit Sambutan Kepala Desa',
        'village_official_greeting_delete' => 'Reset Sambutan Kepala Desa',
        // Submenu: Sejarah
        'village_official_history_view' => 'Lihat Sejarah Desa',
        'village_official_history_edit' => 'Edit Sejarah Desa',
        'village_official_history_delete' => 'Reset Sejarah Desa',
        // Submenu: Visi & Misi
        'village_official_vision_mission_view' => 'Lihat Visi & Misi Desa',
        'village_official_vision_mission_edit' => 'Edit Visi & Misi Desa',
        'village_official_vision_mission_delete' => 'Reset Visi & Misi Desa',
        // Submenu: Anggota
        'village_official_member_view' => 'Lihat Anggota Aparatur Desa',
        'village_official_member_create' => 'Tambah Anggota Aparatur Desa',
        'village_official_member_edit' => 'Edit Anggota Aparatur Desa',
        'village_official_member_delete' => 'Hapus Anggota Aparatur Desa',

        // Hak Akses Galeri
        'gallery_view' => 'Lihat Galeri',
        'gallery_create' => 'Tambah Galeri',
        'gallery_delete' => 'Hapus Galeri',

        // Hak Akses Transparasi Anggaran
        'budget_view' => 'Lihat Transparasi Anggaran',
        'budget_create' => 'Tambah Anggaran',
        'budget_edit' => 'Edit Anggaran',
        'budget_delete' => 'Hapus Anggaran',
        'budget_detail_view' => 'Lihat Detail Anggaran',
        'budget_detail_create' => 'Tambah Detail Anggaran',
        'budget_detail_delete' => 'Hapus Detail Anggaran',

        // Hak Akses Program Sinergi
        'synergy_program_view' => 'Lihat Program Sinergi',
        'synergy_program_create' => 'Tambah Program Sinergi',
        'synergy_program_delete' => 'Hapus Program Sinergi',

        // Hak Akses Produk
        'product_view' => 'Lihat Daftar Produk',
        'product_create' => 'Tambah Produk',
        'product_edit' => 'Edit Produk',
        'product_delete' => 'Hapus Produk',

        // Hak Akses Tampilan
        // Submenu: Menu
        'appearance_menu_view' => 'Lihat Daftar Menu',
        'appearance_menu_create' => 'Tambah Menu',
        'appearance_menu_edit' => 'Edit Menu',
        'appearance_menu_delete' => 'Hapus Menu',
        // Submenu: Halaman
        'appearance_page_view' => 'Lihat Daftar Halaman',
        'appearance_page_create' => 'Tambah Halaman',
        'appearance_page_edit' => 'Edit Halaman',
        'appearance_page_delete' => 'Hapus Halaman',

        // Pengguna & Hak Akses
        // Submenu: Pengguna
        'access_user_view' => 'Lihat Daftar Pengguna',
        'access_user_create' => 'Tambah Pengguna',
        'access_user_edit' => 'Edit Pengguna',
        'access_user_delete' => 'Hapus Pengguna',
        // Submenu: Peran & Hak Akses
        'access_role_permission_view' => 'Lihat Daftar Peran & Hak Akses',
        'access_role_permission_create' => 'Tambah Peran & Hak Akses',
        'access_role_permission_edit' => 'Edit Peran & Hak Akses',
        'access_role_permission_delete' => 'Hapus Peran & Hak Akses',

        // E-Surat
        // Submenu: Template Surat
        'e_letter_template_view' => 'Lihat Template Surat',
        'e_letter_template_create' => 'Tambah Template Surat',
        'e_letter_template_edit' => 'Edit Template Surat',
        'e_letter_template_delete' => 'Hapus Template Surat',
        // Submenu: Pengajuan Surat
        'e_letter_submission_view' => 'Lihat Pengajuan Surat',
        'e_letter_submission_edit' => 'Edit Pengajuan Surat',
        'e_letter_submission_delete' => 'Hapus Pengajuan Surat',
        'e_letter_submission_detail_view' => 'Lihat Detail Pengajuan Surat',

        // Kritik & Saran
        'critique_suggestion_view' => 'Lihat Kritik & Saran',
        'critique_suggestion_delete' => 'Hapus Kritik & Saran',

        // Hak Akses Setting
        'setting_manage' => 'Update Pengaturan',
    ];

    public static function __callStatic($name, $arguments)
    {
        $key = strtolower($name);
        if (array_key_exists($key, self::$PERMISSIONS)) {
            return $key;
        }

        throw new \BadMethodCallException(sprintf(
            'Permission constant "%s" not found.',
            $name
        ));
    }

    public static function names()
    {
        return array_keys(self::$PERMISSIONS);
    }

    public static function getGroupModule()
    {
        $grouped = [];

        foreach (self::$PERMISSIONS as $key => $description) {
            $lastUnderscore = strrpos($key, '_');

            if ($lastUnderscore !== false) {
                $moduleSlug = substr($key, 0, $lastUnderscore);
            } else {
                $moduleSlug = $key;
            }

            if (!isset($grouped[$moduleSlug])) {
                $grouped[$moduleSlug] = [];
            }

            $grouped[$moduleSlug][$key] = $description;
        }

        return $grouped;
    }

    public static function getPermissionsByModule($moduleName)
    {
        $grouped = self::getGroupModule();
        $moduleName = strtolower($moduleName);

        if (array_key_exists($moduleName, $grouped)) {
            return $grouped[$moduleName];
        }

        return [];
    }
}
