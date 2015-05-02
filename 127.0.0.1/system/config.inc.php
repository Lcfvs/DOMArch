<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
require_once 'autoloader.php';

set_include_path(
    __DIR__ . '/classes;'
  . __DIR__ . '/classes/models'
);

define('SYSTEM_DIR', __DIR__);
define('PUBLIC_DIR', __DIR__ . '/../public');
define('DOWNLOAD_DIR', PUBLIC_DIR . '/download');

define('MIME_TYPES_URL','http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
define('DOWNLOAD_SPEED', 1000000);