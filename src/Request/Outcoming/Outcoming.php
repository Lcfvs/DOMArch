<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Request;

use DOMArch\Request;
use DOMArch\Request\Outcoming\JSON\Body;
use DOMArch\Request\Outcoming\JSON\HeaderList;
use DOMArch\Request\Outcoming\JSON\Response;

class Outcoming extends Request
{
    public function getBody()
    {
        if ($this->_body) {
            return $this->_body;
        }

        $this->_body = Body::empty();

        return $this->_body;
    }

    public function getHeaders()
    {
        if ($this->_headers) {
            return $this->_headers;
        }

        $this->_headers = HeaderList::empty()
            ->set('Content-Type', 'application/json');

        return $this->_headers;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function fetch()
    {
        $method = $this->getMethod();
        $url = $this->getUrl();

        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_HEADER, 1);
        curl_setopt($resource, CURLOPT_CUSTOMREQUEST, strtoupper($method));

        if (in_array($method, ['patch', 'post', 'put'])) {
            $body = $this->getBody()->toObjectJSON();
            $headers = $this->getHeaders()->toArray();
            $headers[] = 'Content-Length: ' . strlen($body);

            curl_setopt($resource, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($resource, CURLOPT_POSTFIELDS, $body);
            curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        }

        $result = curl_exec($resource);
        $header_size = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        $status_code = (int) curl_getinfo(CURLINFO_HTTP_CODE);
        curl_close($resource);

        $header_string = substr($result, $header_size);
        $body_string = substr($result, 0, $header_size);
        $this->_response = Response::parse($header_string, $body_string, $status_code);

        return $this;
    }
}