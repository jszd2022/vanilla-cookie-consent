<?php

namespace JSzD\VanillaCookieConsent\Services;

use InvalidArgumentException;
use JSzD\VanillaCookieConsent\ConsentResponse;
use JSzD\VanillaCookieConsent\Cookie;
use JSzD\VanillaCookieConsent\CookiesGroup;
use JSzD\VanillaCookieConsent\Factories\CookiesRegistarFactory;
use JSzD\VanillaCookieConsent\Factories\SingletonFactory;
use JSzD\VanillaCookieConsent\Helpers\Config;
use JSzD\VanillaCookieConsent\CookiesRegistrar;
use JSzD\VanillaCookieConsent\Helpers\Translation;
use JSzD\VanillaCookieConsent\Http\Request;
use JSzD\VanillaCookieConsent\Http\Cookie as HttpCookie;
use function filemtime;

class CookiesManager extends SingletonFactory {


    /**
     * The user's current consent preferences.
     */
    protected ?array $preferences = null;

    /**
     * Create a new Service Manager instance.
     */
    public function __construct() {
        if (!defined('LCC_ROOT')) {
            define('LCC_ROOT', realpath(__DIR__ . '/../..'));
        }

        $request = new Request();
        $this->preferences = $this->getCurrentConsentSettings($request);
    }

    /**
     * Retrieve the eventual existing cookie data.
     */
    protected function getCurrentConsentSettings(Request $request): ?array {
        $preferences = ($raw = $request->cookie(lcc_config('cookie.name')))
            ? json_decode($raw, true)
            : null;

        if (!$preferences || !is_int($preferences['consent_at'] ?? null)) {
            return null;
        }

        // Check duration in case application settings have changed since the cookie was set.
        if ($preferences['consent_at'] + (lcc_config('cookie.duration') * 60) < time()) {
            return null;
        }

        return $preferences;
    }

    /**
     * Create fresh cookie data for the given consented categories.
     */
    protected function makeConsentSettings(array $categories): array {
        return array_reduce(CookiesRegistarFactory::getInstance()->getCategories(), function ($values, $category) use ($categories) {
            $state = in_array($category->key(), $categories);
            return array_reduce($category->getCookies(), function ($values, $cookie) use ($state) {
                $values[$cookie->name] = $state;
                return $values;
            }, $values);
        }, ['consent_at' => time()]);
    }

    /**
     * Transfer all undefined method calls to the registrar.
     */
    public function __call(string $method, array $arguments) {
        return CookiesRegistarFactory::getInstance()->$method(...$arguments);
    }

    /**
     * Check if the current preference settings are enough. If not,
     * the cookie preferences notice should be displayed again.
     */
    public function shouldDisplayNotice(): bool {
        if (!$this->preferences) {
            return true;
        }

        // Check if each defined cookie hasn't been shown to the user yet.
        return array_reduce(CookiesRegistarFactory::getInstance()->getCategories(), function ($state, $category) {
            return $state || array_reduce($category->getCookies(), function (bool $state, Cookie $cookie) {
                    return $state || !array_key_exists($cookie->name, $this->preferences);
                }, false);
        }, false);
    }

    /**
     * Check if the user has given explicit consent for a specific cookie.
     */
    public function hasConsentFor(string $key): bool {
        if (!$this->preferences) {
            return false;
        }

        $groups = array_reduce(CookiesRegistarFactory::getInstance()->getCategories(), function ($results, $category) use ($key) {
            return array_reduce($category->getDefined(), function (array $results, Cookie|CookiesGroup $instance) use ($key) {
                if (is_a($instance, CookiesGroup::class) && $instance->name === $key) {
                    $results[] = $instance;
                }
                return $results;
            }, $results);
        }, []);

        $cookies = $groups
            ? array_unique(array_reduce($groups, fn($cookies, $group) => array_merge($cookies, array_map(fn($cookie) => $cookie->name, $group->getCookies())), []))
            : [$key];

        foreach ($cookies as $cookie) {
            if (!$this->preferences[$cookie] ?? false) return false;
        }

        return true;
    }

    /**
     * Handle the incoming consent preferences accordingly.
     */
    public function accept(string|array $categories = '*'): ConsentResponse {
        if (!is_array($categories) || !$categories) {
            $categories = array_map(fn($category) => $category->key(), CookiesRegistarFactory::getInstance()->getCategories());
        }

        $this->preferences = $this->makeConsentSettings($categories);

        $response = $this->getConsentResponse();
        $response->attachCookie($this->makeConsentCookie());

        return $response;
    }

