<?php


use JSzD\VanillaCookieConsent\AnalyticCookiesCategory;
use JSzD\VanillaCookieConsent\Cookies;
use JSzD\VanillaCookieConsent\CookiesCategory;
use JSzD\VanillaCookieConsent\CookiesRegistrar;
use JSzD\VanillaCookieConsent\EssentialCookiesCategory;

it('can create and access consent categories', function () {
    Cookies::boot();

    $registrar = new CookiesRegistrar();

    expect($essentials = $registrar->essentials())->toBeInstanceOf(EssentialCookiesCategory::class)
        ->and($essentials->key())->toBe('essentials')
        ->and($analytics = $registrar->analytics())->toBeInstanceOf(AnalyticCookiesCategory::class)
        ->and($analytics->key())->toBe('analytics')
        ->and($optional = $registrar->optional())->toBeInstanceOf(CookiesCategory::class)
        ->and($optional->key())->toBe('optional');

});

it('can create and access custom consent categories', function () {
    Cookies::boot();

    $registrar = new CookiesRegistrar();

    $result = $registrar->category('simple');
    expect($result)->toBe($registrar)
        ->and($simple = $registrar->simple())->toBeInstanceOf(CookiesCategory::class)
        ->and($simple->key())->toBe('simple');

    $result = $registrar->category('with-key', fn(string $key) => new CookiesCategory($key));
    expect($result)->toBe($registrar)
        ->and($withKey = $registrar->withKey())->toBeInstanceOf(CookiesCategory::class)
        ->and($withKey->key())->toBe('with-key');

    $result = $registrar->category('with-instance', fn(CookiesCategory $category) => $category);
    expect($result)->toBe($registrar)
        ->and($withInstance = $registrar->withInstance())->toBeInstanceOf(CookiesCategory::class)
        ->and($withInstance->key())->toBe('with-instance');
});

it('cannot return an undefined consent category', function() {
    Cookies::boot();

    $registrar = new CookiesRegistrar();
    $registrar->custom();
})->throws(\BadMethodCallException::class);

it('can return all defined consent categories', function() {
    Cookies::boot();

    $registrar = new CookiesRegistrar();
    $registrar->essentials();
    $registrar->category('custom');
    $registrar->analytics();

    $results = $registrar->getCategories();
    expect($results)->toHaveLength(3);
    expect($results[0]->key())->toBe('essentials');
    expect($results[1]->key())->toBe('custom');
    expect($results[2]->key())->toBe('analytics');
});
