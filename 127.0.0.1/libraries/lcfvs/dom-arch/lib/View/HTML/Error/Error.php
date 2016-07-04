<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\View\HTML;

class Error extends \DOMArch\View\HTML
{
    public function notFound()
    {
        $this->_write('Not Found');
    }
    
    public function internal(\Exception $exception)
    {
        $this->_write('Internal Error');
        
        var_dump($exception);
    }
    
    protected function _write($text)
    {
        $this->title = $text;
        
        $this->body->select('h1')->replace([
            'tag' => 'h1',
            'data' => $text
        ]);
    }
};