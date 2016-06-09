<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

use PHPDOM\HTML\Attrset\Dataset as Dataset;

class Element extends \DOMElement
{
    use NodeTrait;
    
    private $_classList;
    private $_attrset;
    private $_dataset;

    public function addClass($name)
    {
        trigger_error(
            'Element::addClass is deprecated, use Element::classList::add() instead',
            E_USER_DEPRECATED
        );
        
        $this->classList->add($name);

        return $this;
    }

    public function removeClass($name = null)
    {
        trigger_error(
            'Element::removeClass is deprecated, use Element::classList::remove() instead',
            E_USER_DEPRECATED
        );
        
        $this->classList->remove($name);
        
        return $this;
    }
    
    public function setAttr(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->attrset->{$name} = $value;
        }

        return $this;
    }

    public function getAttr()
    {
        return $this->attrset->getAll();
    }
    
    public function removeAttr(array $names = null)
    {
        if (!is_null($names)) {
            $names = array_keys($this->getAttr());
        }
        
        foreach ($names as $name) {
            $this->attrset->{$name} = null;
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
            case 'classList':
                $class_list = $this->_classList;
                
                if ($class_list) {
                    return $class_list;
                }
                
                
                return $this->_classList = new ClassList($this);
                
            case 'attrset':
                $attrset = $this->_attrset;
                
                if ($attrset) {
                    return $attrset;
                }
                
                
                return $this->_attrset = new Attrset($this);
                
            case 'dataset':
                $dataset = $this->_dataset;
                
                if ($dataset) {
                    return $dataset;
                }
                
                
                return $this->_dataset = new Dataset($this);
                
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

    public function saveSource($filename, $flags = 0, $context = null)
    {
        file_put_contents($path, $this, $flags, $context);
        
        return $this;
    }
}