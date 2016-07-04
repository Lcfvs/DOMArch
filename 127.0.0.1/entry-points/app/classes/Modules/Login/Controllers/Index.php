<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Login\Controllers;

use DOMArch\Controller;
use Lib\Session;
use Lib\Request\Incoming;
use Providers;

class Index extends Controller
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
        $account = $fields['account'];
        $password = $fields['password'];

        $user = Providers\Users::login($account, $password);

        if (!$user) {
            $view->fill($fields);

            return;
        }

        Session::current()
            ->init('user', $user->toArray());

        Incoming::current()->home();
    }
}