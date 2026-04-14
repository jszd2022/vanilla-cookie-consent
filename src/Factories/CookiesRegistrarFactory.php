<?php

namespace JSzD\VanillaCookieConsent\Factories;

use JSzD\VanillaCookieConsent\CookiesRegistrar;

/**
 * @method static CookiesRegistrar getInstance()
 */
class CookiesRegistrarFactory extends SingletonFactory {
    protected static $class = CookiesRegistrar::class;
}