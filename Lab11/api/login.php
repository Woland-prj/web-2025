<?php
include '../service/login_service.php';
include '../utils/validator.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be POST']);
    exit();
}

$login_request = json_decode(file_get_contents('php://input'), true);

if (!$login_request || !validateLoginRequest($login_request)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Invalid JSON']);
    exit();
}

login($login_request);
