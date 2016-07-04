<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Resource\File;

use DOMArch\Config;
use DOMArch\Constants;
use DOMArch\Resource\File;
use DOMArch\Util\DateTime;

final class MimeCache
{
    private static $_cache;
    private static $_isUptoDate = true;
    
    private function __construct()
    {}
    
    public static function get($extension)
    {
        if (empty(self::$_cache)) {
            self::load();
        }
        
        if (!empty(self::$_cache->{$extension})) {
            return self::$_cache->{$extension};
        }
    }
    
    public static function set($extension, $mime)
    {
        static::$_isUptoDate = false;
    
        return self::$_cache->{$extension} = $mime;
    }
    
    public static function getFilename() {
        return Config::global()->get(Constants::CACHE_DIR) . '/mimes.json';
    }

    public static function load()
    {
        $filename = self::getFilename();
        $expiration_date = DateTime::create(DateTime::PREVIOUS_DAY);
            
        if (!is_readable($filename) || filemtime($filename) < $expiration_date) {
            self::_update();
        }
        
        $cache = new File($filename, 'r');
        
        static::$_isUptoDate = true;
        static::$_cache = json_decode($cache->getContents());

        return static::$_cache;
    }
    
    private static function _update()
    {
        self::clear();
        
        $filename = self::getFilename();
        $cache = new File($filename, 'w+');
        
        $source = new File(Config::global()->get(Constants::MIME_TYPES_URL));
        $source->setFlags(File::SKIP_EMPTY | File::DROP_NEW_LINE);

        $pattern = '/([\w\+\-\.\/]+)\t+([\w\s]+)/';
        
        while (!$source->eof()) {
            $line = $source->fgets();
            
            if (substr($line, 0, 1) == '#' || !preg_match($pattern, $line, $matches)) {
                continue;
            }
            
            $mime = $matches[1];
            $extensions = explode(' ', $matches[2]);
            
            foreach($extensions as $extension) {
                $extension = trim($extension);
                
                self::set($extension, $mime);
            }
        }
        
        if (!empty(static::$_cache)) {
            self::save($cache);
        }
    }
    
    public static function clear()
    {
        $filename = self::getFilename();
        
        if (is_file($filename)) {
            unlink($filename);
        }
        
        static::$_isUptoDate = true;
        static::$_cache = new \StdClass();
    }
    
    public static function save(File $cache)
    {
        if (static::$_isUptoDate) {
            return;
        }
        
        $cache->putContents(json_encode(static::$_cache));
    }
}