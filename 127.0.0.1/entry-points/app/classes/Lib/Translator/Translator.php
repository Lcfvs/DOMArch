<?php
namespace Lib;

use DOMArch\Evented;
use Indoctrinated;

abstract class Translator
{
    use Evented;

    protected $_builder;
    protected $_entityClass;
    protected $_locales;
    protected $_formats = [];
    protected $_results = [];

    public function __construct(
        string $entity_class
    )
    {
        $this->_locales = Config::global()
            ->get('common')
            ->get('locales')
            ->toArray();

        $this->_entityClass = $entity_class;

        $this->_builder = $entity_class::getEntityRepository()
            ->createQueryBuilder('record', 'record.format');
    }

    protected function _search(
        string $format
    )
    {
        if (in_array($format, $this->_formats)) {
            return $this;
        }

        $key = array_push($this->_formats, $format);
        $flag = 'format_' . $key;

        $this->_builder
            ->setParameter($flag, $format)
            ->orWhere('
                record.format = :' . $flag
                . ' AND
                record.archivedAt IS NULL
            ');

        return $this;
    }

    public function fetch()
    {
        $this->emit('fetch');

        $this->_results = $this->_builder
            ->getQuery()
            ->getResult();

        return $this->emit('fetched');
    }

    protected function _onDefault(
        string $format
    )
    {
        $fields = [
            'format' => $format
        ];

        foreach ($this->_locales as $locale) {
            $fields[$locale] = $format;
        }

        $entity_class = $this->_entityClass;

        return $entity_class::fromArray($fields)
            ->save();
    }
}