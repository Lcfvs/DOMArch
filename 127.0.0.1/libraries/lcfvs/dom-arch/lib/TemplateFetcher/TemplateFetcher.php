<?php
namespace DOMArch\Assembler;

use DOMArch\Assembler;

class TemplateFetcher
{
    private $_assembler;
    private $_extension;
    private $_parent;
    private $_path;

    static private $_templates = [];
    static private $_fragments = [];

    public function __construct(
        Assembler $assembler,
        string $path,
        string $extension,
        self $parent = null
    )
    {
        $this->_assembler = $assembler;
        $this->_extension = $extension;
        $this->_parent = $parent;
        $this->_path = $path;
    }

    public function fetch(
        bool $as_clone = true
    )
    {
        $document = $this->_assembler->getDocument();
        $path = $this->getFilename();

        if ($as_clone && !empty(self::$_fragments[$path])) {
            return self::$_fragments[$path]
                ->cloneNode(true);
        }

        if (empty(self::$_templates[$path])) {
            self::$_templates[$path] = $document->loadFile($path);
        }


        $fragment = $document->loadFragment(self::$_templates[$path]);

        if ($as_clone) {
            self::$_fragments[$path] = $fragment;
        }

        return $fragment->cloneNode(true);
    }

    public function getDocument()
    {
        return $this->_assembler->getDocument();
    }

    public function getFilename()
    {
        return $this->_path . $this->_extension;
    }

    public function __call($name, $arguments)
    {
        $path = $this->_path . '/' . $name;

        return new static($this->_assembler, $path, $this->_extension, $this);
    }
}