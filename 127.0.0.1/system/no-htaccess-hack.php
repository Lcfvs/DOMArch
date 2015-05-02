<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
$query_string = $_SERVER['QUERY_STRING'];

try {
    $file = new Resource\File(PUBLIC_DIR . $query_string);

    if (!$file->isChildOf(PUBLIC_DIR)) {
        throw new Exception('Not found');
    }
    
    if ($file->isChildOf(DOWNLOAD_DIR)) {
        $file->forceDownload();
    } else {
        $file->download();
    }
} catch (Exception $exception) {
    preg_match('/^(?:(?:\/(\w[\w\d]+)(?:\/(\w[\w\d]+))?)?\?(.*))/', $query_string, $matches);
    
    if (empty($matches[3])) {
        $_GET = [];
    } else {
        parse_str($matches[3], $_GET);
    }
    
    if (empty($matches[1])) {
        $_GET['class_name'] = 'index';
    } else {
        $_GET['class_name'] = $matches[1];
    }
    
    if (empty($matches[2])) {
        $_GET['action'] = 'indexAction';
    } else {
        $_GET['action'] = $matches[2] . 'Action';
    }
}