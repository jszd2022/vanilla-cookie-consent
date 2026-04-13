<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Response;

class AcceptEssentialsController extends Controller {
    public function handle(): Response {
        $request = new Request();
        return Cookies::accept(['essentials'])->toResponse($request);
    }
}
