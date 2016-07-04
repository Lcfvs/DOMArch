<?php
namespace Assemblies\HTML\Layouts;

use Lib\Request;
use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Page
    extends Assembly
{
    public static function assemble(
        HTMLPage $page
    )
    {
        if (http_response_code() !== Request::STATUS_OK) {
            Error::assemble($page);

            return;
        }
        
        static::_layout($page);
        static::_head($page);
        static::_header($page);
        static::_footer($page);
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
        $fetcher = $page->getFetcher();
        $url = $page->getUrl();

        $document->lang = $url->getLocale();
        $canonical = $url->getCanonical();
        $alternates = $url->getAlternates();
        $format = $url->getFormat();

        $document->title = $format;
        $document->select('title')->translate();

        $head = $document->head;
        $link_fetcher = $fetcher->element()->link();
        $alternate_link = $link_fetcher->alternate();
        $canonical_link = $link_fetcher->canonical();

        $link_fragment = $canonical_link->fetch();

        $link = $link_fragment->select('link');
        $link->attrset->href = $canonical;
        $link->attrset->hreflang = $document->lang;

        foreach ($alternates as $locale => $alternate) {
            $link_fragment = $alternate_link->fetch();

            $link = $link_fragment->select('link');
            $link->attrset->href = $alternate;
            $link->attrset->hreflang = $locale;
            $head->append($link);
        }

        $head->append($link);
    }

    protected static function _header(
        HTMLPage $page
    )
    {
        $document = $page->getDocument();
        $fetcher = $page->getFetcher();
        $url = $page->getUrl();
        $alternates = $url->getAlternates();
        $format = $url->getFormat();
        $locale = $url->getLocale();

        $home = $document->select('a');
        $home->attrset->href = $url->rewrite([
            'className' => 'Index',
            'method' => 'get',
            'moduleName' => 'FileReader',
            'locale' => $locale
        ]);
        $home->translateAttr('href');

        $languages = $document->select('#languages');
        $li_item = $fetcher->component()->anchoredItem();

        $li_fragment = $li_item->fetch();

        $li = $li_fragment->select('li');
        $a = $li->select('a');
        $a->append(strtoupper($locale));

        $languages->append($li);

        foreach ($alternates as $locale => $alternate) {
            $li_fragment = $li_item->fetch();

            $li = $li_fragment->select('li');
            $a = $li->select('a');
            $a->append(strtoupper($locale));
            $a->attrset->href = $alternate;
            $a->attrset->title = $format;
            $a->attrset->lang = $locale;
            $a->attrset->hreflang = $locale;

            $a->translateAttr('title');

            $languages->append($li);
        }
    }

    protected static function _footer(
        HTMLPage $page
    )
    {
    }
}