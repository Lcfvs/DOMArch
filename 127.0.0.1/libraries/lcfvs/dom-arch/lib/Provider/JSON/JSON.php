<?php
namespace DOMArch\Provider;

use DOMArch\Provider;
use DOMArch\Request\Outcoming;
use DOMArch\Request\Outcoming\JSON\Body;

abstract class JSON extends Provider
{
    public function post(array $fields = [])
    {
        $this->getRequest()
            ->setMethod('post')
            ->setBody(Body::fromArray($fields));

        return $this;
    }

    public function put(array $fields = [])
    {
        $this->getRequest()
            ->setMethod('put')
            ->setBody(Body::fromArray($fields));

        return $this;
    }

    public function patch(array $fields = [])
    {
        $this->getRequest()
            ->setMethod('patch')
            ->setBody(Body::fromArray($fields));

        return $this;
    }
}