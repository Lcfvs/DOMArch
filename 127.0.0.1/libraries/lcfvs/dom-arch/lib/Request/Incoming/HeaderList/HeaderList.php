<?php
namespace DOMArch\Request\Incoming;

use DOMArch\Request;
use DOMArch\Set;

class HeaderList
{
    use Set;

    public static function fromRequest(Request $request) : self
    {
        $requested = Request\Incoming::requested();

        if ($request !== $requested) {
            return $requested->getHeaders();
        }

        return static::fromArray(getallheaders());
    }
}