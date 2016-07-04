<?php
namespace DOMArch\Resource\File;

use DOMArch\Resource\File\Validator\Error;

trait Validator
{
    private $_errors = [];
    private $_file;

    public function getFile()
    {
        return $this->_file;
    }
    
    public function setFile($file)
    {
        $this->_file = $file;
        
        return $this;
    }

    public function error($code, ...$params)
    {
        $this->_errors[] = new Error($code, $params);

        return $this;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function validate()
    {
        return empty($this->_errors);
    }
}