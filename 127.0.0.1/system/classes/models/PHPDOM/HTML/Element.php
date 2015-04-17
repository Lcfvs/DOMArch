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
    
    private $_fields = ['input', 'select', 'textarea'];
    private $_medias = ['audio', 'video'];

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
    
    public function setAttribute($name, $value = null)
    {
        if (is_null($value)) {
            return $this->removeAttribute($name);
        }
        
        $tag = $this->nodeName;

        switch ($tag) {
            case 'script':
                switch ($name) {
                    case 'async':
                    case 'defer':
                        $value = $value ? $name : '';
                    break;
                }
                
            break;
                
            case 'track':
                switch ($name) {
                    case 'default':
                        $value = $value ? $name : '';
                    break;
                }
                
            break;
            
            default:
                if (in_array($tag, $this->_fields)) {
                    switch ($name) {
                        case 'autocomplete':
                            $value = $value ? 'on' : 'off';
                        break;

                        case 'autofocus':
                        case 'disabled':
                        case 'readonly':
                        case 'required':
                        case 'multiple':
                            $value = $value ? $name : '';
                        break;
                    }
                } else if (in_array($tag, $this->_medias)) {
                    switch ($name) {
                        case 'autoplay':
                        case 'defer':
                        case 'controls':
                        case 'loop':
                        case 'muted':
                            $value = $value ? $name : '';
                        break;
                    }
                }
        }
        
        parent::setAttribute($name, $value);
        
        return $this;
    }
    
    public function setAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
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