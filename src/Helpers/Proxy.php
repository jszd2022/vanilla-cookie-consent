<?php

namespace JSzD\VanillaCookieConsent\Helpers;

class Proxy {
    protected static $class;
    protected static $factory;

    public static function __callStatic($name, $arguments) {
        if(isset(static::$factory) && method_exists(static::$factory, 'getInstance')) {
            $object = (static::$factory)::getInstance();
        } else {
            $object = new (static::$class)();
        }

        return $object->$name(...$arguments);
    }
}