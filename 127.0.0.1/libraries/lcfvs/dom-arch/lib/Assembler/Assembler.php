<?php
namespace DOMArch;

use DOMArch\Assembler\TemplateFetcher;

class Assembler
{
    private $_document;
    private $_fetcher;
    private $_extension;
    private $_path;

    protected function __construct(
        $body,
        string $type = 'html'
    )
    {
        $path = Config::global()
            ->get('common')
            ->get('directories')
            ->get('templates');

        $this->_document = $body;
        $this->_extension = '.' . $type;
        $this->_path = $path . '/' . $type;
        $this->_fetcher = new TemplateFetcher($this, $this->_path, $this->_extension);
    }
    
    public function save(
        string $name,
        \DOMNode $node,
        string $directory = 'content'
    )
    {
        $path = implode('/', [
            $this->_path,
            $directory,
            $name . $this->_extension
        ]);

        file_put_contents($path, (string) $node);
    }

    public function getDocument()
    {
        return $this->_document;
    }

    /**
     * @return Fetcher
     */
    public function getFetcher()
    {
        return $this->_fetcher;
    }
}