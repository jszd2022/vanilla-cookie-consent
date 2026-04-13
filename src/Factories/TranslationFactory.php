<?php

namespace JSzD\VanillaCookieConsent\Factories;

use JSzD\VanillaCookieConsent\Services\TranslationService;

/**
 * @method static TranslationService getInstance()
 */
class TranslationFactory extends SingletonFactory {
    protected static $class = TranslationService::class;
}