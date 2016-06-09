<?php
namespace DOMArch\Resource\File;

use DOMArch\Resource\File;

class Upload
{
    const
        ERROR_MISSING_FILE = 'Missing file field : %s',
        ERROR_INVALID_FIELD = 'Invalid field : %s',
        ERROR_INI_SIZE = 'Invalid file size : %s',
        ERROR_FORM_SIZE = 'Invalid form file size : %s',
        ERROR_PARTIAL = 'Incomplete file : %s',
        ERROR_NO_FILE = 'Missing file : %s',
        ERROR_NO_TMP_DIR = 'Missing temp dir to save file : %s',
        ERROR_CANT_WRITE = 'Unable to write file : %s',
        ERROR_EXTENSION = 'An extension has blocked file upload : %s';
    
    protected $_field;
    protected $_validator;
    protected $_name;
    protected $_type;
    protected $_size;
    protected $_tmpName;

    public function __construct($field, Validator $validator)
    {
        $this->_field = $field;
        $this->_validator = $validator;
    }
    
    public function validate()
    {
        $field = $this->_field;
        $validator = $this->_validator;

        if (empty($_FILES[$field])) {
            $validator->error(self::ERROR_MISSING_FILE, $field);
        } else if (!is_array($_FILES[$field])) {
            $validator->error(self::ERROR_INVALID_FIELD, $field);
        } else {
            switch ($_FILES[$field]['error']) {
                case 1: {
                    $validator->error(self::ERROR_INI_SIZE, $field);

                    break;
                }

                case 2: {
                    $validator->error(self::ERROR_FORM_SIZE, $field);

                    break;
                }

                case 3: {
                    $validator->error(self::ERROR_FORM_SIZE, $field);

                    break;
                }

                case 4: {
                    $validator->error(self::ERROR_PARTIAL, $field);

                    break;
                }

                case 5: {
                    $validator->error(self::ERROR_NO_FILE, $field);

                    break;
                }

                case 6: {
                    $validator->error(self::ERROR_NO_TMP_DIR, $field);

                    break;
                }

                case 7: {
                    $validator->error(self::ERROR_CANT_WRITE, $field);

                    break;
                }

                case 8: {
                    $validator->error(self::ERROR_EXTENSION, $field);

                    break;
                }

                default: {
                    $this->_name = $_FILES[$field]['name'];
                    $this->_size = $_FILES[$field]['size'];
                    $this->_type = $_FILES[$field]['type'];
                    $this->_tmpName = $_FILES[$field]['tmp_name'];
                }
            }
        }

        return $validator->validate();
    }

    public function setFile(File $file)
    {
        $this->_validator->setFile($file);

        return $this;
    }

    public function getFile()
    {
       return $this->_validator->getFile();
    }

    public function getName()
    {
       return $this->_name;
    }

    public function getType()
    {
       return $this->_type;
    }

    public function getSize()
    {
       return $this->_size;
    }

    public function getTmpName()
    {
       return $this->_tmpName;
    }

    public function move($destination)
    {
        return @move_uploaded_file($this->_tmpName, $destination);
    }
}