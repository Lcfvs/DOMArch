<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Error\Controllers;

class NotFound extends \DOMArch\Controller
{
    public function get()
    {
        $this->_view->error();
    }
}