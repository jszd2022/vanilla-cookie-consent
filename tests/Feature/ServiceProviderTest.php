<?php

use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\CookiesRegistrar;
use JSzD\VanillaCookieConsent\EssentialCookiesCategory;
use JSzD\VanillaCookieConsent\Factories\CookiesRegistrarFactory;

it('provides the cookies registrar singleton', function() {
    Cookies::boot();

    (CookiesRegistrarFactory::getInstance())->essentials()->session();

    expect($categories = (CookiesRegistrarFactory::getInstance())->getCategories())->toHaveLength(1)
        ->and($category = $categories[0])->toBeInstanceOf(EssentialCookiesCategory::class)
        ->and($category->getCookies())->toHaveLength(1);
});
