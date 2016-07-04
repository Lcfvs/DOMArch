<?php
require_once 'cli.php';

(function() {
    $config = Lib\Config::global()
        ->get('context')
        ->get('entities');

    $filters = [];

    if (count($_SERVER['argv']) > 1) {
        $names = array_slice($_SERVER['argv'], 1);

        foreach ($names as $name) {
            $filters[] = '--filter ' . $name;
        }
    }

    Indoctrinated\Db::run(
        implode(' ', [
            'orm:generate:entities',
            implode(' ', $filters),
            $config->get('directory'),
            '--generate-methods',
            '--generate-annotations'
        ])
    );
})();