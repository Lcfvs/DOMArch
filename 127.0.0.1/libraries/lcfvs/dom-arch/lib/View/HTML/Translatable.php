<?php
namespace DOMArch\View\HTML;

trait Translatable
{
    public function translate(
        ...$params
    )
    {
        $document = $this->ownerDocument;
        $document->translate($this, ...$params);

        return $this;
    }

    public function translateAttr(
        string $attribute,
        ...$params
    )
    {
        $document = $this->ownerDocument;
        $document->translateAttr($this, $attribute, ...$params);

        return $this;
    }
}