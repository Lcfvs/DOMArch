<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
$host = $_SERVER['HTTP_HOST'];
$directory = __DIR__ . '/' . $host . '/system';
$index = $directory . '/index.php';

if (is_readable($index)) {
    chdir($directory);

    define('NO_HTACCESS_HACK', 'no-htaccess-hack.php');
    
    require_once $index;
}