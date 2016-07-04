<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\FileReader\Controllers;

use Providers\Users;

class Index extends \DOMArch\Controller
{
    public function get()
    {
        $this->_view->get();
    }

    public function post()
    {
        $view = $this->_view;

        $view->get();
        $fields = $view->extract();
        
        $response = Users::service()
            ->insert($fields)
            ->fetch();

        var_dump($response);exit;
    }
}