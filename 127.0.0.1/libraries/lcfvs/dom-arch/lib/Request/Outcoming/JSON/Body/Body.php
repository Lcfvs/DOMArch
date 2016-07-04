<?php
namespace DOMArch\Request\Outcoming\JSON;

use DOMArch\Set;

class Body
{
    use Set;

    public function bind(array $fields)
    {
        foreach ($fields as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function __toString()
    {
        return $this->toObjectJSON();
    }
}