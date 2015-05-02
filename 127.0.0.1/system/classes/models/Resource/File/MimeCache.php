<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Resource\File;

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
    
        return self::$_cache{$extension} = $mime;
    }
    
    public static function load()
    {
        $filename = __DIR__ . '/cache/mimes.json';
            
        if (!is_readable($filename) || filemtime($filename) < (time() - 24 * 60 * 60)) {
            self::_update();
        }
        
        $cache = new \Resource\File($filename, 'r');
        
        static::$_isUptoDate = true;
        static::$_cache = json_decode($cache->getContents());
    }
    
    private static function _update()
    {
        self::clear();
        
        $filename = __DIR__ . '/cache/mimes.json';
        $cache = new \Resource\File($filename, 'w+');
        
        $source = new \Resource\File(MIME_TYPES_URL);
        $source->setFlags(\Resource\File::SKIP_EMPTY | \Resource\File::DROP_NEW_LINE);
        
        $mimes = [];
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
        $filename = __DIR__ . '/cache/mimes.json';
        
        if (is_file($filename)) {
            unlink($filename);
        }
        
        static::$_isUptoDate = true;
        static::$_cache = new StdClass();
    }
    
    public static function save(\Resource\File $cache)
    {
        if (static::$_isUptoDate) {
            return;
        }
        
        $cache->putContents(json_encode(static::$_cache));
    }
}