<?php
namespace DOMArch\View;

class JSON
{
    use \DOMArch\Storable;

    public function error($field, $message)
    {
        $errors = $this->get('errors', []);

        if (empty($errors[$field])) {
            $errors[$field] = [];
        }

        $errors[$field][] = $message;

        $this->set('errors', $errors);
    }

    public function print()
    {
        $json = json_encode((object) $this->toArray());

        header('Content-Type: application/json');
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