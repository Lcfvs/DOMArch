<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\View;
  
abstract class HTML extends \PHPDOM\HTML\Document
{
    protected $_layoutPath;

    public function __construct()
    {
        parent::__construct();

        \PHPDOM\HTML\SelectorCache::load();

        $this->loadSourceFile($this->_layoutPath);
    }
    
    public function addHeader($path)
    {
        $header = $this->loadFragmentFile($path);
        
        $this->body->appendChild($header); 
    }

    public function print()
    {
        $html = (string) $this;

        header('Content-Type: text/html');
        header('Content-Length: ' . strlen($html));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Thu, 01 Jan 1970 00:00:00');

        echo $html;

        exit();
    }
    
    public function __destruct()
    {
        \PHPDOM\HTML\SelectorCache::save();
        
        $this->addBodyScript('script.js');
    }
}