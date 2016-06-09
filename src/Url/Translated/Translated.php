<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/

namespace DOMArch\Url;

use DOMArch\Url;

abstract class Translated
{
    public static function parse($str)
    {
        return static::_route(parent::parse($str));
    }

    public function __toString()
    {
        return static::_translate();
    }
}