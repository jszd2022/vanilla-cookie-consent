<?php


use JSzD\VanillaCookieConsent\AnalyticCookiesCategory;
use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\CookiesGroup;

it('can register Google Analytics configuration', function () {
    Cookies::boot();

    $category = new AnalyticCookiesCategory('foo');

    expect($category->google('g-foo'))->toBe($category)
        ->and($group = ($category->getDefined()[0] ?? null))->toBeInstanceOf(CookiesGroup::class)
        ->and($group->hasConsentCallback())->toBeTrue()
        ->and($group->getCookies())->toHaveLength(4);
});
