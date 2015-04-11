<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Views;

class Index extends Master
{
    public function directoryIndex($items)
    {
        $body = $this->body;
        $directory_index = $this->loadFragment('templates/fragments/directory-index.html');
        
        $ul = $body->append($directory_index)->select('ul');
        
        $body->select('h1')
            ->replace([
                'tag' => 'h1',
                'data' => 'Directory index'
            ])->decorate([
                'tag' => 'header'
            ]);
        
        foreach ($items as $name) {
            $ul->append([
                'tag' => 'li',
                'data' => $name
            ]);
        }
    }
}