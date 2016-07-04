<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch\Resource\File;

use DOMArch\Config;
use DOMArch\Constants;

class Download
{
    private $_file;
    private $_filename;
    private $_length;
    private $_disposition;
    private $_resumable;
    private $_offset;
    
    public function __construct($file, $disposition = 'inline', $filename = null)
    {
        session_write_close();
        set_time_limit(0);
        
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }
        
        $filename = trim(basename($filename));
        
        if (empty($filename)) {
            $filename = $file->getBasename();
        }
        
        $this->_resumable = $disposition === 'attachment'
        && isset($_SERVER['HTTP_RANGE']);
        
        $this->_filename = $filename;
        $this->_file = $file;
        $this->_disposition = $disposition;
        $this->_start();
    }

    private function _start()
    {
        $this->_sendHeaders();
        
        $file = $this->_file;
        $offset = $this->_offset;
        $size = $this->_length;
        $length = $size - $offset;
        $speed = $length;

        if ($file->isChildOf(Config::global()->get(Constants::DOWNLOAD_DIR))) {
            $speed = Config::global()->get(Constants::DOWNLOAD_SPEED);
        }
        
        while ($length) {
            if ($length > $speed) {
                $length = $speed;
            }
            
            $file->fseek($offset);
            $data = $file->fread($length);
            
            echo $data;
            
            flush();
            
            $offset += $length;
            $length = $size - $offset;
            
            if ($length) {
                sleep(1);
            }
        }
        
        exit;
    }
    
    private function _sendHeaders()
    {
        $file = $this->_file;
        $mime_type = $file->getMimeType();
        $size = $file->getSize();
        $disposition = $this->_disposition;
        
        header('Accept-Ranges: bytes', true);
        header('Content-Disposition: ' . $disposition . '; filename="' . $this->_filename . '"', true);
        header('Content-Length: ' . $size, true);
        header('Content-Type: ' . $mime_type, true);
        header('Content-Description: File Transfer', true);
        
        if ($disposition === 'inline') {
            $this->_length = $size;
            $this->_offset = 0;
            
            return;
        }
        
        header('Cache-Control: max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0', true);
        header('Content-Transfer-Encoding: binary', true);
        header('Expires: 0', true);
        header('Pragma: no-cache', true);
        
        if (!$this->_resumable) {
            $this->_length = $size;
            $this->_offset = 0;
            
            return;
        }
        
        $range = $_SERVER['HTTP_RANGE'];
        
        if (!preg_match('/bytes=([0-9]+)?-([0-9]+)?(\/[0-9]+)?/i', $range, $results)) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable', true);
            
            exit;
        }
        
        $end = !empty($results[2]) ? (int) $results[2] : $size - 1;
        $offset = !empty($results[1]) ? (int) $results[1] : 0;
        
        $this->_length = $end + 1 - $offset;
        $this->_offset = $offset;
        
        header('HTTP/1.1 206 Partial Content', true);
        header("Content-Range: bytes $offset-$end/$size", true);
    }
}