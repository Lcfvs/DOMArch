<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

abstract class Controller
{
    protected $_view;
    
    public function __construct($view)
    {
        $this->_view = $view;
    }
}