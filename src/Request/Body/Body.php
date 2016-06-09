<?php
namespace DOMArch\Request;

use DOMArch\Request;
use DOMArch\Storable\Fromifiable;
use DOMArch\Storable\JSONifiable;

class Body
{
    use Fromifiable;
    use JSONifiable;

    public static function fromRequest(Request $request)
    {
        if (!in_array($request->getMethod(), ['patch', 'post', 'put'])) {
            return null;
        }

        $request = Request\Incoming::getRequested();

        $content_type = $request->getHeaders()->get('Content-Type');

        if ($content_type === 'application/json') {
            return static::fromJSON(file_get_contents('php://input'));
        }

        self::$_requested = static::fromArray($_POST);

        return self::$_requested;
    }

    public function toHTTPQuery()
    {
        return http_build_query($this->toArray());
    }
}