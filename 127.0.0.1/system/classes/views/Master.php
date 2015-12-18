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
        
        $this->loadSourceFile(SYSTEM_DIR . '/templates/documents/document.html');
        
        if (defined('NO_HTACCESS_HACK')) {
            $this->addStyleSheet('reset.css', '?/css/');
            $this->addStyleSheet('style.css', '?/css/');
            $this->addHeadScript('html5shiv.js', '?/js/');
        } else {
            $this->addStyleSheet('reset.css');
            $this->addStyleSheet('style.css');
            $this->addHeadScript('html5shiv.js');
        }
    }
    
    public function addHeader($path)
    {
        $header = $this->loadFragmentFile($path);
        
        $this->body->appendChild($header); 
    }
    
    public function __destruct()
    {
        \PHPDOM\HTML\SelectorCache::save();
        
        if (defined('NO_HTACCESS_HACK')) {
            $this->addBodyScript('script.js', '?/js/');
        } else {
            $this->addBodyScript('script.js');
        }
    }
}