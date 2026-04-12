<?php

namespace JSzD\VanillaCookieConsent\Factories;


abstract class SingletonFactory {
    protected static $class;
    protected static $instance;

    public static function getInstance() {
        if (static::$instance === null) {
            static::$instance = new (static::class)();
        }
        return static::$instance;
    }

}