<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
declare(strict_types = 1);

// require_once 'maintenance.php';
require_once 'vendor/autoload.php';

chdir(__DIR__);
ignore_user_abort(true);
ini_set('display_errors', 'off');
ini_set('display_startup_errors', 'off');
error_reporting(E_ALL);

Lib\Config::parse(__DIR__ . '/config.json', true);
DOMArch\ErrorHandler::handle();
Lib\Bootstrap\Web::bootstrap();
Lib\Request\Incoming::current()->respond();