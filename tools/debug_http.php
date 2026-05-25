<?php
$opts = array('http' => array('method' => 'GET', 'header' => "User-Agent: cli\r\n"));
$ctx = stream_context_create($opts);
$s = @file_get_contents('http://127.0.0.1:8000/debug-auth', false, $ctx);
foreach ($http_response_header as $h) {
    echo $h . PHP_EOL;
}
echo PHP_EOL;
echo $s;
