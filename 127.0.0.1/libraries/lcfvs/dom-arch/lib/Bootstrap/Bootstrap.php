<?php
namespace DOMArch;

use Exception;

abstract class Bootstrap
{
    protected static $_bootstrap;

    protected function __construct()
    {
        $config = Config::global();
        $config->set('context', $config->get(static::getName()));

        self::$_bootstrap = $this;
    }

    abstract protected function getName();

    public static function bootstrap()
    {
        if (self::$_bootstrap) {
            $message = 'Illegal ' . __METHOD__ . ' call';

            throw new Exception($message);
        }

        new static();
    }
}