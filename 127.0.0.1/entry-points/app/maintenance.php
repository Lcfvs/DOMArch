<?php

$html = '<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Service Unavailable</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Service Unavailable</h1>
    </body>
</html>';

http_response_code(503);
header('Content-Type: text/html');
header('Content-Length: ' . strlen($html));
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Thu, 01 Jan 1970 00:00:00');

echo $html;
exit();