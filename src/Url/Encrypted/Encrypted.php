<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/

namespace DOMArch\Url;

use DOMArch\Config;
use DOMArch\Constants;
use DOMArch\Crypto;
use DOMArch\Url;

class Encrypted extends Url
{
    public static function parse($str)
    {
        $url = parent::parse($str);
        
        $key = Config::global()->get(Constants::ENCRYPTION_KEY);
        $query = Crypto::decryptUri(substr($url->get('path'), 1), $key);

        $url->set('params', $url->_parseParams($query));

        return $url;
    }

    public function _getUri()
    {
        $key = Config::global()->get(Constants::ENCRYPTION_KEY);

        return '/' . Crypto::encryptUri(parent::_getUri(), $key);
    }
}