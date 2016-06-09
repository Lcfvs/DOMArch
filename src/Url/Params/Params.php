<?php
namespace DOMArch\Url;

class Params
{
    use \DOMArch\Storable;

    public static function fromArray(array $values)
    {
        $storable = new static();

        foreach ($values as $name => $value) {
            $storable->set($name, $value);
        }

        return $storable;
    }
}