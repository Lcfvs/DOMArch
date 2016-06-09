<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

class Element extends \DOMElement
{
    use NodeTrait;

    public function setAttribute($name, $value = null)
    {
        if (is_null($value)) {
            return $this->removeAttribute($name);
        }
        
        parent::setAttribute($name, $value);
        
        return $this;
    }
    
    public function setAttr($attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    public function getAttr()
    {
        $attributes = [];
        $attribute_list = $this->attributes;
        $iterator = 0;
        $length = $attribute_list->length;
        
        for (; $iterator < $length; $iterator += 1) {
            $attribute = $attribute_list->item($iterator);
            $attributes[$attribute->name] = $attribute->nodeValue;
        }
        
        return $attributes;
    }
    
    public function removeAttr(array $names = null)
    {
        if (!is_null($names)) {
            $names = array_keys($this->getAttributes());
        }
        
        foreach ($names as $name) {
            $this->removeAttribute($name);
        }

        return $this;
    }

    public function matches($selector)
    {
        $node_list = $this->ownerDocument->selectAll($selector);
        
        $index = 0;
        $length = $node_list->length;

        for (; $index < $length; $index += 1) {
            if ($this->isSameNode($node_list->item($index))) {
                return true;
            }
        }
        
        return false;
    }
}