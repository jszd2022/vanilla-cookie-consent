<?php

namespace JSzD\VanillaCookieConsent\Concerns;

trait HasTranslations {
    /**
     * Get a translation string when defined.
     */
    public function translate(string $key, ?string $default = null): ?string {
        $value = lcc_trans($key);

        return ($value === $key)
            ? $default
            : $value;
    }
}
