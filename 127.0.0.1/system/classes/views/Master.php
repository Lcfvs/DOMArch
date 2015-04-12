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
        
        $this->loadHTMLFile(SYSTEM_DIR . '/templates/documents/document.html');
        $this->addLink('reset.css');
        $this->addLink('style.css');
        $this->body->addScript('script.js');
    }
    
    public function addHeader($path)
    {
        $header = $this->loadFragment($path);
        
        $this->body->appendChild($header); 
    }
}