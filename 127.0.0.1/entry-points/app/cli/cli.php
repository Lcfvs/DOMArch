<?php
chdir(__DIR__ . '/..');

require_once 'vendor/autoload.php';

Lib\Config::parse(__DIR__ . '/config.json', true);
Lib\Bootstrap\Cli::bootstrap();

if ($argv[0] === 'cli' . DIRECTORY_SEPARATOR . 'cli.php') {
    (function($argv) {
        Indoctrinated\Db::run(
            implode(' ', array_slice($argv, 1)));
    })($argv);

    exit;
}
