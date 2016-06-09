<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\XML;

class NodeList
{
    private $_nodeList = null;

    public function __construct(\DOMNodeList $node_list)
    {
        $this->_nodeList = $node_list;
    }

    function __get($name)
    {
        if ($name === 'length') {
            $node_list = $this->_nodeList;
            
            if ($node_list) {
                return $node_list->length;
            }
            
            return 0;
        }

        throw new \Exception('Undefined property ' . $name);
    }
    
    public function each($callback)
    {
        $index = 0;
        $length = $this->length;

        for (; $index < $length; $index += 1) {
            $result = $callback($this->item($index), $index, $this);
        }
        
        return $result;
    }
    
    public function every($callback)
    {
        $index = 0;
        $length = $this->length;

        for (; $index < $length; $index += 1) {
            $result = $callback($this->item($index), $index, $this);
            
            if (!$result) {
                break;
            }
        }
        
        return $result;
    }

    public function item($index)
    {
        $node = $this->_nodeList->item($index);

        return $node;
    }

    public function remove()
    {
        $iterator = 0;
        $length = $this->length;
        
        if (!$length) {
            return $this;
        }
        
        $fragment = $this->item(0)->ownerDocument->create();
        
        for (; $iterator < $length; $iterator += 1) {
            $item = $this->item($iterator);
            
            if ($item) {
                $fragment->appendChild($item);
            }
        }
        
        return $fragment->children();
    }
    
    public function __toString()
    {
        $data = '';

        $this->each(function ($node, $index, $node_list)
        use (&$data) {
            $data .= $this->item($index);
        });

        return $data;
    }
}