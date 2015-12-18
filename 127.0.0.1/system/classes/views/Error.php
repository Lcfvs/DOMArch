<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Views;

class Error extends Master
{
    public function notFound()
    {
        $this->_write('Not Found');
    }
    
    public function internalError($exception)
    {
        $this->_write('Internal Error');
    }
    
    protected function _write($text)
    {
        $this->title = $text;
        
        $this->body->select('h1')->replace([
            'tag' => 'h1',
            'data' => $text
        ]);
    }
}