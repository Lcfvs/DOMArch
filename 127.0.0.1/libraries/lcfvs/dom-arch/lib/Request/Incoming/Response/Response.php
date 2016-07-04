<?php
namespace DOMArch\Request\Incoming;

use DOMArch\Request\Incoming\Response\HeaderList as ResponseHeaderList;

class Response
{
    protected $_body;
    protected $_statusCode;
    protected $_headers;

    public function getBody()
    {
        return $this->_body;
    }

    public function setBody($body)
    {
        $this->_body = $body;
        
        return $this;
    }

    public function getHeaders()
    {
        if ($this->_headers) {
            return $this->_headers;
        }

        $this->_headers = ResponseHeaderList::empty();

        return $this->_headers;
    }

    public function getStatusCode()
    {
        return $this->_statusCode ?? 200;
    }

    public function setStatusCode(int $code)
    {
        $this->_statusCode = $code;

        return $this;
    }
}