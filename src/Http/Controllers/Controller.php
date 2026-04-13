<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Http\Response;

abstract class Controller {
    public static function handleRequest(): void {
        $response = (new static())();
        $response->send();
    }

    abstract public function handle(): Response;
}