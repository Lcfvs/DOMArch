<?php
namespace Assemblies\HTML\Layouts;

use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Error
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        static::_layout($page);
        static::_head($page);
    }

    protected static function _layout(
        HTMLPage $page
    )
    {
        $document = $page->getDocument();
        $fetcher = $page->getFetcher();
        $path = $fetcher->layout()->page()->getFilename();
        $document->loadSourceFile($path);
    }

    protected static function _head(
        HTMLPage $page
    )
    {
        $document = $page->getDocument();
        $url = $page->getUrl();

        $document->lang = $url->getLocale();
    }

    protected static function _footer(
        HTMLPage $page
    )
    {
    }
}