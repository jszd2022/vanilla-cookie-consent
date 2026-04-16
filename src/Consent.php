<?php

namespace JSzD\VanillaCookieConsent;

use Exception;
use JSzD\VanillaCookieConsent\Http\HttpCookie;

class Consent {
    /**
     * The cookie or group we're defining a consent action for.
     */
    protected Cookie|CookiesGroup $instance;

    /**
     * The cookies that should be returned if not already defined.
     */
    protected array $cookies = [];

    /**
     * The scripts that can be included in the page's head.
     */
    protected array $scripts = [];

    /**
     * Create a new consent object for a specific cookie or cookies group.
     */
    public function __construct(Cookie|CookiesGroup $instance) {
        $this->instance = $instance;
    }

    /**
     * Add a cookie to the consent response.
     * @throws Exception
     */
    public function cookie(string $value, ?string $path = null, ?string $domain = null, ?bool $secure = null, bool $httpOnly = false, bool $raw = true, ?string $sameSite = null): static {
        if (is_a($this->instance, CookiesGroup::class)) {
            throw new Exception('Cannot configure cookie from CookiesGroup.');
        }

        $this->cookies[] = HttpCookie::make(
            name: $this->instance->name,
            value: $value,
            minutes: $this->instance->duration,
            path: $path,
            domain: $domain,
            secure: $secure,
            httpOnly: $httpOnly,
            raw: $raw,
            sameSite: $sameSite,
        );

        return $this;
    }

    /**
     * Get all the defined cookies.
     */
    public function getCookies(): array {
        return $this->cookies;
    }

    /**
     * Add multiple script tags to the consent response.
     */
    public function script(string $tag): static {
        $this->scripts[] = $tag;

        return $this;
    }

    /**
     * Add a single script tag to the consent response.
     */
    public function getScripts(): array {
        return $this->scripts;
    }
}