<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Request;

use Locale;
use Exception;

use DOMArch\Request;
use DOMArch\Request\Incoming\Body;
use DOMArch\Request\Incoming\HeaderList;
use DOMArch\Request\Incoming\Response;
use DOMArch\Url;

class Incoming extends Request
{
    private static $_current;
    private static $_requested;

    private $_locale;
    private $_previous;

    protected function __construct(Url $url, string $method, Incoming $previous = null)
    {
        parent::__construct($url, $method);

        $this->_previous = $previous;

        if ($this !== static::getRequested()) {
            return;
        }

        $locale = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null;

        if ($locale) {
            $this->_locale = \Locale::acceptFromHttp($locale);
        }
    }

    public static function getRequested()
    {
        if (self::$_requested) {
            return self::$_requested;
        }

        $scheme = $_SERVER['REQUEST_SCHEME'];
        $user = $_SERVER['PHP_AUTH_USER'] ?? '';
        $pass = $_SERVER['PHP_AUTH_PW'] ?? '';
        $auth = $user ? '' : ($user . ':' . $pass . '@');
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $url = $scheme . '://' . $auth . $host . $uri;
        $method = $_SERVER['REQUEST_METHOD'];

        self::$_requested = static::parse($url, $method);

        return self::$_requested;
    }

    public static function getCurrent()
    {
        if (!self::$_current) {
            self::$_current = static::getRequested();
        }

        return self::$_current;
    }

    public function getPrevious()
    {
        return $this->_previous;
    }

    public function getBody()
    {
        if ($this->_body || $this !== static::getRequested()) {
            return $this->_body;
        }

        $this->_body = Body::fromRequest($this);

        return $this->_body;
    }

    public function getHeaders()
    {
        if ($this->_headers || $this !== static::getRequested()) {
            return $this->_headers;
        }

        $this->_headers = HeaderList::fromRequest($this);

        return $this->_headers;
    }

    public function getLocale()
    {
        return $this->_locale;
    }

    public function getResponse()
    {
        if ($this->_response) {
            return $this->_response;
        }

        $this->_response = new Response();

        return $this->_response;
    }

    public function forward(Url $url, string $method)
    {
        self::$_current = new static($url, $method, $this);

        return self::$_current;
    }

    public function internalError(Exception $exception)
    {
        error_log($exception);

        $this->redirect(static::STATUS_INTERNAL_ERROR);
    }

    public function redirect(int $status_code, Url $url = null)
    {
        if ($url) {
            http_response_code($status_code);

            header('Location: ' . $url);
        }

        $this->_exit($status_code);
    }

    public function respond()
    {
        $response = $this->getResponse();
        $body = $response->getBody();
        $headers = $response->getHeaders();
        $status_code = $response->getStatusCode();

        http_response_code($status_code);

        $headers->send();

        echo $body;

        $this->_exit($status_code);
    }

    protected function _exit($status_code)
    {
        exit((int) ($status_code === Request::STATUS_SERVICE_UNAVAILABLE));
    }
}