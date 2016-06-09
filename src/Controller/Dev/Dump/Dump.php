<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Controller\Dev;

class Dump extends \DOMArch\Controller\Dev
{
    public function dump($value)
    {
        $trace = debug_backtrace()[1];

        $this->_view->locate($trace['file'], $trace['line']);
        $this->_view->dump(print_r($value, true));
    }
}