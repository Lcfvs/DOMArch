<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

use stdClass;

trait Storable
{
    protected $_store;
    
    public function init($name, $default)
    {
        $store = $this->_store;
        
        if (!$store) {
            $store = $this->_store = new stdClass();
        }

        if (property_exists($store, $name)) {
            return $this;
        }

        if (is_callable($default)) {
            $store->{$name} = $default();

            return $this;
        }

        $store->{$name} = $default;
        
        return $this;
    }

    public function set($name, $value)
    {
        $store = $this->_store;
        
        if (!$store) {
            $store = $this->_store = new stdClass();
        }
        
        $store->{$name} = $value;

        return $this;
    }

    public function get($name, $default = null)
    {
        $store = $this->_store;
        
        if ($store && property_exists($store, $name)) {
            return $store->{$name};
        }

        if (is_callable($default)) {
            return $default();
        }

        return $default;
    }

    public function clear($name = null)
    {
        if (is_null($name)) {
            $this->_store = new stdClass();
        } else {
            unset($this->_store->{$name});
        }
        
        return $this;
    }

    public function toArray()
    {
        $store = $this->_store;
        
        if (!$store) {
            return [];
        }
        
        return get_object_vars($this->_store);
    }

    public function each(callable $callback)
    {
        foreach ($this->_store as $name => $value) {
            $callback($this->get($name), $name, $this);
        }
    }
}