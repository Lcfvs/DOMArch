<?php
/*
Copyright 2015 Lcf.vs
Copyright © 2008 - 2009 TJ Holowaychuk <tj@vision-media.ca>
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

trait SelectorTrait
{
    public function query($query)
    {
        $node_list = $this->ownerDocument->xpath
            ->evaluate($query, $this);

        if ($node_list instanceof \DOMNodeList) {
            return new NodeList($node_list);
        }
    }

    public function select($selector)
    {
        $node_list = $this->selectAll($selector);

        if ($node_list instanceof NodeList) {
            return $node_list->item(0);
        }
    }

    public function selectAll($selector)
    {
        $query = self::_parse($selector);
        
        if ($this instanceof DocumentFragment && $this->parent) {
            $query = preg_replace('/(^|\|)(descendant(?:-or-self)::)/', '\1/\2', $query);
        }
        
        return $this->query($query);
    }

    private static function _parse($selector)
    {
        $query = SelectorCache::get($selector);
        
        if ($query) {
            return $query;
        }

        $query = $selector;

        // remove spaces around operators
        $query = preg_replace('/\s*>\s*/', '>', $query);
        $query = preg_replace('/\s*~\s*/', '~', $query);
        $query = preg_replace('/\s*\+\s*/', '+', $query);
        $query = preg_replace('/\s*,\s*/', ',', $query);
        $queries = preg_split('/\s+(?![^\[]+\])/', $query);

        foreach ($queries as &$query) {
            // ,
            $query = preg_replace('/,/', '|descendant-or-self::', $query);
            // input:checked, :disabled, etc.
            $query = preg_replace('/(.+)?:(checked|disabled|required|autofocus)/', '\1[@\2="\2"]', $query);
            // input:autocomplete, :autocomplete
            $query = preg_replace('/(.+)?:(autocomplete)/', '\1[@\2="on"]', $query);
            // input:button, input:submit, etc.
            $query = preg_replace('/input:(text|password|checkbox|radio|button|submit|reset|file|hidden|image|datetime-local|datetime|date|month|time|week|number|range|email|url|search|tel|color)/', 'input[@type="\1"]', $query);
            // foo[id]
            $query = preg_replace('/(\w+)\[([_\w-]+[_\w\d-]*)\]/', '\1[@\2]', $query);
            // [id]
            $query = preg_replace('/\[([_\w-]+[_\w\d-]*)\]/', '*[@\1]', $query);
            // foo[id=foo]
            $query = preg_replace('/\[([_\w-]+[_\w\d-]*)=[\'"]?(.*?)[\'"]?\]/', '[@\1="\2"]', $query);
            // [id=foo]
            $query = preg_replace('/^\[/', '*[', $query);
            // div#foo
            $query = preg_replace('/([_\w-]+[_\w\d-]*)\#([_\w-]+[_\w\d-]*)/', '\1[@id="\2"]', $query);
            // #foo
            $query = preg_replace('/\#([_\w-]+[_\w\d-]*)/', '*[@id="\1"]', $query);
            // div.foo
            $query = preg_replace('/([_\w-]+[_\w\d-]*)\.([_\w-]+[_\w\d-]*)/', '\1[contains(concat(" ",@class," ")," \2 ")]', $query);
            // .foo
            $query = preg_replace('/\.([_\w-]+[_\w\d-]*)/', '*[contains(concat(" ",@class," ")," \1 ")]', $query);
            // div:first-child
            $query = preg_replace('/([_\w-]+[_\w\d-]*):first-child/', '*/\1[position()=1]', $query);
            // div:last-child
            $query = preg_replace('/([_\w-]+[_\w\d-]*):last-child/', '*/\1[position()=last()]', $query);
            // :first-child
            $query = str_replace(':first-child', '*/*[position()=1]', $query);
            // :last-child
            $query = str_replace(':last-child', '*/*[position()=last()]', $query);
            // :nth-last-child
            $query = preg_replace('/:nth-last-child\((\d+)\)/', '[position()=(last() - (\1 - 1))]', $query);
            // div:nth-child
            $query = preg_replace('/([_\w-]+[_\w\d-]*):nth-child\((\d+)\)/', '*/*[position()=\2 and self::\1]', $query);
            // :nth-child
            $query = preg_replace('/:nth-child\((\d+)\)/', '*/*[position()=\1]', $query);
            // :contains(Foo)
            $query = preg_replace('/([_\w-]+[_\w\d-]*):contains\((.*?)\)/', '\1[contains(string(.),"\2")]', $query);
            // >
            $query = preg_replace('/>/', '/', $query);
            // ~
            $query = preg_replace('/~/', '/following-sibling::', $query);
            // +
            $query = preg_replace('/\+([_\w-]+[_\w\d-]*)/', '/following-sibling::\1[position()=1]', $query);
            $query = str_replace(']*', ']', $query);
            $query = str_replace(']/*', ']', $query);
        }

        // ' '
        $query = implode('/descendant::', $queries);
        $query = 'descendant-or-self::' . $query;
        
        // :scope
        $query = preg_replace('/(\|)?descendant-or-self:::scope\/\[/', '\1*[', $query);
        $query = preg_replace('/(\|)?descendant-or-self:::scope/', '\1.', $query);
        // $element
        $sub_queries = explode(',', $query);

        foreach ($sub_queries as $key => $sub_query) {
            $parts = explode('$', $sub_query);
            $sub_query = array_shift($parts);

            if (count($parts) && preg_match_all('/((?:[^\/]*\/?\/?)|$)/', $parts[0], $matches)) {
                $results = $matches[0];
                $results[] = str_repeat('/..', count($results) - 2);
                $sub_query .= implode('', $results);
            }

            
            $sub_queries[$key] = $sub_query;
        }

        $query = implode(',', $sub_queries);

        return SelectorCache::set($selector, $query);
    }
}