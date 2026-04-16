<?php
// Proxy search requests to the gang2fts5 full-text search server
header('Content-Type: application/json; charset=utf-8');

$q = isset($_GET['q']) ? $_GET['q'] : '';
if ($q === '') {
    echo '[]';
    exit;
}

$url = 'http://127.0.0.1:3000/api/search?q=' . urlencode($q);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode(['error' => 'Suchserver nicht erreichbar']);
    exit;
}

echo $response;
