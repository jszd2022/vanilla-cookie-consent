<?php

namespace JSzD\VanillaCookieConsent\Services;

class ConfigService {
    private array $config;

    public function __construct() {
        $config_dir = LCC_ROOT . '/config';

        $config = require $config_dir . '/cookieconsent.php';

        $this->config = $config;
    }

    public function get(string $key, mixed $default = null): mixed {
        $value = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    public function set(string $key, mixed $value): void {
        $keys = explode('.', $key);
        $lastKey = array_pop($keys);
        $pointer = &$this->config;

        foreach ($keys as $key) {
            if (!isset($pointer[$key]) || !is_array($pointer[$key])) {
                $pointer[$key] = [];
            }

            $pointer = &$pointer[$key];
        }

        $pointer[$lastKey] = $value;
    }

    public function setConfig(array $config): void {
        $this->config = array_replace_recursive($this->config, $config);
    }

    public function getConfig(): array {
        return $this->config;
    }

    public function setViewsDir(string $dir): void {
        $this->config['views_dir'] = $dir;
    }

    public function resolveView(string $name): string {
        $user_dir = $this->resolveViewsDir();
        $package_dir = LCC_ROOT . '/resources/views';

        $name = $name . '.php';

        if ($user_dir) {
            if (file_exists($user_dir . '/' . $name)) {
                return $user_dir . '/' . $name;
            }
        }
        return $package_dir . '/' . $name;
    }

    protected function resolveViewsDir(): ?string {
        $dir = $this->config['views_dir'] ?? null;

        if ($dir && file_exists($dir)) {
            return $dir;
        }
        return null;
    }

    public function resolveLangDir(): ?string {
        $dir = $this->config['lang_dir'] ?? null;

        if ($dir && file_exists($dir)) {
            return $dir;
        }
        return null;
    }
}