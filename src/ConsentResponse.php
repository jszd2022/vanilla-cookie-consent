<?php

namespace JSzD\VanillaCookieConsent;

use JSzD\VanillaCookieConsent\Http\Cookie as CookieComponent;
use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Response;


class ConsentResponse {
    /**
     * The cookies that should be attached to the actual HTTP response.
     */
    protected array $cookies = [];

    /**
     * The scripts that can be included in the page's head markup.
     */
    protected array $scripts = [];

    /**
     * The displayable notice HTML markup that should be appended to the page.
     */
    protected ?string $notice = null;

    /**
     * Transform the collected data into a JSON response-object.
     */
    public function handleConsent(Cookie|CookiesGroup $instance): static {
        if (!$instance->hasConsentCallback()) {
            return $this;
        }

        $consent = $instance->getConsentResult();

        $this->attachCookies($consent->getCookies());
        $this->attachScripts($consent->getScripts());

        return $this;
    }

    /**
     * Add multiple cookies to the consent response.
     */
    public function attachCookies(array $cookies): static {
        foreach ($cookies as $cookie) {
            $this->attachCookie($cookie);
        }

        return $this;
    }

    /**
     * Add a single cookie to the consent response.
     */
    public function attachCookie(CookieComponent $cookie): static {
        $this->cookies[] = $cookie;

        return $this;
    }

    /**
     * Add multiple script tags to the consent response.
     */
    public function attachScripts(array $tags): static {
        foreach ($tags as $tag) {
            $this->attachScript($tag);
        }

        return $this;
    }

    /**
     * Add a single script tag to the consent response.
     */
    public function attachScript(string $tag): static {
        $this->scripts[] = $tag;

        return $this;
    }

    /**
     * Transform the collected data into a JSON response-object.
     */
    public function toResponse(Request $request): Response {
        $response = $request->expectsJson()
            ? Response::make()->json($this->getResponseData())
            : Response::redirectBack();

        foreach ($this->cookies as $cookie) {
            $response->withCookie($cookie);
        }

        return $response;
    }

    /**
     * Transform the collected data into a JSON response-object.
     */
    public function getResponseData(): array {
        return array_filter([
            'status'  => 'ok',
            'scripts' => $this->getResponseScripts(),
            'notice'  => $this->getResponseNotice(),
        ]);
    }

    /**
     * Prepare the collected scripts for display.
     */
    public function getResponseScripts(): ?array {
        return $this->scripts ?: null;
    }

    /**
     * Prepare the displayable notice for display.
     */
    protected function getResponseNotice(): ?string {
        return $this->notice ?: null;
    }
}