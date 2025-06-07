<?php
include_once '../service/post_service.php';
include_once '../service/login_service.php';
include_once '../utils/validator.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PATCH') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Request method must be PATCH']);
    exit();
}

$post_id = validateQueryInt('postId');
if (!$post_id) {
    http_response_code(400); // Method Not Allowed
    echo json_encode(['message' => 'Invalid post id']);
    exit();
}

$auth_result = authByCookie();

if (isset($auth_result['code'])) {
    http_response_code($auth_result['code']);
    echo json_encode(($auth_result['message']));
    exit();
}

$requester = $auth_result['user'];

$like_request = json_decode(file_get_contents('php://input'), true);

if (!$like_request || !validateLikeRequest($like_request)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Invalid JSON']);
    exit();
}

$likes = updateLikesCount($requester['id'], $post_id, $like_request);

if($likes !== null) {
    http_response_code(200);
    echo json_encode(['likes' => $likes]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Internal server error']);
}
