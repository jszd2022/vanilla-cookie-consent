<?php

namespace JSzD\VanillaCookieConsent\Concerns;

trait HasTranslations {
    /**
     * Get a translation string when defined.
     */
    public function translate(string $key, ?string $default = null): ?string {
        $key = 'cookies.' . $key;
        $value = lcc_trans($key);

        return ($value === $key)
            ? $default
            : $value;
    }
}
