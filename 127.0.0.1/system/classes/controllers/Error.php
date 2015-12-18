<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Controllers;

class Error extends Master
{
    public function notFound($method, $arguments)
    {
        $this->_view->notFound();
    }
	
    public function __call($method, $arguments)
    {
        $method = str_replace('Action', '', $method);
        
        $this->_view->{$method}();
    }
}