<?php
$opts = ['http' => ['method' => 'GET', 'header' => "User-Agent: cli\r\n"]];
$ctx = stream_context_create($opts);
$s = @file_get_contents('http://127.0.0.1:8000/login', false, $ctx);
if (isset($http_response_header)) {
    foreach ($http_response_header as $h) echo $h . PHP_EOL;
}
echo PHP_EOL;
echo substr($s, 0, 1200);
