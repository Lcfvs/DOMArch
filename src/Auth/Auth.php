<?php
namespace DOMArch;

abstract class Auth
{
    private static $_current;
    protected $_user;

    protected function __construct()
    {
        self::$_current = $this;
    }

    public static function current()
    {
        if (self::$_current) {
            return self::$_current;
        }

        return new static();
    }

    public function getUser()
    {
        return $this->_user;
    }
}