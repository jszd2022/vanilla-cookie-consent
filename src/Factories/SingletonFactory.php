<?php

namespace JSzD\VanillaCookieConsent\Factories;


abstract class SingletonFactory {
    protected static $class;
    protected static $instances;

    public static function getInstance() {
        if ((static::$instances[static::$class] ?? null) === null) {
            var_dump('SingletonFactory::create:', static::$class);
            static::$instances[static::$class] = new (static::$class)();
        }
        return static::$instances[static::$class];
    }

}