<?php

if (!function_exists('getAppearanceMenuTypeList')) {
    function getAppearanceMenuTypeList()
    {
        static $data = [
            'header' => 'Header',
            'footer' => 'Footer'
        ];

        return $data;
    }
}

if (!function_exists('getAppearanceMenuBehaviourTargetList')) {
    function getAppearanceMenuBehaviourTargetList()
    {
        static $data = [
            'keep' => 'Tetap Di Halaman',
            'direct' => 'Buka Halaman Baru'
        ];

        return $data;
    }
}

if (!function_exists('getPageOriginList')) {
    function getPageOriginList()
    {
        static $data = [
            'in' => 'Internal',
            'ex' => 'External'
        ];

        return $data;
    }
}
