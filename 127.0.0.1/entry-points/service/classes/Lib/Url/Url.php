<?php
namespace Lib;

class Url extends \DOMArch\Url
{
    public function setModuleName(
        string $name
    )
    {
        $this->getParams()
            ->set('moduleName', $name);

        return $this;
    }

    public function getModuleName()
    {
        return $this->getParams()
            ->get('moduleName');
    }

    public function setClassName(
        string $name
    )
    {
        $this->getParams()
            ->set('className', $name);

        return $this;
    }

    public function getClassName()
    {
        return $this->getParams()
            ->get('className');
    }
    
    public function setEntityId(
        int $id
    )
    {
        $this->getParams()
            ->set('entityId', $id);

        return $this;
    }

    public function getEntityId()
    {
        return $this->getParams()
            ->get('entityId');
    }

    public function setSubEntityId(
        int $id
    )
    {
        $this->getParams()
            ->set('subEntityId', $id);

        return $this;
    }

    public function getSubEntityId()
    {
        return $this->getParams()
            ->get('subEntityId');
    }
}