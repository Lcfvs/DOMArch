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

class InternalError
    extends Page
{
    public function error()
    {
        $document = $this->getDocument();

        $document->title = 'internal-error';
        $document->select('title')->translate();

        $section = Section::assemble($this, 'internal-error');

        $section->translate();
    }

    public function debug(...$params)
    {
        $document = $this->getDocument();

        $document->title = 'internal-error';
        $document->select('title')->translate();

        Section::assemble($this, 'internal-error', $params);
    }
}