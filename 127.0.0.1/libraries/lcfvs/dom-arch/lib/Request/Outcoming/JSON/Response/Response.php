<?php
namespace DOMArch\Request\Outcoming\JSON;

use DOMArch\Request\Outcoming\JSON\Response\Body as ResponseBody;
use DOMArch\Request\Outcoming\JSON\Response\HeaderList as ResponseHeaderList;

class Response
{
    protected $_body;
    protected $_statusCode;
    protected $_headers;
    
    protected function __construct(array $headers, string $body, int $status_code)
    {
        $this->_headers = ResponseHeaderList::fromArray($headers);
        $this->_body = ResponseBody::fromJSON($body);
        $this->_statusCode = $status_code;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public static function parse(array $headers, string $body, int $status_code)
    {
        return new static($headers, $body, $status_code);
    }

    public function getHeaders()
    {
        if ($this->_headers) {
            return $this->_headers;
        }

        $this->_headers = HeaderList::empty();

        return $this->_headers;
    }

    public function getStatusCode()
    {
        return $this->_statusCode ?? 200;
    }
}