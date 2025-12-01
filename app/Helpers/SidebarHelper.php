<?php

if (!function_exists('getSidebarMenu')) {
    function getSidebarMenu()
    {
        if (!auth()->check()) {
            return [];
        }

        $menuItems = config('sidebar.menu');
        $filteredMenu = [];

        foreach ($menuItems as $item) {
            $filteredItem = $item;

            if (isset($item['submenu'])) {
                $filteredSubmenu = [];
                $allSubPermissions = [];

                foreach ($item['submenu'] as $subItem) {
                    $canViewSubmenu = true;
                    if (!empty($subItem['permissions'])) {
                        $allSubPermissions = array_merge($allSubPermissions, $subItem['permissions']);

                        if (!auth()->user()->canAny($subItem['permissions'])) {
                            $canViewSubmenu = false;
                        }
                    }

                    if ($canViewSubmenu) {
                        $filteredSubmenu[] = $subItem;
                    }
                }

                $filteredItem['submenu'] = $filteredSubmenu;

                if (empty($filteredSubmenu)) {
                    continue;
                }
            }

            if (!empty($item['permissions'])) {
                if (!auth()->user()->canAny($item['permissions'])) {
                    continue;
                }
            }

            $filteredMenu[] = $filteredItem;
        }

        return $filteredMenu;
    }
}

if (!function_exists('isMenuActive')) {
    function isMenuActive($routeName)
    {
        if (empty($routeName)) {
            return false;
        }

        return request()->routeIs($routeName);
    }
}
