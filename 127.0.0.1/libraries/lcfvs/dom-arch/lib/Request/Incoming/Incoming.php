<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Request;

use DOMArch\Util\DateTime;

use DOMArch\Request;
use DOMArch\Request\Incoming\Body;
use DOMArch\Request\Incoming\HeaderList;
use DOMArch\Request\Incoming\Response;
use DOMArch\Url;

class Incoming extends Request
{
    protected static $_current;
    protected static $_requested;

    protected $_previous;
    protected $_time;

    protected function __construct(
        Url $url,
        string $method = 'get',
        Incoming $previous = null
    )
    {
        parent::__construct($url, $method);

        $this->_previous = $previous;

        if ($previous) {
            $this->_time = $previous->getTime();
        } else {
            $this->_time = new DateTime();
        }

        if (self::$_requested) {
            return;
        }
    }

    public function getTime()
    {
        return $this->_time;
    }

    /**
     * @return self
     */
    public static function requested()
    {
        if (self::$_requested) {
            return self::$_requested;
        }

        $scheme = $_SERVER['REQUEST_SCHEME'];
        $user = $_SERVER['PHP_AUTH_USER'] ?? '';
        $pass = $_SERVER['PHP_AUTH_PW'] ?? '';
        $auth = empty($user) ? '' : ($user . ':' . $pass . '@');
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if ($_SERVER['SERVER_PORT'] === "80") {
            $port = '';
        } else {
            $port = ':' . $_SERVER['SERVER_PORT'];
        }

        $url = $scheme . '://' . $auth . $host . $port . $uri;

        self::$_requested = static::parse($url, $method);

        return self::$_requested;
    }

    /**
     * @return self
     */
    public static function current()
    {
        if (!self::$_current) {
            self::$_current = static::requested();
        }

        return self::$_current;
    }

    /**
     * @return self
     */
    public function getPrevious()
    {
        return $this->_previous;
    }

    public function getBody()
    {
        if ($this->_body) {
            return $this->_body;
        }

        $this->_body = Body::fromRequest($this);

        return $this->_body;
    }

    public function getHeaders()
    {
        if ($this->_headers) {
            return $this->_headers;
        }

        $this->_headers = HeaderList::fromRequest($this);

        return $this->_headers;
    }

    public function getResponse()
    {
        if ($this->_response) {
            return $this->_response;
        }

        $this->_response = new Response();

        return $this->_response;
    }

    public function forward(Url $url, string $method = 'get')
    {
        self::$_current = new static($url, $method, $this);

        return self::$_current;
    }

    public function internalError(
        string $message,
        string $file,
        int $line,
        array $context,
        array $traces = []
    )
    {
        error_log("Error
@$file:$line
$message
---
");

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