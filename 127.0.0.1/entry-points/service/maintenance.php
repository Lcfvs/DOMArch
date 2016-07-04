<?php

$json = json_encode((object) [
    '#schema' => 'Error',
    'type' => 'ServiceUnavailable',
    'message' => 'Service Unavailable'
]);

http_response_code(503);
header('Content-Type: application/json');
header('Content-Type: application/json');
header('Content-Length: ' . strlen($json));
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Thu, 01 Jan 1970 00:00:00');

exit($json);