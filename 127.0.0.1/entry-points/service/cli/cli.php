<?php
chdir(__DIR__ . '/..');

require_once 'vendor/autoload.php';

Lib\Bootstrap\Cli::parse(
    'config.json'
);

if ($argv[0] === 'cli' . DIRECTORY_SEPARATOR . 'cli.php') {
    (function($argv) {
        Indoctrinated\Db::run(
            implode(' ', array_slice($argv, 1)));
    })($argv);

    exit;
}