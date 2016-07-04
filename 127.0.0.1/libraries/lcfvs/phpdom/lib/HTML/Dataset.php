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

class Dataset extends Attrset
{
	const CAMEL_CASE_PATTERN = '/^([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)$/';

	private $_element;

	public function __construct(Element $element)
	{
		parent::__construct($element);

		$this->_element = $element;
	}

	public function __get($attr_name)
	{
		$normalized = Utils::fromCamelCase($attr_name);

		return $this->_element->attrset->{'data-' . $normalized};
	}

	public function __set($attr_name, $value)
	{
		$normalized = Utils::fromCamelCase($attr_name);

		$this->_element->attrset->{'data-' . $normalized} = $value;
	}

	public function getAll()
	{
		$data = [];
		$attributes = $this->_element->attrset->getAll();

		foreach ($attributes as $name => $value) {
			if (strpos($name, 'data-') !== 0) {
				continue;
			}

			$data[Utils::toCamelCase($name)] = $value;
		}

		return $data;
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
		$attrset = $this->_element->attrset;

		foreach ($attrset->getAll() as $name => $value) {
			if (strpos($name, 'data-') !== 0) {
				continue;
			}

			$attrset->{$name} = null;
		}

		return $this;
	}
}