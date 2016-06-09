<?php
namespace DOMArch\Resource;

define('REDBEAN_MODEL_PREFIX', '');

class Db extends \RedBeanPHP\R
{
    private static $_dsn;
    private static $_engine;
    private static $_host;
    private static $_dbname;
    private static $_user;
    private static $_password;
    private static $_frozen = true;

    public static function setup($dsn = null, $user = null, $password = null, $frozen = null) {
        return parent::setup(...[
            $dsn ?? static::$_dsn ?? static::getDsn(),
            $user ?? static::$_user,
            $password ?? static::$_password,
            $frozen ?? static::$_frozen
        ]);
    }

    public static function getDsn()
    {
        return static::$_engine . ':host=' . static::$_host . ';dbname=' . static::$_dbname;
    }

    public static function setDsn($dsn)
    {
        static::$_dsn = $dsn;

        return get_called_class();
    }

    public static function setEngine($engine)
    {
        static::$_engine = $engine;

        return get_called_class();
    }

    public static function setHost($host)
    {
        static::$_host = $host;

        return get_called_class();
    }

    public static function setDbname($dbname)
    {
        static::$_dbname = $dbname;

        return get_called_class();
    }

    public static function setUser($user)
    {
        static::$_user = $user;

        return get_called_class();
    }

    public static function setPassword($password)
    {
        static::$_password = $password;

        return get_called_class();
    }

    public static function setFrozen($frozen)
    {
        static::$_frozen = $frozen;

        return get_called_class();
    }
}