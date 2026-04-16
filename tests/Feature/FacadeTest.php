<?php

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\EssentialCookiesCategory;
use JSzD\VanillaCookieConsent\Factories\CookiesRegistrarFactory;

it('transfers method calls to the registrar', function() {
    Cookies::boot();

    Cookies::essentials()->session();
    Cookies::essentials()->name('foo')->duration(120);

    expect($categories = (CookiesRegistrarFactory::getInstance())->getCategories())->toHaveLength(1)
        ->and($category = $categories[0])->toBeInstanceOf(EssentialCookiesCategory::class)
        ->and($category->getCookies())->toHaveLength(2);
});
