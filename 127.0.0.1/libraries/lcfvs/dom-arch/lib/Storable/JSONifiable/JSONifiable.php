<?php
namespace DOMArch\Storable;

trait JSONifiable
{
    public function toArrayJSON()
    {
        return json_encode($this->toArray());
    }

    public function toObjectJSON()
    {
        return json_encode((object) $this->_store);
    }
}