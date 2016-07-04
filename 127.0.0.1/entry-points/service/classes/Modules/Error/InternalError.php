<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Error;

use Lib\Controller;

class InternalError
    extends Controller
{
    public function get(
        string $message,
        string $file,
        int $line,
        array $context,
        array $traces
    )
    {
        $view = $this->_view;

        if (!Config::global()->get('context')->get('isDevMode')) {
            // todo add to logs
            exit('define logger!');
        }

        $view
            ->set('message', $message)
            ->set('file', $file . ':' . $line)
            ->set('traces', $traces);
    }
}