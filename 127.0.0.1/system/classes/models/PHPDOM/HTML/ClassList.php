<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

class ClassList
{
	private $_element;
	
	public function __construct(Element $element)
	{
		$this->_element = $element;
	}
	
	public function contains($class_name)
	{
        $class_names = $this->getAll();

		return array_search($class_name, $class_names) !== false;
	}
	
	public function add($class_name)
	{
		if (is_array($class_name)) {
			foreach (class_name as $class)  {
				$this->add($class);
			}
			
			return $this;
		}
        
        if ($this->contains($class_name)) {
            return $this;
        }
		
		$element = $this->_element;
		$value = $element->getAttribute('class');
		$value = $this->_normalize($value . ' ' . $class_name);
		
		$element->setAttribute('class', $value);
        
        return $this;
	}
	
	public function remove($class_name)
	{
		if (is_array($class_name)) {
			foreach (class_name as $class)  {
				$this->remove($class);
			}
			
			return $this;
		}
		
		$class_names = $this->getAll();
		
		$key = array_search($class_name, $class_names);
		
		if ($key === false) {
			return $this;
		}
		
		unset($class_names[$key]);
		$value = implode(' ', $class_names);
		
		$this->_element->setAttribute('class', $value);
		
		return $this;
	}
	
	public function getAll()
	{
		$value = $this->_element->getAttribute('class');
		$value = $this->_normalize($value);
		$class_names = explode(' ', $value);
		
		return $class_names;
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