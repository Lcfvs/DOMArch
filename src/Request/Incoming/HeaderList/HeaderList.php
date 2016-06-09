<?php
namespace DOMArch\Request\Incoming;

use DOMArch\Request;
use DOMArch\Storable\Fromifiable;

class HeaderList
{
    use Fromifiable;

    public static function fromRequest(Request $request) : self
    {
        if ($request !== Request\Incoming::getRequested()) {
            return static::empty();
        }

        return static::fromArray(getallheaders());
    }
}