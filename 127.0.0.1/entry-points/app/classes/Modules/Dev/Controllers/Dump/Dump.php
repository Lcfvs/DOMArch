<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Dev\Controllers;

class Dump extends \DOMArch\Controller\Dev\Dump
{
    public function dump($value)
    {
        parent::dump($value);

        $this->_view->dump();
    }
}