<?php
require_once 'cli.php';

$config = Lib\Config::global();
$common_config = $config->get('common');
$host = $common_config->get('urlPrefixes')->get('current');
$locales = $common_config->get('locales')->toArray();

$url = Lib\Url::parse($host);

$url_params = [
    'moduleName' => 'Welcome',
    'className' => 'Index',
    'method' => 'get'
];

ksort($url_params);

$route_params = [
    'format' => (string) $url->rewrite($url_params)
];

foreach ($locales as $key => $locale) {
    if (!$key) {
        $route_params[$locale] = (string) $url->rewrite();

        continue;
    }

    $route_params[$locale] = $route_params['format'] . '&locale=' . $locale;
}

Routes::fromArray($route_params)->save();

echo 'done';

exit;