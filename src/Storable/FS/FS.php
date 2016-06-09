<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;

final class FS
{
    private function __construct()
    {}
    
    public static function serialize($store, $filename)
    {
        $dirname = dirname($filename);

        if (is_dir($filename)) {
            self::remove($dirname);
        }
        
        self::make($dirname);
        
        $serialized = serialize($store);
        
        file_put_contents($filename, $serialized);
    }

    public static function unserialize($filename)
    {
        if (!is_file($filename)) {
            return;
        }
        
        $serialized = file_get_contents($filename);
        
        return unserialize($serialized);
    }

    public static function make($dirname)
    {
        if (is_dir($dirname)) {
            return;
        }
        
        if (is_file($dirname)) {
            unlink($dirname);
            mkdir($dirname);
            
            return;
        }
        
        self::make(dirname($dirname));
        mkdir($dirname);
    }
    
    public static function remove($dirname)
    {
        $basenames = array_diff(scandir($dirname), ['.', '..']);
        
        foreach ($basenames as $basename) {
            $filename = $dirname . DIRECTORY_SEPARATOR . $basename;
            
            if (is_dir($filename)) {
                self::remove($filename);
            } else {
                unlink($filename);
            }
        }
        
        return rmdir($dirname);
    }
}