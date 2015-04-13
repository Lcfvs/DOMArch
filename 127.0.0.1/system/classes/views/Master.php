<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Views; 
  
class Master extends \PHPDOM\HTML\Document 
{
    public function __construct()
    {
        parent::__construct();
        
        \PHPDOM\HTML\SelectorCache::load();
        
        $this->loadHTMLFile(SYSTEM_DIR . '/templates/documents/document.html');
        $this->addStyleSheet('reset.css');
        $this->addStyleSheet('style.css');
        $this->select('head')->addScript('html5shiv.js');
    }
    
    public function addHeader($path)
    {
        $header = $this->loadFragment($path);
        
        $this->body->appendChild($header); 
    }
    
    public function __destruct()
    {
        \PHPDOM\HTML\SelectorCache::save();
        
        $this->body->addScript('script.js');
    }
}