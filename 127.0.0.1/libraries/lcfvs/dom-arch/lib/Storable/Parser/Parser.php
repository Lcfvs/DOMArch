<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;
// todo
final class Parser
{
    private static $_stores = [];
    
    public $callback;
    public $filename;
    public $validated;
    public $store;
    
    private function __construct()
    {}
    
    public static function parse($class_name, $arguments)
    {
        $parser = new self();
        $callback = array_pop($arguments);
        array_unshift($arguments, \Config::global()->get('CACHE_PATH'), $class_name);
        $filename = implode(DIRECTORY_SEPARATOR, $arguments);
        
        if (!empty(self::$_stores[$filename])) {
            $parser->validated = true;
            $store = self::$_stores[$filename];
        } else {
            $store = FS::unserialize($filename);
        }
        
        $parser->callback = $callback;
        $parser->filename = $filename;
        $parser->store = $store;
        
        return $parser;
    }
    
    public function getStorable()
    {
        if ($this->validated) {
            $store = $this->store;
        } else {
            $store = call_user_func($this->callback);
        }
        
        return self::$_stores[$this->filename] = $store;
    }
}