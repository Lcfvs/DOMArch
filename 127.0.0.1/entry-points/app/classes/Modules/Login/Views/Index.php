<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Login\Views;

use Assemblies\HTML\Sections\Login as Section;
use Lib\View\HTML\Page;

class Index
    extends Page
{
    protected $_section;

    public function get()
    {
        $section = Section::assemble($this);
        $this->_section = $section;

        $section->translate();

        return $this;
    }

    public function extract()
    {
        return $this->_section->extract();
    }

    public function fill(
        array $values = []
    )
    {
        $this->_section->fill($values);

        return $this;
    }
}