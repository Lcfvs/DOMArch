<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

final class SelectorCache
{ 
    private static $_cache = [];
    private static $_isUptoDate = true;
    
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
        static::$_isUptoDate = false;
    
        return self::$_cache[$selector] = $query;
    }
    
    public static function load($filename = null)
    {
        if (is_null($filename)) {
            $filename = __DIR__ . '/../cache/html-selectors.json';
        }
        
        if (!is_readable($filename)) {
            return;
        }
        
        $cache = json_decode(file_get_contents($filename));
        
        if (!is_array($cache)) {
            $cache = [];
        }
        
        static::$_isUptoDate = true;
        static::$_cache = $cache;
    }
    
    public static function clear($filename = null)
    {
        if (is_null($filename)) {
            $filename = __DIR__ . '/../cache/html-selectors.json';
            
            if (is_file($filename)) {
                unlink($filename);
            }
        }
        
        static::$_isUptoDate = true;
        static::$_cache = [];
    }
    
    public static function save($filename = null)
    {
        if (static::$_isUptoDate) {
            return;
        }
        
        if (is_null($filename)) {
            $directory = __DIR__ . '/../cache/';
            $filename = $directory . 'html-selectors.json';
            
            if (!is_dir($directory)) {
                mkdir($directory);
            }
        }
        
        file_put_contents($filename, json_encode(static::$_cache));
    }
}