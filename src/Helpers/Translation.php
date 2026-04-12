<?php

namespace JSzD\VanillaCookieConsent\Helpers;

/**
 * @method static string get(string $key, array $replace = [], string $locale = null)
 * @method static string setLocale(string $locale)
 * @method static string getLocale()
 * @method static void setTranslations(array $translations = [])
 * @method static array getTranslations()
 */
class Translation extends Proxy {
    protected $factory = \JSzD\VanillaCookieConsent\Factories\TranslationFactory::class;
}