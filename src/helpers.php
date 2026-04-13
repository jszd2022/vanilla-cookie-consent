<?php

use JSzD\VanillaCookieConsent\Helpers\Config;
use JSzD\VanillaCookieConsent\Helpers\Translation;

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
        return Config::get($key, $default);
    }
}

if (!function_exists('lcc_route')) {
    function lcc_route(string $key) {
        $key = 'routes.' . $key;
        return Config::get($key);
    }
}

if (!function_exists('lcc_trans')) {
    function lcc_trans(string $key, array $replace = [], string $locale = null): string {
        return Translation::get($key, $replace, $locale);
    }
}

if (!function_exists('lcc_render_view')) {
    function lcc_render_view(string $name, array $args = []): string {
        extract($args); // turns array keys into variables

        ob_start();

        include Config::resolveView($name);

        return ob_get_clean();
    }
}