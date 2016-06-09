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
    
    public static function validatePropertyName($name)
    {
        if (strpos($name, '_') === 0) {
            throw new \Exception('Illegal attribute name : ' . $name);
        }
        
        return true;
    }
}