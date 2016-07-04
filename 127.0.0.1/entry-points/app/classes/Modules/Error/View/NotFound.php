<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Modules\Error\Views;

use Assemblies\HTML\Sections\Error as Section;
use Lib\View\HTML\Page;

class NotFound
    extends Page
{
    public function error()
    {
        $document = $this->getDocument();

        $document->title = 'not-found';
        $document->select('title')->translate();

        $section = Section::assemble($this, 'not-found');

        $section->translate();
    }
}