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
        Utils::validatePropertyName($name);
        
        $element = $this->_element;
        
        if ($element->hasAttribute($name)) {
            return $element->getAttribute($name);
        }
    }
    
    public function __set($name, $value)
    {
        Utils::validatePropertyName($name);
        
        if (is_null($value)) {
            return $this->_element->removeAttribute($name);
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

        $this->_element->setAttribute($name, $value);
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