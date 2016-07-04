<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Welcome\Controllers;

class Index extends \DOMArch\Controller
{
    public function get()
    {
        $this->_view->get();
    }
}