<?php
namespace DOMArch\Storable;

use Exception;
use stdClass;

use DOMArch\Storable;

trait Fromifiable
{
    use Storable;

    protected function __construct(array $fields)
    {
        foreach ($fields as $key => $value) {
            $this->set($key, $value);
        }
    }

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
}