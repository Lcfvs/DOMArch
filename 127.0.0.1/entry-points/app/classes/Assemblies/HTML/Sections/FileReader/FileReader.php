<?php
namespace Assemblies\HTML\Sections;

use Assemblies\HTML\Components\Section;
use DOMArch\Assembly;
use Lib\Config;
use Lib\View\HTML\Page as HTMLPage;

class FileReader
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        $section = Section::assemble($page, 'fileReader')->getNode();

        $form = $section->select('form');
        $max_file_size = $form->select('input[name="MAX_FILE_SIZE"]');

        $form->attrset->action = $page->getUrl();

        $max_file_size->value = Config::global()
            ->get('common')
            ->get('maxFileSize');

        return new static($section);
    }

    public function translate()
    {
        $section = $this->getNode();

        $form = $section->select('form');

        $form->translateAttr('action');

        $this->_translate($section);
    }
}