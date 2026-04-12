<?php

namespace JSzD\VanillaCookieConsent\Helpers;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static void set(string $key, mixed $value)
 * @method static void setConfig(array $config)
 * @method static array getConfig()
 */
class Config extends Proxy {
    protected $factory = \JSzD\VanillaCookieConsent\Factories\ConfigFactory::class;
}