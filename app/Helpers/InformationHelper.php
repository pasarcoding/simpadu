<?php
if (!function_exists('getPusblishStatusList')) {
    function getPusblishStatusList()
    {
        static $data = [
            "publish" => "Publish",
            "arsip" => "Arsip",
        ];

        return $data;
    }
}
