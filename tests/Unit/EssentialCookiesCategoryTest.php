<?php

use JSzD\VanillaCookieConsent\Cookie;
use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\EssentialCookiesCategory;

it('can register consent cookie', function () {
    Cookies::boot(config: [
        'cookie' => [
            'name' => 'foo_consent',
            'duration' => 365 * 24 * 60,
        ]
    ]);

    $category = new EssentialCookiesCategory('foo');

    expect($category->consent())->toBe($category)
        ->and($cookie = ($category->getCookies()[0] ?? null))->toBeInstanceOf(Cookie::class)
        ->and($cookie->name)->toBe('foo_consent')
        ->and($cookie->duration)->toBe(365 * 24 * 60);
});

it('can register session cookie', function () {
    Cookies::boot(config: [
        'session' => [
            'cookie' => 'foo_session',
            'lifetime' => 120,
        ]
    ]);

    $category = new EssentialCookiesCategory('foo');

    expect($category->session())->toBe($category)
        ->and($cookie = ($category->getCookies()[0] ?? null))->toBeInstanceOf(Cookie::class)
        ->and($cookie->name)->toBe('foo_session')
        ->and($cookie->duration)->toBe(120);
});
