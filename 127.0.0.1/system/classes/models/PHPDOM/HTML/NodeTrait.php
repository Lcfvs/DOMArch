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
        return $this->insert($definition);
    }

    public function decorate($definition)
    {
        if ($definition instanceof self || $definition instanceof DocumentFragment) {
            $node = $definition;
            
            if ($definition instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }
        
        if (!empty($this->parentNode)) {
            $this->parentNode->insert($node, $this);
        } else if (!empty($this->parent)) {
            $this->parent->insert($node, $this);
        }
        
        $node->append($this);

        return $node;
    }

    public function insert($definition, $before = null)
    {
        if ($definition instanceof self || $definition instanceof DocumentFragment) {
            $node = $definition;
            
            if ($definition instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }

        if ($before instanceof self instanceof DocumentFragment) {
            $this->insertBefore($node, $before);

            return $node;
        }

        if (gettype($before) === 'string') {
            $before = $this->select($before);
        }
        
        $this->insertBefore($node, $before);

        return $node;
    }

    public function prepend($definition)
    {
        if ($definition instanceof self || $definition instanceof DocumentFragment) {
            $node = $definition;
            
            if ($definition instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }
        
        if (!empty($this->parentNode)) {
            $this->parentNode->insertBefore($node, $this);
        } else if (!empty($this->parent)) {
            $this->parent->insertBefore($node, $this);
        }

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
        if ($definition instanceof self || $definition instanceof DocumentFragment) {
            $node = $definition;
            
            if ($definition instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }
        
        if (!empty($this->parentNode)) {
            $this->parentNode->replaceChild($node, $this);
        } else if (!empty($this->parent)) {
            $this->parent->replaceChild($node, $this);
        }

        return $node;
    }

    public function addScript($path, $directory = '/js/', array $attributes = [])
    {
        $definition = array_merge([ 
            'tag' => 'script', 
            'attributes' => [ 
                'src' => $directory . $path 
            ] 
        ], $attributes);
        
        return $this->append($definition);
    }
    
    public function __toString()
    {
        return $this->ownerDocument->saveHTML($this);
    }
}