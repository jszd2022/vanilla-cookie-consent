## Configuration options

Below is a list of all available configuration options and their default values:

```php
[
    /*
    |--------------------------------------------------------------------------
    | Consent cookie configuration
    |--------------------------------------------------------------------------
    |
    | In order to keep track of the user's preferences, this package stores
    | an anonymized cookie. You do not need to register this cookie in the
    | package's cookie manager as it is done automatically (under "essentials").
    |
    | The duration parameter represents the cookie's lifetime in minutes.
    |
    | The domain parameter, when defined, determines the cookie's activity domain.
    | For multiple sub-domains, prefix your domain with "." (eg: ".mydomain.com").
    |
    */
    'cookie' => [
        'name'     => 'cookie_consent',
        'duration' => (60 * 24 * 365),
        'domain'   => null,
        'secure'   => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session cookie configuration
    |--------------------------------------------------------------------------
    |
    | Used to correctly show the session cookie in the essentials cookie category.
    |
    */
    'session'          => [
        'cookie'   => 'PHPSESSID',
        'lifetime' => 24, // in minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Legal page configuration
    |--------------------------------------------------------------------------
    |
    | Most cookie notices display a link to a dedicated page explaining
    | the extended cookies usage policy. If your application has such a page
    | you can add its relative url here.
    |
    */
    'policy'           => null,

    /*
    |--------------------------------------------------------------------------
    |  Resource paths configuration 
    |--------------------------------------------------------------------------
    |
    | You can specify the path to the views and translations directories.
    | When using custom directories, missing files will be replaced with the package defaults. 
    |
    */
    'views_dir' => null,
    'lang_dir' => null,
    
    /*
    |--------------------------------------------------------------------------
    | Routes configuration
    |--------------------------------------------------------------------------
    | The relative URLs that the JavaScript functions will call to handle the consent API requests.
    |
    */
    'routes'           => [
        'script'               => '/cookie-consent/script',
        'accept-all'           => '/cookie-consent/accept-all',
        'accept-essentials'    => '/cookie-consent/accept-essentials',
        'accept-configuration' => '/cookie-consent/configure',
        'reset'                => '/cookie-consent/reset',
    ],
```