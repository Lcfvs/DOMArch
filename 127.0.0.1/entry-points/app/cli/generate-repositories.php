<?php
require_once 'cli.php';

(function() {
    $config = Lib\Config::global()
        ->get('context')
            ->get('repositories');

    $filters = [];

    if (count($_SERVER['argv']) > 1) {
        $names = array_slice($_SERVER['argv'], 1);

        foreach ($names as $name) {
            $filters[] = '--filter ' . $name;
        }
    }

    Indoctrinated\Db::run(
        implode(' ', [
            'orm:generate-repositories',
            implode(' ', $filters),
            $config->get('directory')
        ])
    );
})();