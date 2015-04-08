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
    public function __construct($as_view = null, $template = null)
    {
        parent::__construct($as_view, $template);
        $this->addLink('reset.css');
        $this->addLink('style.css');
    }
    
    public function addHeader($path)
    {
        $header = $this->loadFragment($path);
        
        $this->body->appendChild($header); 
    }
}