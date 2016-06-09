<?php
namespace DOMArch\Url\Translated;

interface iTranslated
{
    static function _translate(array $params);

    static function _route($uri);
}