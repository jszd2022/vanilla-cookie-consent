<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;


use JSzD\VanillaCookieConsent\Http\HttpRequest;
use JSzD\VanillaCookieConsent\Http\HttpResponse;

class ScriptController extends Controller {
    public function handle(): HttpResponse {
        $content = str_replace('php_config', $this->generateConfig(), file_get_contents(LCC_ROOT . '/resources/js/Cookies.js'));
        return HttpResponse::make($content)->withHeaders(['Content-Type' => 'application/javascript']);
    }

    protected function generateConfig(): string {
        return json_encode([
            'accept-all'           => lcc_route('accept-all'),
            'accept-essentials'    => lcc_route('accept-essentials'),
            'accept-configuration' => lcc_route('accept-configuration'),
            'reset'                => lcc_route('reset'),
        ]);
    }
}
