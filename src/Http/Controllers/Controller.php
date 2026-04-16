<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Http\HttpResponse;

abstract class Controller {
    public static function handleRequest(): void {
        $response = (new static())->handle();
        $response->send();
    }

    abstract public function handle(): HttpResponse;
}