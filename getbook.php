<?php
$url = 'https://d.calameo.com/pinwheel/viewer/book/get?' . $_SERVER['QUERY_STRING'];
$headers = [
    'Cache-Control: no-cache',
    'Connection: keep-alive',
    'DNT: 1',
    'Origin: https://www.calameo.com',
    'Pragma: no-cache',
    'Referer: https://www.calameo.com/',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-site',
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$curl_info = curl_getinfo($ch);
curl_close($ch);
$header_size = $curl_info['header_size'];
$http_response_code = $curl_info['http_code'];
$headers_str = substr($response, 0, $header_size);
$headers = explode("\r\n", $headers_str);
$body = substr($response, $header_size);

header_remove();
foreach ($headers as $header) {
    header($header, false);
}
header('Access-Control-Allow-Origin: *', true, $http_response_code);

echo $body;
