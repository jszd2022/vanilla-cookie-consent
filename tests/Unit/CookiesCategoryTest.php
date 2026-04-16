<?php


use JSzD\VanillaCookieConsent\Cookie;
use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\CookiesCategory;
use JSzD\VanillaCookieConsent\CookiesGroup;

it('can create and access category key', function () {
    Cookies::boot();

    $category = new CookiesCategory('foo');
    expect($category->key())->toBe('foo');
});

it('can set custom attributes', function () {
    Cookies::boot();

    $category = new CookiesCategory('foo');
    $category->title = 'foo';

    $attributes = $category->getAttributes();
    expect($attributes['title'] ?? null)->toBe('foo');
});

it('can register and start cookie configuration from cookie method', function () {
    Cookies::boot();

    $category = new CookiesCategory('foo');

    expect($category->name('foo-cookie'))->toBeInstanceOf(Cookie::class);
});

it('can register a cookies group', function () {
    Cookies::boot();

    $category = new CookiesCategory('foo');

    expect($category->group(fn(CookiesGroup $group) => $group))->toBe($category);

    $results = $category->getDefined();
    expect($results)->toHaveLength(1);
});

it('can return all defined cookies', function () {
    Cookies::boot();

    $category = new CookiesCategory('foo');
    $category->cookie(new Cookie());
    $category->cookie(new Cookie());

    $results = $category->getCookies();
    expect($results)->toHaveLength(2);
});
