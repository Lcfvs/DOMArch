<?php
namespace DOMArch\Storable;

use Exception;
use stdClass;

trait Fromifiable
{
    public static function empty()
    {
        return static::fromArray([]);
    }

    public static function fromArray(array $fields)
    {
        return new static($fields);
    }

    public static function fromObject(stdClass $fields)
    {
        return new static((array) $fields);
    }

    public static function fromJSON(string $json, bool $verbose = false, ...$json_args)
    {
        $fields = json_decode($json, ...$json_args);

        if (is_null($fields) && $verbose) {
            throw new Exception('Invalid JSON');
        }

        return new static((array) $fields);
    }

    public static function fromJSONFile(string $file, bool $verbose = false, ...$json_args)
    {
        $json = file_get_contents($file);

        return static::fromJSON($json, $verbose, ...$json_args);
    }
}