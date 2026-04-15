<?php

namespace JSzD\VanillaCookieConsent\Services;

use JSzD\VanillaCookieConsent\Factories\ConfigFactory;

class TranslationService {
    private ?array $translations = null;
    private string $locale       = 'en';

    private function loadTranslations(): void {
        if ($this->translations === null) {
            $user_dir = ConfigFactory::getInstance()->resolveLangDir();
            $package_dir = LCC_ROOT . '/resources/lang';

            $available_locales = array_diff(scandir($package_dir), array('.', '..'));

            if ($user_dir) {
                $available_locales = array_merge($available_locales, array_diff(scandir($user_dir), array('.', '..')));
            }

            $locale = $this->locale;

            if (!in_array($this->locale, $available_locales)) {
                $locale = 'en';
            }

            if ($user_dir && file_exists($user_dir . '/' . $locale . '/cookies.php')) {
                $localization = require $user_dir . '/' . $this->locale . '/cookies.php';
            } else {
                $localization = require $package_dir . '/' . $this->locale . '/cookies.php';
            }

            $this->translations = $localization;
        }
    }

    public function get(string $key, array $replace = [], string $locale = null): mixed {
        $this->loadTranslations();
        $value = $this->translations ?? [];

        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $key;
            }

            $value = $value[$segment];
        }

        if (is_string($value) && $replace !== []) {
            foreach ($replace as $search => $replaceValue) {
                $value = str_replace(':' . $search, (string)$replaceValue, $value);
            }
        }

        return $value;
    }

    public function setLocale(string $locale): void {
        $this->locale = $locale;
    }

    public function getLocale(): string {
        return $this->locale;
    }

    public function setTranslations(array $config): void {
        $this->loadTranslations();
        $this->translations = array_replace_recursive($this->translations, $config);
    }
}