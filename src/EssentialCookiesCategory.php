<?php

namespace JSzD\VanillaCookieConsent;

class EssentialCookiesCategory extends CookiesCategory {
    /**
     * Define the package's consent cookie
     */
    public function consent(): static {
        return $this->cookie(function (Cookie $cookie) {
            $cookie->name(lcc_config('cookie.name'))
                ->duration(lcc_config('cookie.duration'))
                ->description(lcc_trans('defaults.consent'));
        });
    }

    /**
     * Define Laravel's session cookie.
     */
    public function session(): static {
        return $this->cookie(function (Cookie $cookie) {
            $cookie->name(lcc_config('session.cookie'))
                ->duration(lcc_config('session.lifetime'))
                ->description(lcc_trans('defaults.session'));
        });
    }

}
