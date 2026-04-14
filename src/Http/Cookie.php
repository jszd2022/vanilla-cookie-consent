<?php

namespace JSzD\VanillaCookieConsent\Http;

class Cookie {
    protected string $name;
    protected string $value;
    protected int    $minutes;
    protected string $path;
    protected string $domain;
    protected bool   $secure;
    protected bool   $httpOnly;
    protected bool   $raw;
    protected string $sameSite;

    public static function make(string $name, ?string $value = '', int $minutes = 0, ?string $path = null, ?string $domain = null, bool $secure = false, bool $httpOnly = false, bool $raw = true, ?string $sameSite = null): self {
        $obj = new self;
        $obj->name = $name;
        $obj->value = $value ?? '';
        $obj->minutes = $minutes;
        $obj->path = $path;
        $obj->domain = $domain;
        $obj->secure = $secure;
        $obj->httpOnly = $httpOnly;
        $obj->raw = $raw;
        $obj->sameSite = $sameSite;
        return $obj;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function getPath() {
        return $this->path;
    }

    public function getName() {
        return $this->name;
    }

    public function setCookie(): void {
        setcookie($this->name, $this->value, $this->minutes, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }
}