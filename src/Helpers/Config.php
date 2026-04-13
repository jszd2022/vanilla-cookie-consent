<?php

namespace JSzD\VanillaCookieConsent\Helpers;

use JSzD\VanillaCookieConsent\Factories\ConfigFactory;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static void set(string $key, mixed $value)
 * @method static void setConfig(array $config)
 * @method static array getConfig()
 * @method static string resolveView(string $name)
 */
class Config extends Proxy {
    protected $factory = ConfigFactory::class;

}