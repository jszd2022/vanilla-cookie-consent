<?php

namespace JSzD\VanillaCookieConsent\Services;

class TranslationService {
    private array  $translations = [];
    private string $locale       = 'en';

    public function __construct() {
        $lang_dir = LCC_ROOT . '/resources/lang';

        $available_locales = array_diff(scandir($lang_dir), array('.', '..'));;

        foreach ($available_locales as $locale) {
            $localization = require $lang_dir . '/' . $locale . '/cookies.php';
            $this->translations[$locale] = $localization;
        }
    }

    public function get(string $key, array $replace = [], string $locale = null): mixed {
        $value = $this->translations[($locale ?? $this->locale)] ?? [];

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
        $this->translations = array_merge($this->translations, $config);
    }

    public function getTranslations(): array {
        return $this->translations;
    }
}