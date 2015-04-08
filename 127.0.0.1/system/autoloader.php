<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
function __autoload($class_name) {
    $class_name = ltrim($class_name, '\\');
    $file_name = '';
    $namespace = '';

    if ($position = strripos($class_name, '\\')) {
        $namespace = substr($class_name, 0, $position);
        $class_name = substr($class_name, $position + 1);
        $file_name = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

    require $file_name;
}