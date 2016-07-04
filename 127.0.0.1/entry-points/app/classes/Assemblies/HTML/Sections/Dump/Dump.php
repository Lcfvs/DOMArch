<?php
namespace Assemblies\HTML\Sections;

use Assemblies\HTML\Components\Section;
use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Dump
    extends Assembly
{
    public static function assemble(
        HTMLPage $page,
        string $file_name,
        int $line,
        $value
    )
    {
        $section = Section::assemble($page, 'dump')->getNode();
        $href = (string) $page->getUrl();

        $section->ownerDocument->title = 'Dump';

        $a = $section->select('.url + dd a');
        $a->append($href);
        $a->attrset->href = $href;

        $section->select('.file + dd')
            ->append($file_name . ':' . $line);

        $section->select('pre')->append($value);

        return new static($section);
    }
}