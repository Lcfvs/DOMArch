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
        $node = $this->parentNode->insert($definition, $this);
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

    public function addClass($name)
    {
        $this->removeClass($name);
        
        $class = $this->getAttribute('class');
        
        if ($class) {
            $class->nodeValue .= ' ' . $name;
        } else {
            $this->setAttribute('class', $name);
        }

        return $node;
    }

    public function removeClass($name = null)
    {
        if (is_null($name)) {
            $this->removeAttribute('class');
            
            return $this;
        }
        
        $class = $this->getAttribute('class');
        
        if (empty($class)) {
            return $node;
        }
        
        $classes = trim(preg_plit('/((?:^|\s*)' . $name . '\s*)/', '', $class->nodeValue));
        
        if (empty($classes)) {
            $this->removeAttribute('class');
        } else {
            $class->nodeValue = $classes;
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
        
        if ($this instanceof Document) {
            return $this->body->append($definition);
        } else {
            return $this->append($definition);
        }
    }
    
    public function __toString()
    {
        return $this->ownerDocument->saveHTML($this);
    }
}