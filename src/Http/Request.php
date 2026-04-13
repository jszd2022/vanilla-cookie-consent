<?php

namespace JSzD\VanillaCookieConsent\Http;

/**
 * Laravel-like request helper.
 */
class Request {
    public static function fullUrl(): string {
        $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO']
            ?? ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http');

        return $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * @param $key
     * @param $default
     * @return array|mixed|null
     */
    public function get($key, $default = null): mixed {
        $data = array_merge($_GET, $_POST);

        if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
            $json = json_decode(file_get_contents('php://input'), true);
            if (is_array($json)) {
                $data = array_merge($data, $json);
            }
        }

        return $data[$key] ?? $default;
    }

    /**
     * @return bool
     */
    public function expectsJson(): bool {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

        return str_contains($accept, '/json') || str_contains($accept, '+json');
    }

    public function cookie(string $name): string {
        return $_COOKIE[$name] ?? '';
    }
}