<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

use Exception;
use stdClass;

trait Set
{
    protected $_store;

    public function __construct()
    {
        $this->_store = new stdClass();
    }

    public function fill(
        array $fields,
        bool $recursive = false
    )
    {
        foreach ($fields as $key => $value) {
            if (!$recursive || !is_array($value)) {
                $this->set($key, $value);

                continue;
            }

            $this->set($key, static::fromArray($value, $recursive));
        }

        return $this;
    }

    public function init(
        string $name,
        $default
    )
    {
        if ($this->has($name)) {
            return $this;
        }

        $store = $this->_store;

        if (is_callable($default)) {
            $store->{$name} = $default();

            return $this;
        }

        $store->{$name} = $default;

        return $this;
    }

    public function has(
        string $name
    )
    {
        return property_exists($this->_store, $name);
    }

    public function set(
        string $name,
        $value
    )
    {
        $store = $this->_store;

        $store->{$name} = $value;

        return $this;
    }

    public function get(
        string $name,
        $default = null
    )
    {
        if ($this->has($name)) {
            return $this->_store->{$name};
        }

        if (is_callable($default)) {
            return $default();
        }

        return $default;
    }

    public function clear(
        string $name = null
    )
    {
        if (is_null($name)) {
            $this->_store = new stdClass();
        } else {
            unset($this->_store->{$name});
        }

        return $this;
    }

    public function toArray(
        bool $recursive = false
    )
    {
        $fields = (array) $this->_store;

        if (!$recursive) {
            return $fields;
        }

        foreach ($fields as $key => $value) {
            if (is_object($value) && $value instanceof self) {
                $fields[$key] = $value->toArray($recursive);
            }
        }

        return $fields;
    }

    public function each(
        callable $callback
    )
    {
        foreach ($this->_store as $name => $value) {
            $callback($this->get($name), $name, $this);
        }
    }

    public static function empty()
    {
        return static::fromArray([]);
    }

    public static function fromArray(
        array $fields,
        bool $recursive = false
    )
    {
        return (new static())
            ->fill($fields, $recursive);
    }

    public static function fromObject(
        stdClass $fields,
        bool $recursive = false
    )
    {
        return static::fromArray((array) $fields, $recursive);
    }

    public static function fromJSON(
        string $json,
        bool $recursive = false
    )
    {
        $fields = json_decode($json);

        return static::fromArray((array) $fields, $recursive);
    }

    public static function fromJSONFile(
        string $file,
        bool $recursive = false
    )
    {
        $json = file_get_contents($file, $recursive);

        return static::fromJSON($json);
    }

    public function toArrayJSON(
        ...$json_args
    )
    {
        return json_encode($this->toArray(true), ...$json_args);
    }

    public function toObjectJSON(
        ...$json_args
    )
    {
        return json_encode((object) $this->_store, ...$json_args);
    }
}