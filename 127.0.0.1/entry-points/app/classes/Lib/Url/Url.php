<?php
namespace Lib;

use DOMArch;

class Url
    extends DOMArch\Url
{
    protected $_locale;
    protected $_format;
    protected $_canonical;
    protected $_alternates = [];

    public function setModuleName(
        string $name
    )
    {
        $this->getParams()
            ->set('moduleName', $name);

        return $this;
    }

    public function getModuleName(
        string $default = 'Welcome'
    )
    {
        return $this->getParams()
            ->get('moduleName', $default);
    }

    public function setClassName(
        string $name
    )
    {
        $this->getParams()
            ->set('className', $name);

        return $this;
    }

    public function getClassName(
        string $default = 'Index'
    )
    {
        return $this->getParams()
            ->get('className', $default);
    }

    public function setMethod(
        string $name
    )
    {
        $this->getParams()
            ->set('method', $name);

        return $this;
    }

    public function getMethod(
        string $default = 'get'
    )
    {
        return $this->getParams()
            ->get('method', $default);
    }

    public function setLocale(
        string $locale
    )
    {
        $this->getParams()
            ->set('locale', $locale);

        return $this;
    }

    public function getLocale()
    {
        $locale = $this->getParams()->get('locale');

        if ($locale) {
            return $locale;
        }

        $locales = Config::global()
            ->get('common')
            ->get('locales')
            ->toArray();

        return reset($locales);
    }

    public function setCanonical(
        string $translation
    )
    {
        $this->_canonical = $translation;

        return $this;
    }

    public function getCanonical()
    {
        return $this->_canonical;
    }

    public function addAlternate(
        string $locale,
        string $translation
    )
    {
        $this->_alternates[$locale] = $translation;

        return $this;
    }

    /**
     * @return array
     */
    public function getAlternates()
    {
        return $this->_alternates;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->_format;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setFormat(
        string $format
    )
    {
        $this->_format = $format;

        return $this;
    }
}