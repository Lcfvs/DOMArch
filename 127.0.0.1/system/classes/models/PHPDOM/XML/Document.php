<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\XML;

class Document extends \DOMDocument
{
    const DEFAULT_TEMPLATE = '<root></root>';

    private $_xpath = null;

    public function __construct($load_default_template = false, $encoding = 'utf-8')
    {
        parent::__construct('1.0', $encoding);

        $this->encoding = $encoding;
        
        if ($load_default_template) {
            $this->loadSource(static::DEFAULT_TEMPLATE);
        }
    }
    
    public function loadSource($source, $options = null)
    {
        @$this->loadXML($source, $options);

        $encoding = $this->encoding;
        
        $this->_xpath = new \DOMXpath($this);
        $this->registerNodeClass('\\DOMNode', 'PHPDOM\\XML\\Node');
        $this->registerNodeClass('\\DOMElement', 'PHPDOM\\XML\\Element');
        $this->registerNodeClass('\\DOMText', 'PHPDOM\\XML\\Text');
        $this->registerNodeClass('\\DOMComment', 'PHPDOM\\XML\\Comment');
        $this->registerNodeClass('\\DOMDocumentFragment', 'PHPDOM\\XML\\DocumentFragment');
        
        $this->formatOutput = false;
        $this->preserveWhiteSpace = false;
        $this->standalone = true;
        
        return $this;
    }

    public function loadSourceFile(
        $filename,
        $options = null,
        $use_include_path = false,
        $context = null,
        $offset = -1,
        $maxlen = null
    )
    {
        if (is_null($maxlen)) {
            $maxlen = filesize($filename);
        }
        
        $source = file_get_contents(
            $filename,
            $use_include_path,
            $context,
            $offset,
            $maxlen
        );

        return $this->loadSource($source, $options);
    }

    public function create($definition = [], $namespace_URI = null)
    {
        $type = gettype($definition);
        
        if ($type !== 'array' && $type !== 'object') {
            $definition = strval($definition);
            $fragment = $this->createDocumentFragment();
            $fragment->append($definition);
            
            return $fragment;
        }
        
        if (empty($normalized->tag) {
            $node = $this->createDocumentFragment();
        } else {
            $normalized = $this->_normalize($definition);
            
            if (empty($namespace_URI)) {
                $node = $this->createElement($normalized->tag);
                $node->setAttr($normalized->attributes);
            } else {
                $node = $this->createElementNS($namespace_URI, $normalized->tag);
                $node->setAttr($namespace_URI);
            }
        }
        
        $data = $normalized->data;

        if (!empty($data)) {
            $node->append($data);
        }
        
        foreach ($normalized->children as $child) {
            $node->append($child);
        }

        return $node;
    }

    private function _normalize($definition)
    {
        $normalized = (object) $definition;

        $attributes = @$normalized->attributes;
        $before = @$normalized->before;
        $data = @$normalized->data;
        $ns = (string) @$normalized->ns;
        $tag = (string) @$normalized->tag;
        $children = @$normalized->children;
        @$normalized->value =
        $value = @$normalized->value;

        if (!is_array($children)) {
            $normalized->children = [];
        }

        if (!is_array($attributes)) {
            $normalized->attributes = [];
        }

        switch (gettype($before)) {
            case 'NULL':
                $normalized->before = null;
            break;

            case 'string':
                $normalized->before = $this->select($before);
            break;
        }

        $normalized->data = $data;

        return $normalized;
    }

    public function loadFragmentFile(
        $filename,
        $use_include_path = false,
        $context = null,
        $offset = -1,
        $maxlen = null
    )
    {
        if (is_null($maxlen)) {
            $maxlen = filesize($filename);
        }
        
        $source = file_get_contents(
            $filename,
            $use_include_path,
            $context,
            $offset,
            $maxlen
        );

        return $this->loadFragment($source);
    }

    public function loadFragment($source)
    {
        $fragment = $this->createDocumentFragment();
        @$fragment->appendXML($source);

        return $fragment;
    }

    public function getElementsByTagName($tag)
    {
        $node_list = parent::getElementsByTagName($tag);

        if ($node_list) {
            return new NodeList($node_list);
        }
    }
    
    public function select($selector)
    {
        return $this->documentElement->select($selector);
    }

    public function selectAll($selector)
    {
        return $this->documentElement->selectAll($selector);
    }

    public function saveSource($filename, $flags = 0, $context = null)
    {
        file_put_contents($path, $this, $flags, $context);
        
        return $this;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'xpath':
                return $this->_xpath;
        }
    }

    public function __toString()
    {
        if (!$this->formatOutput) {
            $this->documentElement->clean();
        }
        
        return substr($this->saveXML(), 0, -1);
    }
}