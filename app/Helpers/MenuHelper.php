<?php
if (!function_exists('getDefaultUserMenuList')) {
    function getDefaultUserMenuList()
    {
        static $data = null;
        if ($data == null) {
            $data = (object)[
                (object)[
                    'id' => 'um-0',
                    'title' => 'Menu Bertingkat',
                    'route' => '#',
                ],
                (object)[
                    'id' => 'um-1',
                    'title' => 'Aparatur Desa',
                    'route' => route('user.village-official.member.index'),
                ],
                (object)[
                    'id' => 'um-2',
                    'title' => 'Sejarah Desa',
                    'route' => route('user.village-official.history.index'),
                ],
                (object)[
                    'id' => 'um-3',
                    'title' => 'Visi & Misi Desa',
                    'route' => route('user.village-official.vision-mission.index'),
                ],
                (object)[
                    'id' => 'um-4',
                    'title' => 'Pengumuman',
                    'route' => route('user.information.index'),
                ],
                (object)[
                    'id' => 'um-5',
                    'title' => 'Berita',
                    'route' => route('user.news.index'),
                ],
                (object)[
                    'id' => 'um-6',
                    'title' => 'Data Statistik',
                    'route' => route('user.statistic.index'),
                ],
                (object)[
                    'id' => 'um-7',
                    'title' => 'Kontak',
                    'route' => route('user.contact.index'),
                ],
                (object)[
                    'id' => 'um-8',
                    'title' => 'Produk Desa',
                    'route' => route('user.product.index'),
                ],
            ];
        }

        return $data;
    }
}

if (!function_exists('renderNavbarMenu')) {
    function renderNavbarMenu(array $items, int $level = 1): string
    {
        $ulClass = $level === 1
            ? 'navbar-nav mx-auto mb-2 mb-lg-0 gap-2 d-none d-lg-flex'
            : 'dropdown-menu';

        $html = '<ul class="' . $ulClass . '">';

        if ($level == 1) {
            $html .= '<li class="nav-item">
                <a class="nav-link" href="' . route('user.index') . '">Home</a>
            </li>';
        }

        foreach ($items as $item) {
            $hasChildren = !empty($item['children']);
            $itemUrl = $item['url'];
            $itemLabel = $item['name'];

            if ($level === 1) {
                $liClass = $hasChildren ? 'nav-item dropdown' : 'nav-item';
            } else {
                $liClass = $hasChildren ? 'nav-item dropend' : '';
            }

            $linkClass = $level === 1 ? 'nav-link' : 'dropdown-item';
            $toggleClass = $hasChildren ? ' dropdown-toggle' : '';

            $dropdownAttributes = $hasChildren ? ' role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';

            $html .= '<li class="' . $liClass . '">';

            $html .= '<a class="' . $linkClass . $toggleClass . '" href="' . $itemUrl . '"' . $dropdownAttributes . '>';
            $html .= $itemLabel;
            $html .= '</a>';

            if ($hasChildren) {
                $html .= renderNavbarMenu($item['children'], $level + 1);
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }
}

if (!function_exists('renderBottomSheetMenu')) {
    function renderBottomSheetMenu(array $items, int $level = 1): string
    {
        $html = '';

        $ulClass = '';
        if ($level === 1) {
            $ulClass = 'navbar-nav justify-content-center align-items-center';
        } else if ($level === 2) {
            $ulClass = 'dropdown-menu shadow-sm';
        } else {
            $ulClass = 'list-unstyled w-full';
        }

        $html .= '<ul class="' . $ulClass . '">';

        foreach ($items as $item) {
            $hasChildren = !empty($item['children']);
            $itemUrl = $item['url'];
            $itemLabel = $item['name'];

            if ($hasChildren && $level > 1) {
                $html .= renderBottomSheetMenu($item['children'], $level + 1);
                continue;
            }

            $linkClass = '';
            $toggleAttributes = '';
            $liClass = '';
            $inlineStyle = '';

            if ($level === 1) {
                $liClass .= ' nav-item text-center';
                $linkClass = 'nav-link py-2';

                if ($hasChildren) {
                    $liClass .= ' dropdown';
                    $linkClass .= ' dropdown-toggle';
                    $toggleAttributes = ' data-bs-toggle="dropdown" aria-expanded="false"';
                }
                $linkHref = $itemUrl;
            } else {
                $linkClass = 'dropdown-item text-center py-2';
                $toggleAttributes = '';
                $linkHref = $itemUrl;
            }

            $html .= '<li class="' . $liClass . '">';

            $html .= '<a class="' . $linkClass . '" href="' . $linkHref . '" role="button"' . $toggleAttributes . $inlineStyle . '>';
            $html .= $itemLabel;
            $html .= '</a>';

            if ($hasChildren && $level === 1) {
                $html .= renderBottomSheetMenu($item['children'], $level + 1);
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }
}

if (!function_exists('footerFlattenMenu')) {
    function footerFlattenMenu(array $items, bool $isTopLevel = true): array
    {
        $flatList = [];
        foreach ($items as $item) {
            $hasChildren = !empty($item['children']);

            if (!$isTopLevel || ($isTopLevel && !$hasChildren)) {
                if (isset($item['name']) && isset($item['url'])) {
                    $flatList[] = [
                        'name' => $item['name'],
                        'url' => $item['url'],
                    ];
                }
            }

            if ($hasChildren) {
                $flatList = array_merge($flatList, footerFlattenMenu($item['children'], false));
            }
        }
        return $flatList;
    }
}

if (!function_exists('renderFooterMenu')) {
    function renderFooterMenu(array $menuData): string
    {
        $flatItems = footerFlattenMenu($menuData);

        $html = '';

        foreach ($flatItems as $item) {
            $html .= '<a href="' . $item['url'] . '" class="d-inline-flex align-items-center gap-2 text-white footer-othermenu-item">';
            $html .= '<i class="bi bi-bullseye text-app"></i>';
            $html .= '<span class="fw-semibold">' . $item['name'] . '</span>';
            $html .= '</a>';
        }

        return $html;
    }
}
