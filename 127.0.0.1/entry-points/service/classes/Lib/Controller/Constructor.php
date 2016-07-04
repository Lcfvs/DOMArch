<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace Lib\Controller;

use DOMArch\View\JSON;

trait Constructor
{
    protected $_moduleId;
    protected $_classId;

    public function __construct(
        JSON $view,
        int $id = null,
        int $owner_id = null
    )
    {
        parent::__construct($view);

        $this->_moduleId = $id;
        $this->_classId = $owner_id;

        $schema_names = explode('\\', static::class);
        array_shift($schema_names);

        $view->set('#schema', implode(':', $schema_names));
    }
}