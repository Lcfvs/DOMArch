<?php
namespace Assemblies\HTML\Components;

use DOMArch\Assembly;
use Lib\View\HTML\Page as HTMLPage;

class Section
    extends Assembly
{
    public static function assemble(
        HTMLPage $page,
        string $name,
        string $parent_selector = null,
        ...$params
    )
    {
        $document = $page->getDocument();
        $fetcher = $page->getFetcher();

        $fragment = $fetcher->section()
            ->{$name}()
            ->fetch();

        $container = $document->select($parent_selector ?? 'body > main');

        $section = $fragment->select('section');

        $container->append($section);

        if (!empty($params)) {
            $section->select('h1')
                ->translate(...$params);
        }

        return new static($section);
    }
}