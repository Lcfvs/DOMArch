<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Resource;

use DOMArch\Resource\File\MimeCache;

class File extends \SplFileObject
{
    public function getMimeType()
    {
        return MimeCache::get($this->getExtension());
    }
    
    public function isChildOf($directory)
    {
        return strpos($this->getPathname(), $directory) === 0;
    }
    
    public function isBinary()
    {
        $finfo = new \finfo(FILEINFO_MIME);
        
        $mime = $finfo->file($this->getPathname());
        
        return strpos($mime, 'charset=binary') !== false;
    }
    
    public function load()
    {
        require_once $this->getPathname();
    }
    
    public function getContents()
    {
        $arguments = func_get_args();
        array_unshift($arguments, $this->getPathname());
        
        return call_user_func_array('file_get_contents', $arguments);
    }
    
    public function putContents()
    {
        $arguments = func_get_args();
        array_unshift($arguments, $this->getPathname());
        
        return call_user_func_array('file_put_contents', $arguments);
    }
    
    public function download($filename = null)
    {
        return self::_download('inline', $filename);
    }
    
    public function forceDownload($filename = null)
    {
        return $this->_download('attachment', $filename);
    }
    
    private function _download($disposition, $filename = null)
    {
        return new File\Download($this, $disposition, $filename);
    }

    public static function upload($field, File\Validator $validator)
    {
        $upload = new File\Upload($field, $validator);

        if ($upload->validate()) {
            $file = new self($_FILES[$field]['tmp_name']);
            $upload->setFile($file);
        }

        return $upload;
    }
}