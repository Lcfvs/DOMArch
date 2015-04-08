<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Controllers;

class Master
{
    protected $_view;
    
    public function __construct()
    {
        $this->_view = \PHPDOM\HTML\Document::getView();
    }
}