<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\HttpRequest;
use JSzD\VanillaCookieConsent\Http\HttpResponse;

class ResetController extends Controller {
    public function handle(): HttpResponse {
        $request = new HttpRequest();
        $response = !$request->expectsJson()
            ? HttpResponse::redirectBack()
            : HttpResponse::make()->json([
                'status'  => 'ok',
                'scripts' => Cookies::getNoticeScripts(true),
                'notice'  => Cookies::getNoticeMarkup(),
            ]);

        return $response->withoutCookie(
            cookie: lcc_config('cookie.name'),
            domain: lcc_config('cookie.domain'),
        );
    }
}
