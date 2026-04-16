<?php

namespace JSzD\VanillaCookieConsent\Http;

use JSzD\VanillaCookieConsent\Http\HttpCookie;

class HttpResponse {
    private mixed  $data         = null;
    private array  $cookies      = [];
    private array  $headers      = [];
    private int    $status       = 200;
    private string $type         = 'text/html';
    private bool   $is_redirect  = false;
    private string $redirect_url = '';


    public function withCookie(HttpCookie $cookie): static {
        $this->setCookie($cookie);
        return $this;
    }

    public function withoutCookie($cookie, $path = null, $domain = null): static {
        $cookie = HttpCookie::make($cookie, null, -2628000, $path, $domain);
        $this->setCookie($cookie);
        return $this;
    }

    public function withHeaders(array $headers): static {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public static function redirectBack(): self {
        $obj = new self;
        $obj->is_redirect = true;
        $obj->redirect_url = $_SERVER['HTTP_REFERER'] ?? '/';
        $obj->status = 302;
        return $obj;
    }

    public function json(array $data, $status = 200, array $headers = []): static {
        $obj = new self;
        $obj->data = $data;
        $obj->status = $status;
        $obj->headers = $headers;
        $obj->type = 'application/json';
        return $obj;
    }

    public static function make(mixed $data = null): HttpResponse {
        $obj = new self;
        $obj->data = $data;
        return $obj;
    }

    public function send(): void {
        // set headers
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        // set content type
        if (empty($this->headers['Content-Type'])) {
            header("Content-Type: $this->type");
        }

        // set cookies
        foreach ($this->cookies as $domain => $paths) {
            foreach ($paths as $path => $cookies) {
                foreach ($cookies as $cookie) {
                    $cookie->setCookie();
                }
            }
        }

        // set status
        http_response_code($this->status);


        // handle redirects
        if ($this->is_redirect) {
            header("Location: $this->redirect_url");
            exit;
        }

        // return data
        if ($this->type === 'application/json') {
            echo json_encode($this->data);
        } else {
            echo $this->data;
        }
        exit;
    }

    private function setCookie(HttpCookie $cookie): void {
        $this->cookies[$cookie->getDomain() ?? ''][$cookie->getPath()][$cookie->getName()] = $cookie;
    }
}