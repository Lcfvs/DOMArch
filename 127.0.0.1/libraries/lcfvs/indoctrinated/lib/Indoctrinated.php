<?php
/**
 * @author : Lcf.vs
 * @link: https://github.com/Lcfvs
 */
namespace Indoctrinated;

use DateTime;

use Indoctrinated\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Console\Helper\HelperSet;

class Db
{
    private static $_entityManager;
    private static $_helperSet;
    private static $_orm;
    private static $_time;

    final private function __construct(
        string $entities_dir,
        bool $is_dev_mode,
        array $db_config,
        DateTime $time = null
    )
    {
        self::$_orm = $this;
        self::$_time = $time ?? new DateTime();

        $meta_config = Setup::createAnnotationMetadataConfiguration(
            [$entities_dir], $is_dev_mode, null, null, false
        );

        self::$_entityManager = EntityManager::create(
            $db_config,
            $meta_config
        );
    }

    public static function bootstrap(
        string $entities_dir,
        bool $is_dev_mode,
        array $db_config,
        DateTime $time = null
    ) : self
    {
        if (self::$_orm) {
            throw new Exception('Illegal call of ' . __METHOD__);
        }

        return new static($entities_dir, $is_dev_mode, $db_config);
    }

    public static function getEntityManager() : EntityManager
    {
        return self::$_entityManager;
    }

    public static function getHelperSet() : HelperSet
    {
        if (self::$_helperSet) {
            return self::$_helperSet;
        }

        self::$_helperSet = ConsoleRunner::createHelperSet(
            self::$_entityManager
        );

        return self::$_helperSet;
    }

    public static function getRepository(string $name)
    {
        return self::getEntityManager()
            ->getRepository($name);
    }

    public static function run(
        string $command
    )
    {
        $_SERVER['argv'] = explode(' ', $_SERVER['argv'][0] . ' ' . $command);

        ConsoleRunner::run(self::getHelperSet());
    }

    /**
     * @return DateTime
     */
    public static function getTime()
    {
        return self::$_time;
    }
}