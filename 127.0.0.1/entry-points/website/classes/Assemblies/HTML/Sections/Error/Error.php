<?php
namespace Assemblies\HTML\Sections;

use Assemblies\HTML\Components\Section;
use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Error
    extends Assembly
{
    public static function assemble(
        HTMLPage $page,
        string $title,
        array $debug_params = null
    )
    {
        $section = Section::assemble($page, 'error')->getNode();
        $h1 = $section->select('h1');

        $h1->textContent = $title;

        if (!$debug_params) {
            return new static($section);
        }

        list(
            $message,
            $file,
            $line,
            $context,
            $traces
        ) = $debug_params;

        $href = (string) $page->getUrl();
        $fetcher = $page->getFetcher();
        $debug = $fetcher->component()->debug()->fetch();

        $a = $debug->select('.url + dd a');
        $a->append($href);
        $a->attrset->href = $href;

        $debug->select('.file + dd')->append($file . ':' . $line);
        $debug->select('.message + dd')->append($message);
        $debug->select('pre')->append(static::_prettify($traces));

        $section->append($debug);

        return new static($section);
    }

    protected static function _prettify(
        array $traces
    )
    {
        $str = '';

        foreach ($traces as $trace) {
            $str .= $trace['file'] . ':' . $trace['line'];
            $str .= PHP_EOL;
            $str .= $trace['class'] . $trace['type'] . $trace['function'] . '()';
            $str .= PHP_EOL;
            $str .= PHP_EOL;
        }

        return trim($str);
    }

    public function translate()
    {
        $section = $this->_node;

        $section->select('h1')->translate();
    }
}