<?php


use JSzD\VanillaCookieConsent\Concerns\HasCookies;
use JSzD\VanillaCookieConsent\Cookie;

it('can register a cookie instance', function () {
    $instance = new class() {
        use HasCookies;
    };

    $cookie = new Cookie();

    expect($instance->cookie($cookie))->toBe($instance)
        ->and($results = $instance->getCookies())->toHaveLength(1)
        ->and($results[0])->toBeInstanceOf(Cookie::class);
});

it('can register a cookie using callback', function () {
    $instance = new class() {
        use HasCookies;
    };

    $callback = function(Cookie $cookie) {
        return $cookie;
    };

    expect($instance->cookie($callback))->toBe($instance)
        ->and($results = $instance->getCookies())->toHaveLength(1)
        ->and($results[0])->toBeInstanceOf(Cookie::class);
});
