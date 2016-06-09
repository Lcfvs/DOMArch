<?php
namespace DOMArch;

class Util
{
    public static function isInstanciable($class_name)
    {
        if (!class_exists($class_name)) {
            return false;
        }

        try {
            $reflection = new \ReflectionClass($class_name);

            return $reflection->isInstantiable();
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function toClassName(...$names)
    {
        return implode('\\', $names);
    }
}