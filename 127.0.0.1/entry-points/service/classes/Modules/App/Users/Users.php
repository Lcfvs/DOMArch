<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\App;

use Lib\Controller;
use Lib\Request\Incoming;
use Users as Entity;

class Users
    extends Controller
{
    public function get()
    {
        $url_params = Incoming::current()->getUrl()->getParams();

        $account = $url_params->get('account');
        $password = $url_params->get('password');

        $user = Entity::getEntityRepository()
            ->selectByLogin($account, $password);

        if (!$user) {
            Incoming::current()->notFound();
        }

        $this->_view->fill($user->toArray());
    }
}