<?php
$cookieFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gym_session_cookie.txt';
@unlink($cookieFile);

function curlRequest($url, $method = 'GET', $postData = null) {
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_USERAGENT, 'cli');
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    }
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$info, $response];
}

function extractCsrf($body) {
    if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $body, $matches)) {
        return $matches[1];
    }
    return null;
}

list($info, $resp) = curlRequest('http://127.0.0.1:8000/login');
echo "GET /login status=" . $info['http_code'] . "\n";
list($header, $body) = [substr($resp, 0, $info['header_size']), substr($resp, $info['header_size'])];
$csrf = extractCsrf($body);
echo "CSRF=$csrf\n";

list($info, $resp) = curlRequest('http://127.0.0.1:8000/login', 'POST', [
    'email' => 'admin@gym.com',
    'password' => 'password',
    '_token' => $csrf,
]);
echo "POST /login status=" . $info['http_code'] . "\n";
list($header, $body) = [substr($resp, 0, $info['header_size']), substr($resp, $info['header_size'])];
echo $header;

list($info, $resp) = curlRequest('http://127.0.0.1:8000/dashboard');
echo "GET /dashboard status=" . $info['http_code'] . "\n";
list($header, $body) = [substr($resp, 0, $info['header_size']), substr($resp, $info['header_size'])];
echo $header;

list($info, $resp) = curlRequest('http://127.0.0.1:8000/debug-auth');
echo "GET /debug-auth status=" . $info['http_code'] . "\n";
list($header, $body) = [substr($resp, 0, $info['header_size']), substr($resp, $info['header_size'])];
echo $header;
echo $body;
