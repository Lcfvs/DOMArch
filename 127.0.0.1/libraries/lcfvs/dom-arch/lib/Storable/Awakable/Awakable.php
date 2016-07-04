<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;

trait Awakable
{
    use \Storable;
    
    public function __wakeup()
    {}
    
    public function __sleep()
    {
        return array_keys(get_object_vars($this));
    }
}