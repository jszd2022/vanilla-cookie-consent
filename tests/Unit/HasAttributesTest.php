<?php

use JSzD\VanillaCookieConsent\Concerns\HasAttributes;

it('can magically set & get an attribute', function () {
    $instance = new class() {
        use HasAttributes;
    };

    $instance->foo = 'bar';

    expect($instance->foo)->toBe('bar')
        ->and($instance->undefined)->toBeNull();
});

it('can methodolically set & get an attribute', function () {
    $instance = new class() {
        use HasAttributes;
    };

    $instance->setAttribute('foo', 'bar');

    expect($instance->getAttribute('foo'))->toBe('bar')
        ->and($instance->getAttribute('undefined'))->toBeNull();
});

it('can set & get all attributes', function () {
    $instance = new class() {
        use HasAttributes;
    };

    $instance->setAttributes(['foo' => 'bar']);

    expect($results = $instance->getAttributes())->toBeArray()
        ->and($results['foo'])->toBe('bar');
});
