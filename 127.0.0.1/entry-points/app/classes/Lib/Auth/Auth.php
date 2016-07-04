<?php
namespace Lib;

use Lib\Request\Incoming;

final class Auth
{
    private function __construct()
    {}

    public static function detect()
    {
        $request = Incoming::current();
        $url = $request->getUrl();
        $module_name = $url->getModuleName();

        if ($module_name === 'Error') {
            return;
        }

        $has_session = Session::detect();

        if ($module_name === 'Login') {
            if ($has_session) {
                $request->home();
            }

            return;
        }

        if (!$has_session || !Session::current()->get('user')) {
            $request->forceAuthentication();
        }

        if ($request === Incoming::requested() && $url->getPath() === '/') {
            $request->home();
        }
    }
}