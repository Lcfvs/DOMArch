<?php
namespace DOMArch\Storable;

use DOMArch\Storable;

trait JSONifiable
{
    use Storable;

    public function toArrayJSON()
    {
        return json_encode($this->toArray());
    }

    public function toObjectJSON()
    {
        return json_encode((object) $this->_store);
    }
}