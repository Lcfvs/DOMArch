<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Storable;

trait Autosavable
{
    public function __destruct()
    {
        $this->save();
    }
}