<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\XML;

trait NodeTrait
{
    use SelectorTrait;
    
    public function append($definition = [])
    {
        return $this->insert($definition);
    }
    
    public function clean()
    {
        $this->normalize();
        $items = $this->childNodes;
        $iterator = 0;
        
        for (; $iterator < $items->length; $iterator += 1) {
            $item = $items->item($iterator);
            
            $type = $item->nodeType;

            if ($type === XML_COMMENT_NODE || ($type === XML_TEXT_NODE && preg_match('/^[\s\t\r\n]*$/', $item->nodeValue))) {
                $item->remove();
                $iterator -= 1;
            } else if ($type === XML_ELEMENT_NODE || $type === XML_DOCUMENT_FRAG_NODE) {
                $item->clean();
            }
        }
        
        return $this;
    }

    public function decorate($definition = [])
    {
        if ($this->isNode($definition)) {
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

    public function insert($definition = [], $before = null)
    {
        if ($this->isNode($definition)) {
            $node = $definition;
            
            if ($node instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }

        if (gettype($before) === 'string') {
            $before = $this->select($before);
        }
        
        if ($node instanceof DocumentFragment && !$node->children()->length) {
            @$this->insertBefore($node, $before);
        } else {
            $this->insertBefore($node, $before);
        }

        return $node;
    }

    public function prepend($definition = [])
    {
        if ($this->isNode($definition)) {
            $node = $definition;
            
            if ($node instanceof DocumentFragment) {
                $node->parent = $this;
            }
        } else {
            $node = $this->ownerDocument->create($definition);
        }
        
        $this->insert($node, $this->firstChild);

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
    
    public function remove()
    {
        $fragment = $this->ownerDocument->createDocumentFragment();
        
        $fragment->appendChild($this);
        
        return $this;
    }

    public function isNode($value)
    {
        return $value instanceof self
        || $value instanceof DocumentFragment
        || $value instanceof Text;
    }

    public function saveSource($filename, $flags = 0, $context = null)
    {
        file_put_contents($path, $this, $flags, $context);
        
        return $this;
    }

    public function __toString()
    {
        $owner_document = $this->ownerDocument;
        
        if (!$owner_document->formatOutput) {
            $this->clean();
        }
        
        return $owner_document->saveXML($this);
    }
}