<?php

namespace JSzD\VanillaCookieConsent\Factories;
use JSzD\VanillaCookieConsent\Services\ConfigService;

/**
 * @method static \JSzD\VanillaCookieConsent\Services\ConfigService getInstance()
 */
class ConfigFactory extends SingletonFactory {
    protected static $class = ConfigService::class;
}