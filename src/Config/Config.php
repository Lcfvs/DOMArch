<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

class Config
{
    use Storable;

    private static $_global;

    public function __construct($name)
    {
        self::$_global = $this;
    }

    public static function global()
    {
        if (self::$_global) {
            return self::$_global;
        }

        return new static('global');
    }
}