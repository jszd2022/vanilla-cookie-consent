<?php

namespace JSzD\VanillaCookieConsent\Helpers;

class Str {
    static function camel(string $string): string {
        $string = str_replace(['-', '_'], ' ', $string);
        return lcfirst(str_replace([' '], '', ucwords(str_replace('_', ' ', $string))));
    }
}