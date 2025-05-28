<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be POST']);
    exit();
}

// Проверяем, пришли ли данные в формате JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Invalid JSON']);
    exit();
}
