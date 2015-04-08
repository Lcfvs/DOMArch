<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Controllers;

class Index extends Master
{
    public function indexAction()
    {
        $view = $this->_view;
        $view->title = 'Directory index';
        
        $files = $this->readPublicDir();
        
        $view->directoryIndex($files);
    }

    protected function readPublicDir()
    {
        $files = [];

        $handle = opendir(PUBLIC_DIR);
        
        while (($file = readdir($handle)) !== false) {
            $files[] = $file;
        }
        
        return $files;
    }
}