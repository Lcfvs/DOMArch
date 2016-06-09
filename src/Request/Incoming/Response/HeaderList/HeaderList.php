<?php
namespace DOMArch\Request\Incoming\Response;

use DOMArch\Storable\Fromifiable;

class HeaderList
{
    use Fromifiable;

    public function send() : self
    {
        $headers = $this->toArray();

        foreach ($headers as $name => $value) {
            header($name . ': ' . $value);
        }

        return $this;
    }
}