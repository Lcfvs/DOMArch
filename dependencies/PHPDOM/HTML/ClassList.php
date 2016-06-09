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

class ClassList
{
	private $_element;
	
	public function __construct(Element $element)
	{
		$this->_element = $element;
	}
	
	public function contains()
	{
        $searched = Utils::parseStringArguments(func_get_args());
        
        $class_names = $this->getAll();
        
        foreach ($searched as $key => $class_name) {
            if (array_search($class_name, $class_names) !== false) {
                unset($searched[$key]);
            }
        }

		return count($searched) === 0;
	}
	
	public function add()
	{
        $class_names = Utils::parseStringArguments(func_get_args());
        
		if (count($class_names) !== 1) {
			foreach ($class_names as $class_name)  {
				$this->add($class_name);
			}
			
			return $this;
		}
        
        $class_name = $class_names[0];
        
        if ($this->contains($class_name)) {
            return $this;
        }
		
		$element = $this->_element;
		$value = $element->getAttribute('class');
		$value = $this->_normalize($value . ' ' . $class_name);
		
		$element->setAttribute('class', $value);
        
        return $this;
	}
	
	public function remove()
	{
        $searched = Utils::parseStringArguments(func_get_args());
        
        $counter = count($searched);
		$class_names = $this->getAll();
        
		if (!$counter) {
			$searched = $class_names;
		}
        
		if (count($searched) > 1) {
			foreach ($searched as $class_name)  {
				$this->remove($class_name);
			}
			
			return $this;
		}
        
        $class_name = $class_names[0];
		
		$key = array_search($class_name, $class_names);
		
		if ($key === false) {
			return $this;
		}
		
		unset($class_names[$key]);
		$value = implode(' ', $class_names);
		
		$this->_element->setAttribute('class', $value);
		
		return $this;
	}
	
	public function toggle()
	{
        $class_names = Utils::parseStringArguments(func_get_args());
        
        foreach ($class_names as $class_name) {
            if ($this->contains($class_name)) {
                $this->remove($class_name);
            } else {
                $this->add($class_name);
            }
        }
		
		return $this;
	}
    
	public function getAll()
	{
		$value = $this->_element->getAttribute('class');
		$value = $this->_normalize($value);
		$class_names = explode(' ', $value);
		
		return $class_names;
	}
    
	public function removeAll()
	{
		return $this->remove();
	}
	
	public function __toString()
	{
		$class_names = $this->getAll();
		$value = implode(' ', $class_names);
		
		return $value;
	}
	
	private function _normalize($value)
	{
		return preg_replace('/\s+/', ' ', $value);
	}
}