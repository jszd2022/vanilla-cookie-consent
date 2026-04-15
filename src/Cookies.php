<?php

namespace JSzD\VanillaCookieConsent;

use Closure;
use JSzD\VanillaCookieConsent\Factories\ConfigFactory;
use JSzD\VanillaCookieConsent\Factories\CookiesManagerFactory;
use JSzD\VanillaCookieConsent\Factories\TranslationFactory;

/**
 * @method static bool shouldDisplayNotice()
 * @method static bool hasConsentFor(string $key)
 * @method static ConsentResponse accept(string|array $categories = '*')
 * @method static string renderScripts(bool $withDefault = true)
 * @method static string getNoticeScripts(bool $withDefault)
 * @method static string renderView()
 * @method static string getNoticeMarkup()
 * @method static string renderButton(string $action, ?string $label = null, array $attributes = [])
 * @method static string renderInfo()
 * @method static string replaceInfoTag(string $wysiwyg)
 * @method static CookiesCategory essentials()
 * @method static CookiesCategory analytics()
 * @method static CookiesCategory optional()
 * @method static CookiesRegistrar category(string $key, ?Closure $maker = null)
 * @method static array getCategories()
 * @method static bool hasCategory(string $key)
 */
class Cookies {
    public static function boot(array $config = [], array $translations = [], string $locale = 'en'): void {
        if (!defined('LCC_ROOT')) {
            define('LCC_ROOT', realpath(__DIR__ . '/..'));
        }

        // Config
        ConfigFactory::getInstance()->setConfig($config);

        // Translation
        TranslationFactory::getInstance()->setLocale($locale);
        TranslationFactory::getInstance()->setTranslations($translations);
    }

    public static function __callStatic($name, $arguments) {
        $cookiesManager = CookiesManagerFactory::getInstance();

        return $cookiesManager->$name(...$arguments);
    }
}