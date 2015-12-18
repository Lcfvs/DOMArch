<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/

namespace PHPDOM\XML;

class DocumentFragment extends \DOMDocumentFragment
{
    use NodeTrait;
    
    public $parent = null;
}