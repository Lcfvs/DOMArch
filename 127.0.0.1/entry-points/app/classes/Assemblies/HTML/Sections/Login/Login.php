<?php
namespace Assemblies\HTML\Sections;

use Assemblies\HTML\Components\Section;
use DOMArch\Assembly;
use Lib\Form\Filler;
use Lib\View\HTML\Page as HTMLPage;

class Login
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        $section = Section::assemble($page, 'login')->getNode();
        $section->select('form')->attrset->action = (string) $page->getUrl();
        
        return new static($section);
    }

    public function fill(
        array $values = []
    )
    {
        $form = $this->getNode()->select('form');

        Filler::fill($form, $values);

        return $this;
    }

    public function translate()
    {
        $section = $this->getNode();
        $section->select('form')->translateAttr('action');
        $section->select('#account')->translateAttr('placeholder');

        $this->_translate($section);
    }
}