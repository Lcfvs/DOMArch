<?php
namespace Lib\View\HTML;

use Assemblies\HTML\Layouts;
use Lib\View\HTML;

abstract class Page
    extends HTML
{
    public function __construct()
    {
        parent::__construct();

        Layouts\Page::assemble($this);
    }
}