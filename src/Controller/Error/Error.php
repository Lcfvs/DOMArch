<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Controller;

class Error extends \DOMArch\Controller
{
    public function notFound()
    {
        $this->_view->notFound();
    }

    public function internalAction(\Exception $exception)
    {
        $this->_view->internal($exception);
    }

    public function __call($method, $arguments)
    {
        $method = str_replace('Action', '', $method);
        
        $exception = array_shift($arguments);
        
        $this->_view->{$method}($exception);
    }
}