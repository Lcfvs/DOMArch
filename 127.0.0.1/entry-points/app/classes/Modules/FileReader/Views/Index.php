<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\FileReader\Views;

use Assemblies\HTML\Components\Script;
use Assemblies\HTML\Sections\FileReader as Section;
use Lib\View\HTML\Page;

class Index
    extends Page
{
    protected $_section;

    public function get()
    {
        Script::assemble($this)
            ->excel()
            ->lib();
        
        $section = Section::assemble($this);
        $this->_section = $section;

        $section->translate();

        return $this;
    }

    public function extract()
    {
        return $this->_section->extract();
    }
}