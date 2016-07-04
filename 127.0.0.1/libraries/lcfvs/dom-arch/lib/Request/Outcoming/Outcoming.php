<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Request;

use DOMArch\Crypto;
use DOMArch\Request;
use DOMArch\Request\Outcoming\JSON\Body as RequestBody;
use DOMArch\Request\Outcoming\JSON\HeaderList;

abstract class Outcoming extends Request
{
    abstract protected function _buildResponse(
        array $headers,
        string $body_string,
        string $status_code
    );

    public function setMethod(string $method)
    {
        $this->_method = strtolower($method);

        return $this;
    }

    public function setBody(RequestBody $body)
    {
        $this->_body = $body;

        return $this;
    }

    public function fetch(
        string $key = null
    )
    {
        $method = $this->getMethod();
        $url = $this->getUrl();

        if ($key) {
            $url = $url->encrypt($key);
        }

        $headers = $this->getHeaderArray();

        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_HEADER, 1);
        curl_setopt($resource, CURLOPT_CUSTOMREQUEST, strtoupper($method));

        if (in_array($method, ['patch', 'post', 'put'])) {
            $body = (string)$this->getBody();

            if ($key) {
                $body_string = Crypto::encrypt($body_string, $key);
            }

            $headers[] = 'Content-Length: ' . strlen($body);

            curl_setopt($resource, CURLOPT_POSTFIELDS, $body);
            curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        }

        curl_setopt($resource, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($resource);
        $header_size = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        $status_code = (int)curl_getinfo($resource, CURLINFO_HTTP_CODE);
        curl_close($resource);

        $headers = static::parseHeaderString(substr($result, 0, $header_size));
        $body_string = substr($result, $header_size);

        if ($key) {
            $body_string = Crypto::decrypt($body_string, $key);
        }

        $this->_buildResponse($headers, $body_string, $status_code);
        
        return $this->_response->getBody();
    }

    public static function parseHeaderString(string $headers_string)
    {
        $headers = [];
        $header_strings = explode("\n", trim($headers_string));

        foreach ($header_strings as $header_string) {
            if (strpos($header_string, ': ') === false) {
                continue;
            }

            list($name, $value) = explode(': ', $header_string);

            $headers[$name] = $value;
        }

        return $headers;
    }

    public function getHeaderArray()
    {
        $headers = [];

        foreach ($this->getHeaders()->toArray() as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }

        return $headers;
    }
}