<?php

namespace Repositories;

use Indoctrinated\Repository;
use Repositories\Translations\Bundle;
/**
 * Translations
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Translations extends Repository
{
    protected static $_bundle;

    public static function bundle()
    {
        if (static::$_bundle) {
            return static::$_bundle;
        }

        static::$_bundle = new Bundle();

        return static::$_bundle;
    }
}
