<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

trait NodeTrait
{
    use SelectorTrait;
    
    public function append($definition)
    {
        $node = $this->ownerDocument->create($definition);
        $this->appendChild($node);

        return $node;
    }

    public function decorate($definition)
    {
        $node = $this->parentNode->insert($definition, $this);
        $node->appendChild($this);

        return $node;
    }

    public function insert($definition, $before)
    {
        $node = $this->ownerDocument->create($definition);

        if ($before instanceof self) {
            $this->insertBefore($node, $before);

            return $node;
        }

        $before = $this->select($before);
        $this->insertBefore($node, $before);

        return $node;
    }

    public function prepend($definition)
    {
        $node = $this->ownerDocument->create($definition);
        $this->parentNode->insertBefore($node, $this);

        return $node;
    }

    public function children()
    {
        $nodes = $this->childNodes;

        if ($nodes) {
            return new NodeList($nodes);
        }
    }

    public function replace($definition)
    {
        $node = $this->ownerDocument->create($definition);
        $this->parentNode->replaceChild($node, $this);

        return $node;
    }
    
    public function __toString()
    {
        return $this->ownerDocument->saveHTML($this);
    }
}
