<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/PHPDOM
*/
namespace PHPDOM\HTML;

class Element extends \DOMElement
{
    use NodeTrait;

    public function setAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'elements':
                if ($this->nodeName === 'form') {
                    return $this->selectAll('input, select, textarea');
                }

                break;

            case 'value':
                switch ($this->nodeName) {
                    case 'textarea':
                        return $this->nodeValue;

                    case 'input':
                        switch ($this->getAttribute('type')) {
                            case 'checkbox':
                            case 'radio':
                                if ($this->getAttribute('checked') !== 'checked') {
                                    break;
                                }

                            default:
                                return $this->getAttribute('value');
                        }

                        break;

                    case 'select':
                        $selected_option = $this->select(':scope > [selected="selected"]');

                        if ($selected_option) {
                            return $selected_option->getAttribute('value');
                        }
                }

                break;
        }
    }

    public function __set($name, $value)
    {
        if ($name === 'value') {
            switch ($this->nodeName) {
                case 'select':
                    $selected_option = $this->select(':scope > [value="' . $value . '"]');

                    if ($selected_option) {
                        $selected_option->setAttribute('selected', 'selected');
                    }

                break;

                case 'textarea':
                    $this->nodeValue = $value;

                    break;

                case 'input':
                    switch ($this->getAttribute('type')) {
                        case 'checkbox':
                        case 'radio':
                            if ($value) {
                                $this->setAttribute('checked', 'checked');
                            } else {
                                $this->removeAttribute('checked');
                            }

                            break;

                        default:
                            $this->setAttribute('value', $value);
                    }
            }
        }
    }
}