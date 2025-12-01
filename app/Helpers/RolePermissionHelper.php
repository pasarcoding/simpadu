<?php

if (!function_exists('getPermissionInfo')) {
    function getPermissionInfo($moduleName)
    {
        static $data = null;

        if ($data == null) {
            $data = [
                'dashboard' => [
                    'name' => 'Dashboard',
                    'main' => 'dashboard_view',
                ],
                'resident' => [
                    'name' => 'Data Penduduk',
                    'main' => 'resident_view',
                ],
                'resident_detail' => [
                    'name' => 'Detail Data Penduduk',
                    'main' => 'resident_detail_view',
                ],
                'resident_import' => [
                    'name' => 'Import Data Penduduk',
                    'main' => 'resident_import_view',
                ],
                'resident_export' => [
                    'name' => 'Export Data Penduduk',
                    'main' => 'resident_export_view',
                ],
                'resident_form' => [
                    'name' => 'Form Tambahan Data Penduduk',
                    'main' => 'resident_form_view',
                ],
                'information' => [
                    'name' => 'Pengumuman',
                    'main' => 'information_view',
                ],
                'news' => [
                    'name' => 'Berita',
                    'main' => 'news_view',
                ],
                'news_comment' => [
                    'name' => 'Komentar Berita',
                    'main' => 'news_comment_view',
                ],
                'village_official_greeting' => [
                    'name' => 'Sambutan Kepala Desa',
                    'main' => 'village_official_greeting_view',
                ],
                'village_official_history' => [
                    'name' => 'Sejarah Desa',
                    'main' => 'village_official_history_view',
                ],
                'village_official_vision_mission' => [
                    'name' => 'Visi & Misi Desa',
                    'main' => 'village_official_vision_mission_view',
                ],
                'village_official_member' => [
                    'name' => 'Anggota Aparatur Desa',
                    'main' => 'village_official_member_view',
                ],
                'gallery' => [
                    'name' => 'Galeri',
                    'main' => 'gallery_view',
                ],
                'budget' => [
                    'name' => 'Transparasi Anggaran',
                    'main' => 'budget_view',
                ],
                'budget_detail' => [
                    'name' => 'Detail Anggaran',
                    'main' => 'budget_detail_view',
                ],
                'synergy_program' => [
                    'name' => 'Program Sinergi',
                    'main' => 'synergy_program_view',
                ],
                'product' => [
                    'name' => 'Produk',
                    'main' => 'product_view',
                ],
                'appearance_menu' => [
                    'name' => 'Menu',
                    'main' => 'appearance_menu_view',
                ],
                'appearance_page' => [
                    'name' => 'Halaman',
                    'main' => 'appearance_page_view',
                ],
                'access_user' => [
                    'name' => 'Pengguna',
                    'main' => 'access_user_view',
                ],
                'access_role_permission' => [
                    'name' => 'Peran & Hak Akses',
                    'main' => 'access_role_permission_view',
                ],
                'e_letter_template' => [
                    'name' => 'Template Surat',
                    'main' => 'e_letter_template_view',
                ],
                'e_letter_submission' => [
                    'name' => 'Pengajuan Surat',
                    'main' => 'e_letter_submission_view',
                ],
                'e_letter_submission_detail' => [
                    'name' => 'Detail Pengajuan Surat',
                    'main' => 'e_letter_submission_detail_view',
                ],
                'critique_suggestion' => [
                    'name' => 'Kritik & Saran',
                    'main' => 'critique_suggestion_view',
                ],
                'setting' => [
                    'name' => 'Pengaturan',
                    'main' => 'setting_manage',
                ],
            ];
        }

        return $data[$moduleName];
    }
}
