<?php

namespace DOMArch\Resource\Db;

use stdClass;

use DOMArch\Config;
use DOMArch\Constants;
use DOMArch\Resource\Db;
use DOMArch\Resource\Db\Model\Util;
use RedBeanPHP\SimpleModel;

abstract class Model extends SimpleModel
{
    protected static $_columns = [
        'id' => null,
        'createdAt' => null,
        'updatedAt' => null,
        'archivedAt' => null
    ];

    private $_errors = [];
  
    public function dispense() {
        $bean = $this->bean;
        $columns = $bean->export();

        if ($bean->getId()) {
            return;
        }

        foreach(static::$_columns as $column => $value) {
            if (!array_key_exists($column, $columns)) {
                $bean->{$column} = $value;
            }
        }
    }

    public static function findOne(string $query = null, array $values = []) {
        $instance = Db::findOne(get_called_class(), $query, $values);

        if ($instance) {
            return $instance->box();
        }
    }

    public static function findAll(string $query = null, array $values = []) {
        return Util::map(Db::findAll(get_called_class(), $query, $values));
    }
    
    public static function one($params = null) {
        if (!func_num_args()) {
            return Db::dispense(get_called_class())->box();
        }
        
        if (is_numeric($params)) {
            return static::one([
                'id' => $params
            ]);
        }

        $instance = Db::findOne(get_called_class(), Util::buildQuery($params), $params);

        if ($instance) {
            return $instance->box();
        }
    }

    public static function all(array $params = []) {
        return Util::map(Db::findAll(get_called_class(), Util::buildQuery($params), $params));
    }

    public static function count(array $params = []) {
        return Db::count(get_called_class(), Util::buildQuery($params), $params);
    }
    
    public function save() {
        Db::store($this->bean);
        
        return $this;
    }

    public function archive() {
        return $this
            ->setArchivedAt(Config::global()->get(Constants::REQUEST_TIME))
            ->save();
    }

    public function getId() {
        return (int) $this->bean->getId();
    }

    public function clone() {
        return static::fromArray($this->toArray())
            ->setId(null)
            ->setCreatedAt(null)
            ->setUpdatedAt(null)
            ->setArchivedAt(null);
    }

    public static function fromArray(array $array) {
        $instance = static::one();

        foreach(static::$_columns as $column => $value) {
            $bean->{$column} = $array[$column];
        }

        return $instance;
    }

    public function toArray() {
        $result = [];

        foreach(static::$_columns as $column => $value) {
            $result[$column] = $this->{'get' . ucfirst($column)}();
        }

        return $result;
    }

    public static function fromStd(stdClass $object) {
        return static::fromArray($object);
    }

    public function toStd() {
        return (object) $this->toArray();
    }

    public static function fromJSON(string $json) {
        return static::fromStd(json_decode($json));
    }

    public function toJSON() {
        return json_encode($this->toStd());
    }

    public function dump() {
        dump($this);
    }

    protected function _error(string $field, string $message) {
        $errors = $this->_errors[$field];

        if (!$errors) {
            $errors = $this->_errors[$field] = [];
        }

        $errors[] = $message;

        return $this;
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function __call(string $method, array $args) {
        $bean = $this->bean;

        if (!preg_match('/^(init|get|set)([A-Z][a-zA-Z\d]+)/', $method, $matches)) {
            throw new \Exception('Method does not exist in ' . get_called_class() . ' : ' . $method . '()');
        }

        $property = lcfirst($matches[2]);

        switch ($matches[1]) {
            case 'init': {
                if (is_null($bean->{$property})) {
                    $bean->{$property} = $args[0];
                }

                return $this;
            }

            case 'set': {
                $bean->{$property} = $args[0];

                return $this;
            }

            case 'get': {
                return $bean->{$property};
            }
        }
    }

    public function update() {
        $this->_errors = [];
        $request_time = Config::global()->get(Constants::REQUEST_TIME);

        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt($request_time);
        } else if (is_null($this->getArchivedAt())) {
            $this->setUpdatedAt($request_time);
        }
    }

    public function after_update() {
        if (count($this->_errors)) {
            Db::rollback();

            throw new \Exception('Transaction canceled');
        }
    }
}