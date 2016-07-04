<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

use PHPDOM\Common\Utils as Utils;

class Attrset
{
	private $_element;
    
    private $_fields = ['input', 'select', 'textarea'];
    private $_medias = ['audio', 'video'];
	
	public function __construct(Element $element)
	{
		$this->_element = $element;
	}
    
    public function __get($name)
    {
        $normalised = Utils::fromCamelCase($name);
        
        $element = $this->_element;
        
        if ($element->hasAttribute($normalised)) {
            return $element->getAttribute($normalised);
        }
    }
    
    public function __set($name, $value)
    {
        $normalised = Utils::fromCamelCase($name);
        
        if (is_null($value)) {
            return $this->_element->removeAttribute($normalised);
        }
        
        $tag = $this->nodeName;

        switch ($tag) {
            case 'script':
                switch ($normalised) {
                    case 'async':
                    case 'defer':
                        $value = $value ? $normalised : '';
                    break;
                }
                
            break;
                
            case 'track':
                switch ($normalised) {
                    case 'default':
                        $value = $value ? $normalised : '';
                    break;
                }
                
            break;
            
            default:
                if (in_array($tag, $this->_fields)) {
                    switch ($normalised) {
                        case 'autocomplete':
                            $value = $value ? 'on' : 'off';
                        break;

                        case 'autofocus':
                        case 'disabled':
                        case 'readonly':
                        case 'required':
                        case 'multiple':
                            $value = $value ? $normalised : '';
                        break;
                    }
                } else if (in_array($tag, $this->_medias)) {
                    switch ($normalised) {
                        case 'autoplay':
                        case 'defer':
                        case 'controls':
                        case 'loop':
                        case 'muted':
                            $value = $value ? $normalised : '';
                        break;
                    }
                }
        }

        $this->_element->setAttribute($normalised, $value);
    }
    
    public function get($name)
    {
        return $this->{$name};
    }
    
    public function set($name, $value)
    {
        $this->{$name} = $value;
		
		return $this;
    }
    
    public function getAll()
    {
		$results = [];
        $element = $this->_element;
        
        if (!$element->hasAttributes()) {
            return $results;
        }
        
        foreach ($element->attributes as $attribute) {
            $results[$attribute->nodeName] = $attribute->nodeValue;
        }
		
		return $results;
    }
    
    public function setAll()
    {
		$attributes = Utils::parseArrayArguments(func_get_args());
        
        foreach ($attributes as $name => $value) {
            $this->{$name} = $value;
        }
		
		return $this;
    }
    
    public function removeAll()
    {
        foreach ($this->getAll() as $name => $value) {
            $this->{$name} = null;
        }
		
		return $this;
    }
}