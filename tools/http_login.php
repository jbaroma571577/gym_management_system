<?php
function get($url, &$headersOut = null) {
    $opts = ['http' => ['method' => 'GET', 'header' => "User-Agent: cli\r\n"]];
    $ctx = stream_context_create($opts);
    $s = @file_get_contents($url, false, $ctx);
    $headersOut = $http_response_header ?? [];
    return [$s, $headersOut];
}

function post($url, $data, $cookies = []) {
    $post = http_build_query($data);
    $cookieHeader = '';
    if (!empty($cookies)) {
        $parts = [];
        foreach ($cookies as $k=>$v) $parts[] = $k . '=' . $v;
        $cookieHeader = implode('; ', $parts);
    }
    $headers = "User-Agent: cli\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($post) . "\r\n";
    if ($cookieHeader !== '') $headers .= "Cookie: $cookieHeader\r\n";
    $opts = ['http' => ['method' => 'POST', 'header' => $headers, 'content' => $post, 'ignore_errors' => true]];
    $ctx = stream_context_create($opts);
    $s = @file_get_contents($url, false, $ctx);
    $h = $http_response_header ?? [];
    return [$s, $h];
}

// cookie jar and redirect-following POST
function request($method, $url, $data = null, &$cookies = [], $follow = 5) {
    $headersOut = [];
    $body = null;
    $method = strtoupper($method);
    for ($i = 0; $i < $follow; $i++) {
        if ($method === 'GET') {
            list($body, $headersOut) = get($url, $headersOut);
        } else {
            list($body, $headersOut) = post($url, $data, $cookies);
        }

        // update cookies from response
        foreach ($headersOut as $h) {
            if (stripos($h, 'Set-Cookie:') === 0) {
                $c = trim(substr($h, strlen('Set-Cookie:')));
                $pair = explode(';', $c)[0];
                [$k,$v] = explode('=', $pair, 2);
                $cookies[$k] = $v;
            }
        }

        // detect redirect
        $location = null;
        foreach ($headersOut as $h) {
            if (stripos($h, 'Location:') === 0) {
                $location = trim(substr($h, strlen('Location:')));
                break;
            }
        }

        if ($location) {
            // make absolute if relative
            if (strpos($location, 'http') !== 0) {
                $parts = parse_url($url);
                $base = $parts['scheme'] . '://' . $parts['host'];
                if (isset($parts['port'])) $base .= ':' . $parts['port'];
                $location = $base . $location;
            }
            // follow redirect with GET
            $method = 'GET';
            $url = $location;
            $data = null;
            continue;
        }

        break;
    }

    return [$body, $headersOut, $cookies];
}

// initial GET to /login
list($body, $headers, $cookies) = request('GET', 'http://127.0.0.1:8000/login');

// parse CSRF token
$csrf = null;
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $body, $m)) {
    $csrf = $m[1];
}

echo "Initial cookies:\n";
print_r($cookies);
echo "CSRF meta: $csrf\n\n";

// Try registering a temporary user to ensure we have an authenticated session
// Get CSRF token from the register page too
list($regBody, $regHeaders, $regCookies) = request('GET', 'http://127.0.0.1:8000/register');
$regCsrf = null;
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $regBody, $m2)) {
    $regCsrf = $m2[1];
}

$rand = time();
$testEmail = "test_user_{$rand}@example.test";
$regData = ['name' => 'Test User', 'email' => $testEmail, 'password' => 'password', 'password_confirmation' => 'password', '_token' => $regCsrf];
list($regResultBody, $regResultHeaders, $regResultCookies) = request('POST', 'http://127.0.0.1:8000/register', $regData, $cookies, 10);

// POST login and follow redirects (use the same CSRF from login page)
$postData = ['email' => $testEmail, 'password' => 'password', '_token' => $csrf];
list($finalBody, $finalHeaders, $finalCookies) = request('POST', 'http://127.0.0.1:8000/login', $postData, $cookies, 10);

echo "Final response headers:\n";
foreach ($finalHeaders as $h) echo $h . PHP_EOL;
echo PHP_EOL;
echo "Final cookies:\n";
print_r($finalCookies);
echo PHP_EOL;
echo "Final body snippet:\n";
echo substr($finalBody, 0, 1200);

// Verify dashboard with final cookies
list($dashBody, $dashHeaders, $dashCookies) = request('GET', 'http://127.0.0.1:8000/dashboard', null, $finalCookies, 5);
echo "\n---- DASHBOARD REQUEST (with final cookies) ----\n";
foreach ($dashHeaders as $h) echo $h . PHP_EOL;
echo PHP_EOL;
echo substr($dashBody, 0, 800);

echo "\n---- DEBUG AUTH REQUEST (with final cookies) ----\n";
list($debugBody, $debugHeaders, $debugCookies) = request('GET', 'http://127.0.0.1:8000/debug-auth', null, $finalCookies, 5);
foreach ($debugHeaders as $h) echo $h . PHP_EOL;
echo PHP_EOL;
echo $debugBody;

// Fetch SPA API endpoints with authenticated cookies
echo "\n---- API: /api/members ----\n";
list($membersBody, $membersHeaders, $membersCookies) = request('GET', 'http://127.0.0.1:8000/api/members', null, $finalCookies, 5);
foreach ($membersHeaders as $h) echo $h . PHP_EOL;
echo PHP_EOL;
echo $membersBody;

echo "\n---- API: /api/today-status ----\n";
list($todayBody, $todayHeaders, $todayCookies) = request('GET', 'http://127.0.0.1:8000/api/today-status', null, $finalCookies, 5);
foreach ($todayHeaders as $h) echo $h . PHP_EOL;
echo PHP_EOL;
echo $todayBody;

