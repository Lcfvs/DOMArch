<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\View\HTML\Dev;

class Dump extends \DOMArch\View\HTML\Dev
{
    public function locate($file, $line)
    {
        $this->title = 'Dump';
        $body = $this->body;

        $body->select('h1')->textContent = 'Dump at ' . $file . ':' . $line;

        $body->append([
            'tag' => 'br'
        ]);
    }

    public function dump($dump)
    {
        $this->body->append([
            'tag' => 'pre',
            'data' => $dump
        ]);
    }
}