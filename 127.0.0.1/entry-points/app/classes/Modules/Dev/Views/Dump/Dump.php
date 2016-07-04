<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Dev\Views;

use Assemblies\HTML\Sections\Dump as Section;
use DOMArch\Set;
use Lib\View\HTML\Page;

class Dump
    extends Page
{
    private $_values = [];

    public function dump()
    {
        $file = $this->get('file');
        $line = $this->get('line');
        $value = $this->get('value');

        Section::assemble($this, $file, $line, $value);
    }

    public function set(
        string $name,
        $value
    )
    {
        $this->_values[$name] = $value;

        return $this;
    }

    public function get(
        string $name
    )
    {
        return $this->_values[$name] ?? null;
    }
}