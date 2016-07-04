<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/

namespace DOMArch;

use DOMArch\Url\Params;

class Url
{
    protected $_scheme;
    protected $_user;
    protected $_pass;
    protected $_host;
    protected $_subDomain;
    protected $_domain;
    protected $_port;
    protected $_path;
    protected $_query;
    protected $_fragment;
    protected $_params;

    protected function __construct(
        array $fields
    )
    {
        $this->_scheme = $fields['scheme'] ?? '';
        $this->_host = $fields['host'] ?? '';
        $this->_user = $fields['user'] ?? '';
        $this->_pass = $fields['pass'] ?? '';
        $this->_subDomain = $fields['subDomain'] ?? '';
        $this->_domain = $fields['domain'] ?? '';
        $this->_port = $fields['port'] ?? '';
        $this->_path = $fields['path'] ?? '';
        $this->_query = $fields['query'] ?? '';
        $this->_fragment = $fields['fragment'] ?? '';
        $this->_params = $this->_parseParams($this->_query);
    }

    public function reset(
        array $params = []
    )
    {
        $this->_path = '/';
        $this->_query = '';
        $this->_fragment = '';
        $this->_params = Params::fromArray($params);

        return $this;
    }

    /**
     * @param array $params
     * @param string $fragment
     * @return self
     */
    public function rewrite(
        array $params = [],
        string $fragment = ''
    )
    {
        return static::parse((string) $this)
            ->reset($params)
            ->setFragment($fragment);
    }

    public function __toString()
    {
        return implode('', [
            $this->_getPrefix(),
            $this->_getUri(),
            $this->_getFragment()
        ]);
    }

    public function getScheme()
    {
        return $this->_scheme;
    }

    public function setScheme(
        string $scheme
    )
    {
        $this->_scheme = $scheme;

        return $this;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser(
        string $user
    )
    {
        $this->_user = $user;

        return $this;
    }

    public function getPass()
    {
        return $this->_pass;
    }

    public function setPass(
        string $pass
    )
    {
        $this->_pass = $pass;

        return $this;
    }

    public function getHost()
    {
        return $this->_host;
    }

    public function getSubDomain()
    {
        return $this->_subDomain;
    }

    public function setSubDomain(
        string $sub_domain
    )
    {
        $this->_subDomain = $sub_domain;

        return $this;
    }

    public function getDomain()
    {
        return $this->_domain;
    }

    public function setDomain(
        string $domain
    )
    {
        $this->_domain = $domain;

        return $this;
    }

    public function getPort()
    {
        return $this->_port;
    }

    public function setPort(
        int $port
    )
    {
        $this->_port = $port;

        return $this;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function setPath(
        string $path
    )
    {
        $this->_path = $path;

        return $this;
    }

    public function getQuery()
    {
        return $this->_query;
    }

    public function getFragment()
    {
        return $this->_fragment;
    }

    public function setFragment(
        string $fragment
    )
    {
        $this->_fragment = $fragment;

        return $this;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public static function parse(
        string $str
    )
    {
        $fields = parse_url($str);

        $host = $fields['host'] ?? '';
        $parts = explode('.', $host);

        $fields['subDomain'] = implode('.', array_splice($parts, 0, -2));
        $fields['domain'] = implode('.', $parts);

        return new static($fields);
    }

    protected static function _parseParams(
        string $query
    )
    {
        parse_str($query, $params);

        return Params::fromArray($params);
    }

    protected function _getPrefix()
    {
        if (empty($this->_scheme)) {
            $prefix = '//';
        } else {
            $prefix = $this->_scheme  . '://';
        }

        if (!empty($this->_user)) {
            $prefix .= $this->_user . ':' . $this->_pass . '@';
        }

        if (!empty($this->_subDomain)) {
            $prefix .= $this->_subDomain . '.';
        }

        $prefix .= $this->_domain;

        if (!empty($this->_port)) {
            $prefix .= ':' . $this->_port;
        }

        return $prefix;
    }

    protected function _getUri()
    {
        $uri = $this->_path;

        $params = $this->_params->toArray();

        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }

        return $uri;
    }

    protected function _getFragment()
    {
        if (!empty($this->_fragment)) {
            return '#' . $this->_fragment;
        }

        return '';
    }

    public function decrypt($key)
    {
        $prefix = $this->_getPrefix();
        $uri = Crypto::decryptUri($this->_getUri(), $key);
        $fragment = $this->_getFragment();

        return static::parse($prefix . $uri . $fragment);
    }

    public function encrypt($key)
    {
        $prefix = $this->_getPrefix();
        $uri = Crypto::encryptUri($this->_getUri(), $key);
        $fragment = $this->_getFragment();

        return static::parse($prefix . $uri . $fragment);
    }
}