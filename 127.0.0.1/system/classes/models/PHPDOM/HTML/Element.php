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
	private $_classList;
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
            $names = array_keys($this->getAttr());
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
            case 'classList':
				$class_list = $this->_classList;
				
                if ($class_list) {
					return $class_list;
                }
				
				
				return $this->_classList = new ClassList($this);
				
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
}