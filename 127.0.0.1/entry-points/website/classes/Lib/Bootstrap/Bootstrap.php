<?php
namespace Lib;

use DOMArch;

abstract class Bootstrap
    extends DOMArch\Bootstrap
{
    protected function __construct()
    {
        parent::__construct();

        $this->_orm();
    }

    protected function _orm() : self
    {
        $config = Config::global();
        $context_config = $config->get('context');

        ORM::bootstrap(
            $context_config->get('entities')->get('directory'),
            $context_config->get('isDevMode', false),
            $context_config->get('orm')->toArray(true),
            $config->get('createdAt')
        );

        return $this;
    }
}