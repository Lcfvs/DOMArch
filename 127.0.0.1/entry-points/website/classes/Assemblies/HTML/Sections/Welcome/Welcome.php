<?php
namespace Assemblies\HTML\Sections;

use Assemblies\HTML\Components\Section;
use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Welcome
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        $document = $page->getDocument();
        $section = Section::assemble($page, 'welcome')->getNode();

        $a = $section->select('a');
        $a->attrset->href = $document->url([
            'moduleName' => 'FileReader',
            'className' => 'Index'
        ]);

        $login = $document->create([
            'tag' => 'a',
            'data' => 'login-anchor',
            'attributes' => [
                'href' => $document->appUrl([
                    'moduleName' => 'Login',
                    'className' => 'Index'
                ])
            ]
        ]);

        $section->append($login);

        return new static($section);
    }

    public function translate()
    {
        $section = $this->_node;

        $this->_translateAttr($section, 'href');

        $this->_translate($section);
    }
}