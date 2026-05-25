<?php
function fetch($url, $method = 'GET', $data = null, &$cookies = []) {
    $method = strtoupper($method);
    $headers = array('User-Agent: cli');
    if (!empty($cookies)) {
        $pairs = array();
        foreach ($cookies as $k => $v) {
            $pairs[] = $k . '=' . $v;
        }
        $headers[] = 'Cookie: ' . implode('; ', $pairs);
    }
    echo "\nREQUEST: $method $url\n";
    if (!empty($cookies)) {
        echo "REQUEST COOKIE: " . implode('; ', array_map(function ($k, $v) { return "$k=$v"; }, array_keys($cookies), $cookies)) . "\n";
    }
    if ($method === 'POST') {
        $body = http_build_query($data);
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $opts = array('http' => array('method' => 'POST', 'header' => implode("\r\n", $headers) . "\r\n", 'content' => $body, 'ignore_errors' => true));
    } else {
        $opts = array('http' => array('method' => 'GET', 'header' => implode("\r\n", $headers) . "\r\n", 'ignore_errors' => true));
    }
    $ctx = stream_context_create($opts);
    $resp = @file_get_contents($url, false, $ctx);
    $resHeaders = $http_response_header ?? array();
    foreach ($resHeaders as $h) {
        if (stripos($h, 'Set-Cookie:') === 0) {
            $cookie = trim(substr($h, strlen('Set-Cookie:')));
            $cookie = explode(';', $cookie)[0];
            list($key, $val) = explode('=', $cookie, 2);
            $cookies[$key] = urldecode($val);
        }
    }
    return array($resHeaders, $resp, $cookies);
}

$cookies = array();
list($headers, $body, $cookies) = fetch('http://127.0.0.1:8000/login', 'GET', null, $cookies);
echo "=== LOGIN GET ===\n";
print_r($headers);
echo "COOKIES AFTER GET:\n";
print_r($cookies);

$csrf = null;
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $body, $m)) {
    $csrf = $m[1];
}
echo "CSRF TOKEN: $csrf\n";

echo "=== LOGIN POST ===\n";
list($headers, $body, $cookies) = fetch('http://127.0.0.1:8000/login', 'POST', array('email' => 'admin@gym.com', 'password' => 'password', '_token' => $csrf), $cookies);
print_r($headers);
echo "COOKIES AFTER POST:\n";
print_r($cookies);
echo "BODY AFTER POST:\n";
echo substr($body, 0, 800);

// Follow redirect if needed
foreach ($headers as $h) {
    if (stripos($h, 'Location:') === 0) {
        $location = trim(substr($h, strlen('Location:')));
        if (strpos($location, 'http') !== 0) {
            $location = 'http://127.0.0.1:8000' . $location;
        }
        echo "FOLLOW REDIRECT TO: $location\n";
        list($headers, $body, $cookies) = fetch($location, 'GET', null, $cookies);
        echo "HEADERS AFTER REDIRECT:\n";
        print_r($headers);
        break;
    }
}

echo "=== DEBUG AUTH ===\n";
list($headers, $body, $cookies) = fetch('http://127.0.0.1:8000/debug-auth', 'GET', null, $cookies);
print_r($headers);
echo "BODY DEBUG AUTH:\n";
echo $body;
