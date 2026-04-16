<?php
return [
    'cookie'  => [
        'name'     => 'cookie_consent',
        'duration' => (60 * 24 * 365),
        'domain'   => null,
        'secure'   => false,
    ],
    'session' => [
        'cookie'   => 'PHPSESSID',
        'lifetime' => 24,
    ],

    'policy'    => null,
    'views_dir' => null,
    'lang_dir'  => null,
    'routes'    => [
        'script'               => '/cookie-consent/script',
        'accept-all'           => '/cookie-consent/accept-all',
        'accept-essentials'    => '/cookie-consent/accept-essentials',
        'accept-configuration' => '/cookie-consent/configure',
        'reset'                => '/cookie-consent/reset',
    ],
];

