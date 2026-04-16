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

$ctx = stream_context_create(['http' => [
    'method' => 'POST',
    'header' => "Content-Type: application/json\r\nAccept: text/event-stream\r\n",
    'content' => $postData,
    'timeout' => 120,
]]);

$stream = @fopen($url, 'r', false, $ctx);

if ($stream === false) {
    echo "data: {\"type\":\"error\",\"content\":\"Suchserver nicht erreichbar\"}\n\n";
    flush();
    exit;
}

while (!feof($stream)) {
    $line = fgets($stream);
    if ($line !== false) {
        echo $line;
        flush();
    }
}

fclose($stream);
