<?php
namespace DOMArch\Resource\Db\Model;

class Util
{
    public static function map(array $instances) {
        foreach ($instances as $key => $instance) {
            $instances[$key] = $instance->model();
        }

        return $instances;
    }

    public static function buildQuery(array &$params) {
        $query = [];

        if (!isset($params['archivedAt'])) {
            $params['archivedAt'] = null;
        }

        foreach($params as $property => $value) {
            if (is_null($value)) {
                $query[] = $property . ' IS :' . $property;
            } else {
                $query[] = $property . ' = :' . $property;
            }
        }

        return implode(' AND ', $query);
    }
}