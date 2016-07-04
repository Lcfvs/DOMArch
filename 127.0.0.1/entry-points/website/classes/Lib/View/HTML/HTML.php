<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Lib\View;

use Lib\Request\Incoming;
use DOMArch\Assembler\TemplateFetcher;
use Lib\Url;
use PHPDOM\HTML\Document;

abstract class HTML
{
    private $_document;
    private $_fetcher;
    private $_url;

    public function __construct()
    {
        $request = Incoming::current();
        $document = $request->getResponse()->getBody();
        $this->_document = $document;
        $this->_fetcher = $document->getFetcher();
        $this->_url = $request->getUrl();
    }

    public function getDocument() : Document
    {
        return $this->_document;
    }

    public function getFetcher() : TemplateFetcher
    {
        return $this->_fetcher;
    }

    public function getUrl() : Url
    {
        return $this->_url;
    }
}