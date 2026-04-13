<?php

namespace JSzD\VanillaCookieConsent\Http\Controllers;


use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Response;

class ScriptController extends Controller {
    public function handle(): Response {
        $content = str_replace('{config:1}', $this->generateConfig(), file_get_contents(LCC_ROOT . '/dist/cookies.js'));
        return Response::make($content)->withHeaders(['Content-Type' => 'application/javascript']);
    }

    protected function generateConfig(): string {
        return json_encode([
            'accept.all'           => lcc_route('cookieconsent.accept.all'),
            'accept.essentials'    => lcc_route('cookieconsent.accept.essentials'),
            'accept.configuration' => lcc_route('cookieconsent.accept.configuration'),
            'reset'                => lcc_route('cookieconsent.reset'),
        ]);
    }
}
