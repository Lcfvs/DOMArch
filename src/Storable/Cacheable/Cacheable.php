<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;

trait Cacheable
{
    use Awakable;
    
    private static $_stores = [];
    protected $_storeName;
    
    public function save()
    {
        $store_name = $this->_storeName;
        
        FS::serialize($this, $store_name);
        
        return $this;
    }
    
    public static function getInstance()
    {
        $arguments = func_get_args();
        
        $arguments[] = function()
        use ($arguments) {
            return new static(...$arguments);
        };
        
        return static::_getInstance(...$arguments);
    }
    
    /**
     * @method Lib\Storable\Cacheable::_getInstance(...$keys, $callback)
     **/
    private static function _getInstance()
    {
        $parser = Parser::parse(get_called_class(), func_get_args());
        $store = $parser->store;
        
        if ($store) {
            $parser->validated = true;
        }
        
        $store = $parser->getStorable();
        $store->_storeName = $parser->filename;
        
        return $store;
    }
}