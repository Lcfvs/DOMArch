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
        
        $key = Config::global()->get('common')->get('encryptionKey');
        $query = Crypto::decryptUri(substr($url->getPath(), 1), $key);

        return $url->reset($url->_parseParams($query));
    }

    public function _getUri()
    {
        $key = Config::global()->get('common')->get('encryptionKey');

        return '/' . Crypto::encryptUri(parent::_getUri(), $key);
    }
}