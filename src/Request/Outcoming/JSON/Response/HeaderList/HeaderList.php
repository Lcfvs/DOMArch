<?php
namespace DOMArch\Request\Outcoming\JSON\Response;

use DOMArch\Storable\Fromifiable;

class HeaderList
{
    use Fromifiable;

    public static function fromString(string $headers_string)
    {
        $headers = static::empty();
        $header_strings = explode("\n", trim($headers_string));

        foreach ($header_strings as $header_string) {
            list($name, $value) = explode(': ', $header_string);

            $headers->set(trim($name), $value);
        }

        return $headers;
    }
}