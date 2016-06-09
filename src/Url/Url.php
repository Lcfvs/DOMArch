<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/

namespace DOMArch;

class Url
{
    const
        ENCRYPTION_KEY = 'ENCRYPTION_KEY';

    use Storable;

    public static function parse($str)
    {
        $url = new static();
        $fields = parse_url($str);

        $host = $fields['host'];

        $fields['domain'] = substr($host, -9);
        $fields['subdomain'] = substr($host, 0, -9);

        foreach ($fields as $field => $value) {
            $url->set($field, $value);
        }

        return $url
            ->set('params', $url->_parseParams($fields['query'] ?? '?'));
    }

    protected static function _parseParams($query)
    {
        parse_str($query, $params);

        return Url\Params::fromArray($params);
    }

    protected function __construct()
    {
        $this
            ->set('scheme', '')
            ->set('subdomain', '')
            ->set('host', '')
            ->set('user', '')
            ->set('pass', '')
            ->set('path', '/')
            ->set('query', '')
            ->set('fragment', '')
            ->set('params', new Url\Params());
    }

    public function reset()
    {
        $this
            ->set('path', '/')
            ->set('fragment', '')
            ->set('query', '')
            ->set('params', new Url\Params());

        return $this;
    }

    public function rewrite(array $params = [])
    {
        return static::parse((string) $this)
            ->reset()
            ->set('params', Url\Params::fromArray($params));
    }

    public function __toString()
    {
        return implode('', [
            $this->_getPrefix(),
            $this->_getUri(),
            $this->_getFragment()
        ]);
    }

    protected function _getPrefix()
    {
        $prefix = $this->get('scheme')  . '://';

        $user = $this->get('user');

        if ($user) {
            $prefix .= $user . ':' . $this->get('pass') . '@';
        }

        $subdomain = $this->get('subdomain');
        $domain = $this->get('domain');
        $port = $this->get('port');

        if ($subdomain) {
            $prefix .= $subdomain . '.';
        }

        if ($domain) {
            $prefix .= $domain;
        }

        if ($port) {
            $prefix .= ':' . $port;
        }

        return $prefix;
    }

    protected function _getUri()
    {
        $uri = $this->get('path');

        $params = $this->get('params')->toArray();

        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }

        return $uri;
    }

    protected function _getFragment()
    {
        $fragment = $this->get('fragment');

        if ($fragment) {
            return '#' . $fragment;
        }

        return '';
    }
}