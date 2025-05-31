<?php
include_once '../service/login_service.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be POST']);
    exit();
}

logout();
