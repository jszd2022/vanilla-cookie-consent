<?php

use JSzD\VanillaCookieConsent\Factories\ConfigFactory;
use JSzD\VanillaCookieConsent\Factories\TranslationFactory;

if (!function_exists('lcc_config')) {
    function lcc_config(string $key, $default = null) {
        return ConfigFactory::getInstance()->get($key, $default);
    }
}

if (!function_exists('lcc_route')) {
    function lcc_route(string $key) {
        $key = 'routes.' . $key;
        return ConfigFactory::getInstance()->get($key);
    }
}

if (!function_exists('lcc_trans')) {
    function lcc_trans(string $key, array $replace = [], string $locale = null): string|array {
        return TranslationFactory::getInstance()->get($key, $replace, $locale);
    }
}

if (!function_exists('lcc_render_view')) {
    function lcc_render_view(string $name, array $args = []): string {
        extract($args); // turns array keys into variables

        ob_start();

        $viewPath = ConfigFactory::getInstance()->resolveView($name);
        include $viewPath;

        return ob_get_clean();
    }
}