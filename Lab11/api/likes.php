<?php
include_once '../service/post_service.php';
include_once '../service/login_service.php';
include_once '../utils/validator.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PATCH') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be POST']);
    exit();
}

$post_id = validateQueryInt('postId');
if (!$post_id) {
    http_response_code(400); // Method Not Allowed
    echo json_encode(['message' => 'Invalid post id']);
    exit();
}

$requester = authByCookie();

$like_request = json_decode(file_get_contents('php://input'), true);

if (!$like_request || !validateLikeRequest($like_request)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Invalid JSON']);
    exit();
}

$success = updateLikesCount($requester['id'], $post_id, $like_request);
if($success) {
    http_response_code(204); // No Content;
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Internal server error']);
}
