<?php

namespace JSzD\VanillaCookieConsent\Factories;

use JSzD\VanillaCookieConsent\Services\CookiesManager;

/**
 * @method static \JSzD\VanillaCookieConsent\Services\CookiesManager getInstance()
 */
class CookiesManagerFactory extends SingletonFactory {
    protected static $class = CookiesManager::class;
}