<?php
namespace Lib\Request\Incoming;

use DOMArch\Request;
use DOMArch\Set;
use Lib\Config;

class Body
{
    use Set;

    public static function fromRequest(Request\Incoming $request) : self
    {
        if (!in_array($request->getMethod(), ['patch', 'post', 'put'])) {
            return null;
        }

        if ($request !== Request\Incoming::requested()) {
            return Request\Incoming::requested()->getBody();
        }

        $content_type = $request->getHeaders()->get('Content-Type');

        if ($content_type !== 'application/json') {
            $request->badRequest();

            return null;
        }

        $key = Config::global()->get('clientKey');
        $body = file_get_contents('php://input');

        if ($key) {
            $body = Crypto::decrypt($body, $key);
        }

        return static::fromJSON($body);
    }
}