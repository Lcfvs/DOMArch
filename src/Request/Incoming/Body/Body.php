<?php
namespace DOMArch\Request\Incoming;

use DOMArch\Request;
use DOMArch\Storable\Fromifiable;

class Body
{
    use Fromifiable;

    public static function fromRequest(Request $request) : self
    {
        if (!in_array($request->getMethod(), ['patch', 'post', 'put'])) {
            return null;
        }

        if ($request !== Request\Incoming::getRequested()) {
            return static::empty();
        }

        $content_type = $request->getHeaders()->get('Content-Type');

        if ($content_type === 'application/json') {
            return static::fromJSON(file_get_contents('php://input'));
        }

        return static::fromArray($_POST);
    }
}