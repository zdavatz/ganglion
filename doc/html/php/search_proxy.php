<?php
// Proxy search requests to the gang2fts5 full-text search server
header('Content-Type: application/json; charset=utf-8');

$q = isset($_GET['q']) ? $_GET['q'] : '';
if ($q === '') {
    echo '[]';
    exit;
}

$url = 'http://127.0.0.1:3000/api/search?q=' . urlencode($q);

$ctx = stream_context_create(['http' => ['timeout' => 5]]);
$response = @file_get_contents($url, false, $ctx);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Suchserver nicht erreichbar']);
    exit;
}

echo $response;
