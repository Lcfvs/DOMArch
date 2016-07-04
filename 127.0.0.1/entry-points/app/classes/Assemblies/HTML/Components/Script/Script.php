<?php
namespace Assemblies\HTML\Components;

use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Script
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        $document = $page->getDocument();

        $document->addBodyScript('form.cheats/js/script.min.js', '/lib/');

        return new static($document);
    }

    public function validation()
    {
        $document = $this->_node;

        $document->addBodyScript('validation.js');

        return $this;
    }

    public function excel()
    {
        $document = $this->_node;

        $document->addBodyScript('js-xlsx/xlsx.core.min.js', '/lib/');
        $document->addBodyScript('js-xlsx/ods.js', '/lib/');
        $document->addBodyScript('CSVToArray/CSVToArray.js', '/lib/');

        return $this;
    }

    public function lib()
    {
        $document = $this->_node;

        $document->addBodyScript('lib.js');
        $document->addBodyScript('script.js');

        return $this;
    }
}