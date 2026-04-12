<?php

if (!function_exists('lcc_minutesHumanReadable')) {
    function lcc_minutesHumanReadable(int $minutes): string {
        if ($minutes < 60) {
            return $minutes . ' minute' . ($minutes !== 1 ? 's' : '');
        }

        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        if ($hours < 24) {
            return $hours . ' hour' . ($hours !== 1 ? 's' : '') .
                ($mins ? ' ' . $mins . ' minute' . ($mins !== 1 ? 's' : '') : '');
        }

        $days = intdiv($hours, 24);
        $hours = $hours % 24;

        if ($days < 30) {
            return $days . ' day' . ($days !== 1 ? 's' : '') .
                ($hours ? ' ' . $hours . ' hour' . ($hours !== 1 ? 's' : '') : '');
        }

        $months = intdiv($days, 30);
        $days = $days % 30;

        if ($months < 12) {
            return $months . ' month' . ($months !== 1 ? 's' : '') .
                ($days ? ' ' . $days . ' day' . ($days !== 1 ? 's' : '') : '');
        }

        $years = intdiv($months, 12);
        $months = $months % 12;

        return $years . ' year' . ($years !== 1 ? 's' : '') .
            ($months ? ' ' . $months . ' month' . ($months !== 1 ? 's' : '') : '');
    }
}

if (!function_exists('lcc_config')) {
    function lcc_config(string $key, $default = null) {
        return \JSzD\VanillaCookieConsent\Helpers\Config::get($key, $default);
    }
}

if (!function_exists('lcc_route')) {
    function lcc_route(string $key) {
        $key = 'routes.' . $key;
        return \JSzD\VanillaCookieConsent\Helpers\Config::get($key);
    }
}

if (!function_exists('lcc_trans')) {
    function lcc_trans(string $key, array $replace = [], string $locale = null) {
        return \JSzD\VanillaCookieConsent\Helpers\Translation::get($key, $replace, $locale);
    }
}