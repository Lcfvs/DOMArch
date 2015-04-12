<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

class Document extends \DOMDocument
{
    const DEFAULT_TEMPLATE = '<!DOCTYPE html><html><head><title></title></head><body></body></html>';

    // params
    public $formatOutput = false;
    public $standalone = true;
    public $preserveWhiteSpace = false;

    private $_xpath = null;
    private $_fields = ['input', 'select', 'textarea'];
    private $_medias = ['audio', 'video'];

    private $_unbreakables = [
        'a', 'abbr', 'acronym', 'area', 'audio', 'b', 'base', 'bdi', 'bdo',
        'big', 'body', 'br', 'button', 'canvas', 'cite', 'code', 'col',
        'colgroup', 'command', 'datalist', 'del', 'dfn', 'dl', 'em', 'embed',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'hgroup', 'hr', 'html',
        'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'link',
        'map', 'mark', 'meta', 'meter', 'noscript', 'object', 'ol', 'optgroup',
        'output', 'pre', 'progress', 'q', 'ruby', 's', 'samp', 'script',
        'select', 'small', 'span', 'strong', 'style', 'sub', 'sup', 'textarea',
        'time', 'title', 'tr', 'tt', 'u', 'ul', 'var', 'video', 'wbr'
    ];

    public function __construct($load_default_template = false, $encoding = 'utf-8')
    {
        parent::__construct('1.0', $encoding);

        $this->encoding = $encoding;
        
        if ($load_default_template) {
            $this->loadHTML(static::DEFAULT_TEMPLATE);
        }
    }
    
    public function loadHTML($source, $options = null)
    {
        @parent::loadHTML($source, $options);

        $encoding = $this->encoding;
        
        $this->_xpath = new \DOMXpath($this);
        $this->registerNodeClass('\\DOMNode', 'PHPDOM\\HTML\\Node');
        $this->registerNodeClass('\\DOMElement', 'PHPDOM\\HTML\\Element');
        $this->registerNodeClass('\\DOMText', 'PHPDOM\\HTML\\Text');
        $this->registerNodeClass('\\DOMDocumentFragment', 'PHPDOM\\HTML\\DocumentFragment');
        
        $this->formatOutput = false;
        $this->preserveWhiteSpace = false;
        $this->standalone = true;

        $meta = $this->select('head meta[charset]');
        
        if ($meta) {
            $meta->setAttribute('charset', $encoding);
        } else {
            $this->select('head')
                ->append([
                    'tag' => 'meta',
                    'attributes' => [
                        'charset' => $encoding
                    ]
                ]);
        }
        
        return $this;
    }

    public function loadHTMLFile($filename, $options = null)
    {
        $source = file_get_contents($filename);
        
        return $this->loadHTML($source);
    }

    public function create($definition)
    {
        $type = gettype($definition);
        
        if ($type !== 'array' && $type !== 'object') {
            return $this->createTextNode(strval($definition));
        }
    
        $normalized = $this->_normalize($definition);
        $tag = $normalized->tag;
        $data = $normalized->data;
        $value = $normalized->value;
        $node = $this->createElement($tag);
        $node->setAttributes($normalized->attributes);

        if (in_array($tag, $this->_fields)) {
            if (!is_null($value)) {
                $node->value = $value;
            }
        } else if (!empty($data)) {
            foreach ($data as $key => $line) {
                if ($key) {
                    $node->appendChild($this->createElement('br'));
                }

                $node->appendChild($this->createTextNode($line));
            }
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
        $tag = @$normalized->tag;
        $children = @$normalized->children;
        @$normalized->value =
        $value = @$normalized->value;

        if (!is_array($children)) {
            $normalized->children = [];
        }

        if (!is_array($attributes)) {
            $attributes = [];
        }

        switch (gettype($before)) {
            case 'NULL':
                $normalized->before = null;
            break;

            case 'string':
                $normalized->before = $this->querySelector($before);
            break;
        }

        switch ($tag) {
            case 'script':
                foreach ($attributes as $name => $value) {
                    switch ($name) {
                        case 'async':
                        case 'defer':
                            $attributes[$name] = $value ? $name : '';
                        break;
                    }
                }
                
            break;
                
            case 'track':
                foreach ($attributes as $name => $value) {
                    switch ($name) {
                        case 'default':
                            $attributes[$name] = $value ? $name : '';
                        break;
                    }
                }
                
            break;
            
            default:
                if (in_array($tag, $this->_fields)) {
                    $data = [];

                    foreach ($attributes as $name => $value) {
                        switch ($name) {
                            case 'autocomplete':
                                $attributes[$name] = $value ? 'on' : 'off';
                            break;

                            case 'autofocus':
                            case 'disabled':
                            case 'readonly':
                            case 'required':
                            case 'multiple':
                                $attributes[$name] = $value ? $name : '';
                            break;
                        }
                    }
                } else if (in_array($tag, $this->_medias)) {
                    foreach ($attributes as $name => $value) {
                        switch ($name) {
                            case 'autoplay':
                            case 'defer':
                            case 'controls':
                            case 'loop':
                            case 'muted':
                                $attributes[$name] = $value ? $name : '';
                            break;
                        }
                    }
                } else {
                    switch (gettype($data)) {
                        case 'string':
                            if (in_array($tag, $this->_unbreakables)) {
                                $data = preg_split('/\n\r?/', $data);
                            } else {
                                $data = [$data];
                            }
                            
                        break;

                        default:
                            $data = [];
                    }
                }
        }

        $normalized->data = $data;
        $normalized->attributes = $attributes;

        return $normalized;
    }

    public function loadFragment($path)
    {
        $fragment = $this->createDocumentFragment();
        $fragment->appendXML(file_get_contents($path));

        return $fragment;
    }

    public function getElementsByTagName($tag)
    {
        $node_list = parent::getElementsByTagName($tag);

        if ($node_list) {
            return new NodeList($node_list);
        }
    }
    
    public function addStyleSheet($path, $directory = '/css/', $attributes = [])
    { 
        return $this->select('head')->append(array_merge([ 
            'tag' => 'link', 
            'attributes' => [ 
                'rel' => 'stylesheet', 
                'href' => $directory . $path
            ] 
        ], $attributes); 
    }
    
    public function select($selector)
    {
        return $this->documentElement->select($selector);
    }

    public function selectAll($selector)
    {
        return $this->documentElement->selectAll($selector);
    }

    public function __get($name)
    {
        switch ($name) {
            case 'body':
                return $this->select('body');
            case 'forms':
                return $this->selectAll('body form');
            case 'lang':
                return $this->documentElement->getAttribute('lang');
            case 'title':
                return $this->select('title')->textContent;
            case 'xpath':
                return $this->_xpath;
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'title':
                $title = $this->select('title');
                $node = $title->childNodes->item(0);

                if ($node) {
                    $node->nodeValue = $value;
                } else {
                    $title->appendChild($this->createTextNode($value));
                }
            break;

            case 'lang':
                $document_element = $this->documentElement;
                $document_element->setAttribute('lang', $value);
            break;
        }
    }

    public function __toString()
    {
        return substr($this->saveHTML(), 0, -1);
    }
}