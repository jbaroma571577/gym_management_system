<?php
$cookies = ['XSRF-TOKEN'=>'eyJpdiI6InA2NnF1WUV2WXZqWnNJV29DeStuTUE9PSIsInZhbHVlIjoiWTFqTmVwVjNEOXlKOUdiYkIvT0dXaDMrUzArZTE0WHVsUFFpUnBuU2V5YmQ2WHp5OFVPZGpGS2ttU2RCSjhUNXgvaGtJeG5QUmVOcnFTeUxuMjQrSHlmTXNzNndDT1ROR1RucWd2UHZQNDNCbmJFTk5FYXJUQkJpTDkzaE9UMU8iLCJtYWMiOiJmNzE0ZDE4YzRmYzlkZTRhY2RjODViYjliZGU2N2IzOGQ5NzIzOTYwOGU1ZjQzNDU2M2Q4YmJiYzA0MDFhYWJkIiwidGFnIjoiIn0%3D','laravel-session'=>'eyJpdiI6IkgyZWNDc1NGbFFYNy9lN3FrTGpWWFE9PSIsInZhbHVlIjoiaWhnL2d6NncrbmwzQnBPQXI4MFVNMnpjWHp0Qml2S015bjJma000VkpoNGQ1dktkSjF2OUhIQTA4dnBMVjAzQm1aUmI4ZVJrM3QvaXRVMXBZMDBTQkhnV1R0eVlNdkh6WTFUdWp5ekZ0QytXR1JkdVhaNTRVR3JEaUdOZjUyVXkiLCJtYWMiOiI3ZTYwZDRmM2VhZTI0OTRmOTljYWE2ZDU5MTBiYzJiNjUwOTM2MTk1MDI2MjY4MTVmZmU5ZWI0ZTA1NzgyZDJmIiwidGFnIjoiIn0%3D'];
$cookieStr = '';
foreach($cookies as $k=>$v) $cookieStr .= $k . '=' . $v . '; ';
$opts = ['http'=>['method'=>'GET','header'=>"User-Agent:cli\r\nCookie: $cookieStr\r\n"]];
$ctx = stream_context_create($opts);
$s = @file_get_contents('http://127.0.0.1:8000/dashboard', false, $ctx);
foreach($http_response_header as $h) echo $h.PHP_EOL;
echo PHP_EOL;
echo substr($s,0,600);
