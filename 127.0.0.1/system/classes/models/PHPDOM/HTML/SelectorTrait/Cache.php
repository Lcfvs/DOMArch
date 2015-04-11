<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML\SelectorTrait;

final class Cache
{
    private static $_cache = [];
    
    private function __construct()
    {}
    
    public static function get($selector)
    {
        if (array_key_exists($selector, self::$_cache)) {
            return self::$_cache[$selector];
        }
    }
    
    public static function set($selector, $query)
    {
        return self::$_cache[$selector] = $query;
    }
    
    public static function load($filename)
    {
        static::$_cache = json_decode(file_get_contents($filename));
    }
    
    public static function save($filename)
    {
        file_put_contents($filename, json_encode(static::$_cache));
    }
}