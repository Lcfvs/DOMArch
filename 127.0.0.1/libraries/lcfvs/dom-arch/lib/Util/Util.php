<?php
namespace DOMArch;

use Exception;
use ReflectionClass;
use ReflectionMethod;

class Util
{
    protected static $_reflections = [];

    public static function isInstanciable(
        $class_name
    )
    {
        if (!class_exists($class_name)) {
            return false;
        }

        try {
            self::$_reflections[$class_name] = self::$_reflections[$class_name]
                ?? new ReflectionClass($class_name);

            return self::$_reflections[$class_name]->isInstantiable();
        } catch (Exception $exception) {
            return false;
        }
    }

    public static function isCallableMethod(
        $instance,
        $method_name
    )
    {
        return method_exists($instance, $method_name)
        && (new ReflectionMethod($instance, $method_name))
            ->isPublic();
    }

    public static function toClassName(...$names)
    {
        return implode('\\', $names);
    }
}