    /**
     * Call all the consented cookie callbacks and gather their
     * scripts and/or cookies that should be returned along the
     * current request's response.
     */
    protected function getConsentResponse(): ConsentResponse {
        return array_reduce(CookiesRegistarFactory::getInstance()->getCategories(), function ($response, $category) {
            return array_reduce($category->getDefined(), function (ConsentResponse $response, Cookie|CookiesGroup $instance) {
                return $this->hasConsentFor($instance->name)
                    ? $response->handleConsent($instance)
                    : $response;
            }, $response);
        }, new ConsentResponse());
    }

    /**
     * Create a new cookie instance for the given consented categories.
     */
    protected function makeConsentCookie(): HttpCookie {
        return HttpCookie::make(
            name: lcc_config('cookie.name'),
            value: json_encode($this->preferences),
            minutes: lcc_config('cookie.duration'),
            domain: lcc_config('cookie.domain'),
            secure: lcc_config('cookie.secure'),
        );
    }

    /**
     * Output all the scripts for the current consent state.
     */
    public function renderScripts(bool $withDefault = true): string {
        $output = $this->shouldDisplayNotice()
            ? $this->getNoticeScripts($withDefault)
            : $this->getConsentedScripts($withDefault);

        if (strlen($output)) {
            $output = '<!-- Cookie Consent -->' . $output;
        }

        return $output;
    }

    public function getNoticeScripts(bool $withDefault): string {
        return $withDefault ? $this->getDefaultScriptTag() : '';
    }

    protected function getConsentedScripts(bool $withDefault): string {
        $output = $this->getNoticeScripts($withDefault);

        foreach ($this->getConsentResponse()->getResponseScripts() ?? [] as $tag) {
            $output .= $tag;
        }

        return $output;
    }

    protected function getDefaultScriptTag(): string {
        return '<script '
            . 'src="' . lcc_route('script') . '?id='
            . md5(filemtime(LCC_ROOT . '/resources/js/script.js')) . '" '
            . 'defer'
            . '></script>';
    }

    /**
     * Output the consent alert/modal for the current consent state.
     */
    public function renderView(): string {
        return $this->shouldDisplayNotice()
            ? $this->getNoticeMarkup()
            : '';
    }

    public function getNoticeMarkup(): string {
        if ($policy = lcc_config('policy')) {
            $policy = lcc_route($policy);
        }

        return lcc_render_view('cookies', [
            'cookies' => CookiesRegistarFactory::getInstance(),
            'policy'  => $policy,
        ]);
    }

    /**
     * Output a single cookie consent action button.
     */
    public function renderButton(string $action, ?string $label = null, array $attributes = []): string {
        $url = match ($action) {
            'accept-all' => lcc_route('accept-all'),
            'accept-essentials' => lcc_route('accept-essentials'),
            'accept-configuration' => lcc_route('accept-configuration'),
            'reset' => lcc_route('reset'),
            default => null,
        };

        if (!$url) {
            throw new InvalidArgumentException('Cookie consent action "' . $action . '" does not exist. Try one of these: "accept-all", "accept-essentials", "accept-configuration", "reset".');
        }

        $attributes = array_merge([
            'method'             => 'post',
            'data-cookie-action' => $action,
        ], $attributes);

        if (!($attributes['class'] ?? null)) {
            $attributes['class'] = 'cookiebtn';
        }

        $basename = explode(' ', $attributes['class'])[0];

        $attributes = implode(
            ' ',
            array_map(
                fn($value, $attribute) => $attribute . '="' . $value . '"',
                $attributes,
                array_keys($attributes)
            )
        );

        return lcc_render_view('button', [
            'url'        => $url,
            'label'      => $label ?? $action, // TODO: use lang file
            'attributes' => $attributes,
            'basename'   => $basename,
        ]);
    }

    /**
     * Output a table with all the cookie infos.
     */
    public function renderInfo(): string {
        return lcc_render_view('info', [
            'cookies' => CookiesRegistarFactory::getInstance(),
        ]);
    }

    public function replaceInfoTag(string $wysiwyg): string {
        $cookieConsentInfo = lcc_render_view('info', [
            'cookies' => CookiesRegistarFactory::getInstance(),
        ]);

        $formattedString = preg_replace(
            [
                '/\<(\w)[^\>]+\>\@cookieconsentinfo\<\/\1\>/',
                '/\@cookieconsentinfo/',
            ],
            $cookieConsentInfo,
            $wysiwyg,
        );

        return $formattedString;
    }


    public function boot(array $config = [], string $locale = 'en'): void {
        // Config
        Config::setConfig($config);

        // Translation
        Translation::setLocale($locale);

        CookiesRegistarFactory::getInstance()->essentials()->consent();
    }

    public function setTranslations(array $translations = []): void {
        Translation::setTranslations($translations);
    }
}