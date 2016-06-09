<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

abstract class Request
{
    const
        STATUS_MOVED_PERMANENTLY = 301,
        STATUS_FOUND = 302,
        STATUS_SEE_OTHER = 303,
        STATUS_TEMPORARY_REDIRECT = 307,
        STATUS_PERMANENTLY_REDIRECT = 308,
        STATUS_BAD_REQUEST = 400,
        STATUS_UNAUTHORIZED = 401,
        STATUS_NOT_FOUND = 404,
        STATUS_METHOD_NOT_ALLOWED = 405,
        STATUS_NOT_ACCEPTABLE = 406,
        STATUS_GONE = 410,
        STATUS_INTERNAL_ERROR = 500,
        STATUS_NOT_IMPLEMENTED = 501,
        STATUS_SERVICE_UNAVAILABLE = 503;

    protected $_body;
    protected $_headers;
    protected $_method;
    protected $_response;
    protected $_url;

    protected function __construct(Url $url, string $method)
    {
        $this->_url = $url;
        $this->_method = strtolower($method);
    }

    public static function parse(string $url, string $method = 'get')
    {
        return new static(Url::parse($url), $method);
    }

    public static function fromUrl(Url $url, string $method = 'get')
    {
        return new static($url, $method);
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function getMethod()
    {
        return $this->_method;
    }
}