<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

use DOMArch\Util\DateTime;
use Exception;

class Config
{
    use Set;

    private static $_global;

    public static function global()
    {
        return self::$_global;
    }

    public function set(
        string $name,
        $value
    )
    {
        if ($this->has($name) && is_object($value) && $value instanceof self) {
            $message = 'Duplicate config name : ' . $name;

            throw new Exception($message);
        }

        $this->_store->{$name} = $value;

        return $this;
    }

    public static function parse(
        string $config_file,
        bool $is_global
    ) : self
    {
        if (self::$_global && $is_global) {
            $message = 'Illegal ' . __METHOD__ . ' call as global';

            throw new Exception($message);
        }

        $json = file_get_contents($config_file);
        $fields = json_decode($json, true);
        $config = new static();
        $config->fill($fields, true);

        if ($is_global) {
            $config->set('createdAt', DateTime::create());

            self::$_global = $config;
        }

        return $config;
    }
}