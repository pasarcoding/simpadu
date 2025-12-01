<?php

if (!function_exists('extractIframeSrc')) {
    function extractIframeSrc($html = null)
    {
        if (is_null($html)) {
            return null;
        }

        $pattern = '/<iframe[^>]+src="([^"]+)"/i';

        if (preg_match($pattern, $html, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
