<?php
function dump($value) {
    Lib\Request\Incoming::current()
        ->dump($value);
}