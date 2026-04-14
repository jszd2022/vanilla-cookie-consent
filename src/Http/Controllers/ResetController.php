<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Response;

class ResetController extends Controller {
    public function handle(): Response {
        $request = new Request();
        $response = !$request->expectsJson()
            ? Response::redirectBack()
            : Response::make()->json([
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
