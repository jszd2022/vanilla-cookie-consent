<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\HttpRequest;
use JSzD\VanillaCookieConsent\Http\HttpResponse;

class ConfigureController extends Controller {
    public function handle(): HttpResponse {
        $request = new HttpRequest();

        $categories = array_values(array_unique(array_filter(
            array_merge(['essentials'], $request->get('categories', [])),
            fn($key) => Cookies::hasCategory($key)
        )));

        return Cookies::accept($categories)->toResponse($request);
    }
}
