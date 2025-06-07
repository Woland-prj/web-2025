<?php
include_once '../utils/validator.php';
include_once '../service/post_service.php';
include_once '../service/login_service.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be POST']);
    exit();
}

$auth_result = authByCookie();

if (isset($auth_result['code'])) {
    http_response_code($auth_result['code']);
    echo json_encode(($auth_result['message']));
    exit();
}

$requester = $auth_result['user'];

if (!isset($_FILES['images']) || !isset($_POST['data'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing images or data']);
    exit();
}

var_dump($_FILES['images']);

$data = json_decode($_POST['data'], true);

if (!$data || !validateCreatePostRequest($data)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Invalid JSON or missing text']);
    exit();
}

$post = createPost($requester['id'], $data['text'], $_FILES['images']);

if ($post) {
    http_response_code(201); // Created
    echo json_encode($post);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Internal server error']);
}
