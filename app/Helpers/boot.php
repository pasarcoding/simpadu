<?php

require_once __DIR__ . '/SidebarHelper.php';
require_once __DIR__ . '/ResidentHelper.php';
require_once __DIR__ . '/InformationHelper.php';
require_once __DIR__ . '/BudgetHelper.php';
require_once __DIR__ . '/ProductHelper.php';
require_once __DIR__ . '/AppearanceHelper.php';
require_once __DIR__ . '/RolePermissionHelper.php';
require_once __DIR__ . '/ELetterHelper.php';
require_once __DIR__ . '/MenuHelper.php';
require_once __DIR__ . '/SettingHelper.php';

if (!function_exists('rupiah_formatted')) {
    function rupiah_formatted($nominal, $prefix = 'Rp ')
    {
        if (empty($nominal)) {
            return $prefix . '0';
        }

        return $prefix . number_format($nominal, 0, ',', '.');
    }
}

if (!function_exists('extractPathUrl')) {
    function extractPathUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        $parts = parse_url($url);

        if (!isset($parts['path'])) {
            return '';
        }

        $path = $parts['path'];

        if (str_starts_with($path, '/')) {
            $path = substr($path, 1);
        }

        return $path;
    }

    if (!function_exists('truncateText')) {
        function truncateText(string $text, int $maxLength = 100, string $ending = '...')
        {
            if (empty($text)) {
                return '';
            }

            if (mb_strlen($text) <= $maxLength) {
                return $text;
            }

            $truncatedText = mb_substr($text, 0, $maxLength);

            return $truncatedText . $ending;
        }
    }
}
