<?php
namespace DOMArch\Assembler;

use DOMArch\Assembler;
use PHPDOM\HTML\Document;

class HTML
    extends Assembler
{
    public function __construct(
        Document $body
    )
    {
        parent::__construct($body, 'html');
    }
}