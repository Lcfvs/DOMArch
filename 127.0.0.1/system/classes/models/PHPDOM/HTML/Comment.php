<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

class Comment extends \DOMComment
{
    use NodeTrait;
    
    public function __toString()
    {
        return $this->data;
    }
}