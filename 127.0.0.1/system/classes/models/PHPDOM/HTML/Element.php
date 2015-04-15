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
    
    public function setAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
            if (is_null($value)) {
                $this->removeAttribute($name);
                
                continue;
            }
            
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    public function getAttributes()
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
    
    public function removeAttributes(array $names = null)
    {
        if (!is_null($names)) {
            $names = array_keys($this->getAttributes());
        }
        
        foreach ($names as $name) {
            $this->removeAttribute($name);
        }

        return $this;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'elements':
                if ($this->nodeName === 'form') {
                    return $this->selectAll('input, select, textarea');
                }

                break;

            case 'value':
                switch ($this->nodeName) {
                    case 'textarea':
                        return $this->nodeValue;

                    case 'input':
                        switch ($this->getAttribute('type')) {
                            case 'checkbox':
                            case 'radio':
                                if ($this->getAttribute('checked') !== 'checked') {
                                    break;
                                }

                            default:
                                return $this->getAttribute('value');
                        }

                        break;

                    case 'select':
                        $selected_option = $this->select(':scope > [selected="selected"]');

                        if ($selected_option) {
                            return $selected_option->getAttribute('value');
                        }
                }

                break;
        }
    }

    public function __set($name, $value)
    {
        if ($name === 'value') {
            switch ($this->nodeName) {
                case 'select':
                    $selected_option = $this->select(':scope > [value="' . $value . '"]');

                    if ($selected_option) {
                        $selected_option->setAttribute('selected', 'selected');
                    }

                break;

                case 'textarea':
                    $this->nodeValue = $value;

                    break;

                case 'input':
                    switch ($this->getAttribute('type')) {
                        case 'checkbox':
                        case 'radio':
                            if ($value) {
                                $this->setAttribute('checked', 'checked');
                            } else {
                                $this->removeAttribute('checked');
                            }

                            break;

                        default:
                            $this->setAttribute('value', $value);
                    }
            }
        }
    }
}