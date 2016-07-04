<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\Common;

class Utils
{
    const CAMEL_CASE_PATTERN = '/^([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)$/';

    public static function parseStringArguments(array $arguments)
    {
        $results = [];
        
        foreach ($arguments as $argument)  {
            $results = $results + (array) $argument;
        }
        
        return $results;
    }
    
    public static function parseArrayArguments(array $arguments)
    {
        $results = [];
        
        foreach ($arguments as $key => $argument)  {
            if (!is_array($argument)) {
                $results[$key] = $argument;
                
                continue;
            }
            
            foreach ($argument as $name => $value) {
                $results[$name] = $value;
            }
        }
        
        return $results;
    }

    public static function fromCamelCase($name)
    {
        return strtolower(preg_replace('/[A-Z]/', '-$0', $name));
    }

    public static function toCamelCase($name)
    {
        $names = explode('-', $name);
        array_shift($names);

        foreach ($names as $key => $part) {
            if ($key) {
                $names[$key] = ucfirst($part);
            }
        }

        return implode('', $names);
    }
}