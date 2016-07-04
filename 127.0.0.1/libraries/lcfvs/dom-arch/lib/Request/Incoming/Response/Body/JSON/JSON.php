<?php
namespace DOMArch\Request\Incoming\Response\Body;

use DOMArch\Storable;
use DOMArch\Storable\Fromifiable;
use DOMArch\Storable\JSONifiable;

class JSON
{
    use Storable;
    use Fromifiable;
    use JSONifiable;
    
    public function __toString()
    {
        return self::toObjectJSON();
    }
}