<?php
namespace DOMArch;

use DOMArch\Request\Body;
use PHPDOM\HTML\Document;

abstract class Provider
{
    const
        HEADER_QUERY_LIMIT = 'X-Query-Limit',
        HEADER_QUERY_OFFSET = 'X-Query-Offset',
        HEADER_QUERY_ORDER = 'X-Query-Order';

    const
        ORDER_ASC = 'ASC',
        ORDER_DESC = 'DESC';

    private $_request;
    private $_id;
    private $_parent;
    private $_parentId;

    protected function __construct(Request $request)
    {
        $this->_request = $request
            ->set('headers', [
                'Content-Type: application/json'
            ]);
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setParent($parent)
    {
        $this->_parent = $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->_parent;
    }

    public function setParentId($parentId)
    {
        $this->_parentId = $parentId;

        return $this;
    }

    public function getParentId()
    {
        return $this->_parentId;
    }

    public function addConstraint($name, $value)
    {
        $this->getRequest()
            ->get('params')
                ->set($name, $value);

        return $this;
    }

    public function query(array $params)
    {
        foreach ($params as $name => $value) {
            $this->addConstraint($name, $value);
        }

        return $this;
    }

    public function addHeader($name, $value)
    {
        $request = $this->getRequest();
        $headers = $request->get('headers');
        $headers[] = $name . ': ' . $value;

        $request->set('headers', $headers);

        return $this;
    }

    public function addHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->addHeader($name, $value);
        }

        return $this;
    }

    public function get(array $query = [])
    {
        $this
            ->query($query)
            ->getRequest()
            ->set('method', 'get');

        return $this;
    }

    public function post(array $fields = [])
    {
        $this->getRequest()
            ->set('method', 'post')
            ->set('body', Body::fromArray($fields));

        return $this;
    }

    public function put($id, array $fields = [], array $query = [])
    {
        $this
            ->setId($id)
            ->query($query)
            ->getRequest()
                ->set('method', 'put')
                ->set('body', Body::fromArray($fields));

        return $this;
    }

    public function patch($id, array $fields = [], array $query = [])
    {
        $this
            ->setId($id)
            ->query($query)
            ->getRequest()
                ->set('method', 'patch')
                ->set('body', Body::fromArray($fields));

        return $this;
    }

    public function delete($id, array $query = [])
    {
        $this
            ->setId($id)
            ->query($query)
            ->getRequest()
                ->set('method', 'delete');

        return $this;
    }

    public function fetch()
    {
        $this->_build();
        $request = $this->_request;
        $method = $request->get('method');
        $url = $request->get('url');

        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, (string) $url);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_HEADER, 1);

        if (in_array($method, ['patch', 'post', 'put'])) {
            $body = (string) $request->get('body');
            $headers = $request->get('headers', []);
            $headers[] = 'Content-Length: ' . strlen($body);

            curl_setopt($resource, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($resource, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($resource, CURLOPT_POSTFIELDS, $body);
            curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        }

        $response = curl_exec($resource);
        
        if ((int) curl_getinfo(CURLINFO_HTTP_CODE) !== 200) {
            curl_close($resource);
            Request::current()->serviceUnavailable();
        }

        $header_size = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        curl_close($resource);

        return $request
            ->set('responseHeaders', explode("\n", trim(substr($response, 0, $header_size))))
            ->set('responseBody', substr($response, $header_size))
            ->get('responseBody');
    }

    public function fetchJSON()
    {
        return json_decode($this->fetch());
    }

    public function fetchHTML()
    {
        return new Document($this->fetch());
    }

    public function limit($limit)
    {
        return $this->addHeader(self::HEADER_QUERY_LIMIT, $limit);
    }

    public function offset($offset)
    {
        return $this->addHeader(self::HEADER_QUERY_OFFSET, $offset);
    }

    public function asc($field)
    {
        return $this->addHeader(self::HEADER_QUERY_ORDER, $field . '=' . self::ORDER_ASC);
    }

    public function desc($field)
    {
        return $this->addHeader(self::HEADER_QUERY_ORDER, $field . '=' . self::ORDER_DESC);
    }

    protected function _build()
    {
        $values = [
            get_called_class(),
            $this->getId(),
            $this->getParent(),
            $this->getParentId()
        ];

        $path = '';

        foreach ($values as $value) {
            if (is_null($value)) {
                break;
            }

            $path .= '/' . $value;
        }

        $this->getRequest()
            ->set('path', $path);

        return $this;
    }
}