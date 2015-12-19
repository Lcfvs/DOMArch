<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
require_once 'config.inc.php';

if (defined('NO_HTACCESS_HACK')) {
    require_once NO_HTACCESS_HACK;
}

$class_name = ucfirst($_GET['class_name']);
$action = $_GET['action'];

$controller = 'Controllers\\' . $class_name;
$view = 'Views\\' . $class_name;

try {
	$has_dependencies = $_GET['class_name'] !== 'master'
	&& is_readable(__DIR__ . '/classes/Controllers/' . $class_name . '.php')
	&& is_readable(__DIR__ . '/classes/Views/' . $class_name . '.php')
	&& (new ReflectionMethod($controller, $action))->isPublic();
    
    if (!$has_dependencies) {
        throw new Exception();
    }
} catch(Exception $exception) {
    $action = 'notFoundAction';
    $controller = 'Controllers\\Error';
    $view = 'Views\\Error';
}

try {
    $view = new $view();
    (new $controller($view))->{$action}();
} catch (Exception $exception) {
    $view = new Views\Error();
    (new Controllers\Error($view))->internalErrorAction($exception);
};

exit($view);