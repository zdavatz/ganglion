<?php
// SSE proxy for gang2fts5 /api/ask endpoint (Grok AI Q&A)
$input = json_decode(file_get_contents('php://input'), true);
$question = isset($input['question']) ? trim($input['question']) : '';

if ($question === '') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Keine Frage angegeben']);
    exit;
}

// Disable output buffering for streaming
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', false);
while (ob_get_level()) { ob_end_clean(); }

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

$url = 'http://127.0.0.1:3000/api/ask';
$postData = json_encode(['question' => $question]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: text/event-stream',
]);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
    echo $data;
    flush();
    return strlen($data);
});

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($result === false || $httpCode !== 200) {
    echo "data: {\"type\":\"error\",\"content\":\"Suchserver nicht erreichbar\"}\n\n";
    flush();
}

curl_close($ch);
