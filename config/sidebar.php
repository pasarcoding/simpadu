<?php

use App\Constants\PermissionName;

return [
    'menu' => [
        [
            'title' => 'Dashboard',
            'icon' => 'dashboard',
            'route' => 'admin.dashboard',
            'route_is_active' => 'admin.dashboard',
            'permissions' => [PermissionName::dashboard_view()],
        ],
        [
            'title' => 'Data Penduduk',
            'icon' => 'team',
            'route' => 'admin.resident.index',
            'route_is_active' => 'admin.resident.*',
            'permissions' => [PermissionName::resident_view()],
        ],
        [
            'title' => 'Pengumuman',
            'icon' => 'split-cells',
            'route' => 'admin.information.index',
            'route_is_active' => 'admin.information.*',
            'permissions' => [PermissionName::information_view()],
        ],
        [
            'title' => 'Berita',
            'icon' => 'read',
            'route' => 'admin.news.index',
            'route_is_active' => 'admin.news.*',
            'permissions' => [PermissionName::news_view()],
        ],
        [
            'title' => 'Aparatur Desa',
            'icon' => 'apartment',
            'route' => '',
            'route_is_active' => 'admin.village-official.*',
            'permissions' => [],
            'submenu' => [
                [
                    'title' => 'Sambutan',
                    'route' => 'admin.village-official.greeting.index',
                    'route_is_active' => 'admin.village-official.greeting.*',
                    'permissions' => [PermissionName::village_official_greeting_view()],
                ],
                [
                    'title' => 'Sejarah',
                    'route' => 'admin.village-official.history.index',
                    'route_is_active' => 'admin.village-official.history.*',
                    'permissions' => [PermissionName::village_official_history_view()],
                ],
                [
                    'title' => 'Visi & Misi',
                    'route' => 'admin.village-official.vision-mission.index',
                    'route_is_active' => 'admin.village-official.vision-mission.*',
                    'permissions' => [PermissionName::village_official_vision_mission_view()],
                ],
                [
                    'title' => 'Anggota',
                    'route' => 'admin.village-official.member.index',
                    'route_is_active' => 'admin.village-official.member.*',
                    'permissions' => [PermissionName::village_official_member_view()],
                ],
            ],
        ],
        [
            'title' => 'Galeri',
            'icon' => 'insert-row-above',
            'route' => 'admin.gallery.index',
            'route_is_active' => 'admin.gallery.*',
            'permissions' => [PermissionName::gallery_view()],
        ],
        [
            'title' => 'Transparasi Anggaran',
            'icon' => 'dollar-circle',
            'route' => 'admin.budget.index',
            'route_is_active' => 'admin.budget.*',
            'permissions' => [PermissionName::budget_view()],
        ],
        [
            'title' => 'Program Sinergi',
            'icon' => 'gold',
            'route' => 'admin.synergy-program.index',
            'route_is_active' => 'admin.synergy-program.*',
            'permissions' => [PermissionName::synergy_program_view()],
        ],
        [
            'title' => 'Produk',
            'icon' => 'shopping-cart',
            'route' => 'admin.product.index',
            'route_is_active' => 'admin.product.*',
            'permissions' => [PermissionName::product_view()],
        ],
        [
            'title' => 'Tampilan',
            'icon' => 'layout',
            'route' => '',
            'route_is_active' => 'admin.appearance.*',
            'permissions' => [],
            'submenu' => [
                [
                    'title' => 'Menu',
                    'route' => 'admin.appearance.menu.index',
                    'route_is_active' => 'admin.appearance.menu.*',
                    'permissions' => [PermissionName::appearance_menu_view()],
                ],
                [
                    'title' => 'Halaman',
                    'route' => 'admin.appearance.page.index',
                    'route_is_active' => 'admin.appearance.page.*',
                    'permissions' => [PermissionName::appearance_page_view()],
                ],
            ],
        ],
        [
            'title' => 'Pengguna & Akses',
            'icon' => 'team',
            'route' => '',
            'route_is_active' => 'admin.access.*',
            'permissions' => [],
            'submenu' => [
                [
                    'title' => 'Pengguna',
                    'route' => 'admin.access.user.index',
                    'route_is_active' => 'admin.access.user.*',
                    'permissions' => [PermissionName::access_user_view()],
                ],
                [
                    'title' => 'Peran & Hak Akses',
                    'route' => 'admin.access.role-permission.index',
                    'route_is_active' => 'admin.access.role-permission.*',
                    'permissions' => [PermissionName::access_role_permission_view()],
                ],
            ],
        ],
        [
            'title' => 'E-Surat',
            'icon' => 'container',
            'route' => '',
            'route_is_active' => 'admin.e-letter.*',
            'permissions' => [],
            'submenu' => [
                [
                    'title' => 'Template Surat',
                    'route' => 'admin.e-letter.template.index',
                    'route_is_active' => 'admin.e-letter.template.*',
                    'permissions' => [PermissionName::e_letter_template_view()],
                ],
                [
                    'title' => 'Pengajuan Surat',
                    'route' => 'admin.e-letter.submission.index',
                    'route_is_active' => 'admin.e-letter.submission.*',
                    'permissions' => [PermissionName::e_letter_submission_view()],
                ],
            ],
        ],
        [
            'title' => 'Kritik & Saran',
            'icon' => 'signature',
            'route' => 'admin.critique-suggestion.index',
            'route_is_active' => 'admin.critique-suggestion.*',
            'permissions' => [PermissionName::critique_suggestion_view()],
        ],
        [
            'title' => 'Pengaturan',
            'icon' => 'setting',
            'route' => 'admin.setting.index',
            'route_is_active' => 'admin.setting.*',
            'permissions' => [PermissionName::setting_manage()],
        ],
    ],
];
