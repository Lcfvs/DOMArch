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
            'orm:convert-mapping',
            implode(' ', $filters),
            //'--force',
            '--from-database',
            //'--namespace=' . $config->get('namespace'),
            '--extend=' . $config->get('class'),
            $config->get('type'),
            $config->get('directory')
        ])
    );
})();