<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Request\Outcoming;

use DOMArch\Url;
use DOMArch\Request\Outcoming;
use DOMArch\Request\Outcoming\JSON\Body;
use DOMArch\Request\Outcoming\JSON\HeaderList;
use DOMArch\Request\Outcoming\JSON\Response;

class JSON extends Outcoming
{
    public function __construct(Url $url, $method)
    {
        parent::__construct($url, $method);

        $this->_body = Body::empty();

        $this->_headers = HeaderList::empty()
            ->set('Content-Type', 'application/json');
    }

    protected function _buildResponse(
        array $headers,
        string $body,
        string $status_code
    )
    {
        $this->_response = Response::parse($headers, $body, $status_code);

        return $this;
    }
}