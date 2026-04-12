<?php

namespace JSzD\VanillaCookieConsent\Helpers;

class Proxy {
    protected $class;
    protected $factory;

    public function __call($name, $arguments) {
        if(isset($this->factory) && method_exists($this->factory, 'getInstance')) {
            $object= ($this->factory)::getInstance();
        } else {
            $object = new ($this->class)();
        }

        return $object->$name(...$arguments);
    }
}