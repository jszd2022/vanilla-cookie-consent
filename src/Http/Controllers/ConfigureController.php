<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Response;

class ConfigureController extends Controller {
    public function handle(): Response {
        $request = new Request();

        $categories = array_values(array_unique(array_filter(
            array_merge(['essentials'], $request->get('categories', [])),
            fn($key) => Cookies::hasCategory($key)
        )));

        return Cookies::accept($categories)->toResponse($request);
    }
}
