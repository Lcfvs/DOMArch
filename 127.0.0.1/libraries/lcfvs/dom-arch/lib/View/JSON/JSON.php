<?php
namespace DOMArch\View;

use DOMArch\Crypto;

class JSON
{
    use \DOMArch\Set;

    public function error($field, $message)
    {
        $errors = $this->get('errors', []);

        if (empty($errors[$field])) {
            $errors[$field] = [];
        }

        $errors[$field][] = $message;

        $this->set('errors', $errors);
    }

    public function print($key = null)
    {
        $json = json_encode((object) $this->toArray());

        if ($key) {
           $json = Crypto::encrypt($json, $key);
        }

        header('Content-Type: application/json;charset=utf-8');
        header('Content-Length: ' . strlen($json));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Thu, 01 Jan 1970 00:00:00');

        echo $json;
        exit();
    }

    public function __toString()
    {
        return json_encode((object) $this->toArray());
    }
}