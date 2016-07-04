<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Welcome\Views;

use Assemblies\HTML\Sections\Welcome as Section;
use Lib\View\HTML\Page;

class Index
    extends Page
{
    public function get()
    {
        $section = Section::assemble($this);
        
        $section->translate();
    }
}