<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\HttpRequest;
use JSzD\VanillaCookieConsent\Http\HttpResponse;

class AcceptAllController extends Controller {
    public function handle(): HttpResponse {
        $request = new HttpRequest();
        return Cookies::accept()->toResponse($request);
    }
}
