<?php
namespace DOMArch\Resource\File\Validator;

class Error
{
    private $_code;
    private $_message;

    public function __construct($code, array $params)
    {
        $this->_code = $code;
        $this->_message = sprintf($code, ...$params);
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function getMessage()
    {
        return $this->_message;
    }
}