<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;

trait Validable
{
    use Cacheable;
    
    /**
     * @method Lib\Storable\Cacheable::_getInstance(...$keys, $callback)
     **/
    private static function _getInstance()
    {
        $parser = Parser::parse(get_called_class(), func_get_args());
        $store = $parser->store;
        $filename = $parser->filename;
        
        if ($store && $store->_isValid($filename)) {
            $parser->validated = true;
        }
        
        $store = $parser->getStorable();
        $store->_storeName = $filename;
        
        return $store;
    }
}