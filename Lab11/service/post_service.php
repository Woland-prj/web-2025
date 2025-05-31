<?php

include_once '../db/connection.php';
include_once '../db/posts/crud.php';

function createPost(int $author_id, string $text, array $images): array|null {
    $upload_dir = __DIR__ . '/../images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $saved_images = [];
    if (isset($images['tmp_name']) && is_array($images['tmp_name'])) {
        foreach ($images['tmp_name'] as $index => $tmp_name) {
            $original_name = basename($images['name'][$index]);
            $target_path = $upload_dir . $original_name;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $saved_images[] = '../images/' . $original_name;
            }
        }
    }

    $pdo = connectToDatabase();
    $post_id = savePost($pdo, $author_id, $text, $saved_images);
    if ($post_id != null) {
        return getPostById($pdo, $post_id);
    } else {
        return null;
    } 
}

function updateLikesCount(int $user_id, int $post_id, array $like_request): bool {
    $pdo = connectToDatabase();
    $post = getPostById($pdo, $post_id);

    if(!$post) return false;

    $is_liked = getLikeRecord($pdo, $user_id, $post_id) ? true : false;

    if($like_request['type'] == 'inc') {
        if(!$is_liked) {
            saveLikeRecord($pdo, $user_id, $post_id);
            return saveLikes($pdo, $post_id, $post['likes'] + 1) ? true : false;
        } else {
            http_response_code(403); // Forbiden
            echo json_encode(['message' => 'Post already liked']);
            exit();
        }
    } elseif (($like_request['type'] == 'dec') && $is_liked) {
        if($is_liked) {
            deleteLikeRecord($pdo, $user_id, $post_id);
            return saveLikes($pdo, $post_id, $post['likes'] - 1) ? true : false;
        } else {
            http_response_code(403); // Forbiden
            echo json_encode(['message' => 'Post not liked by you']);
            exit();
        }
    } else return false;
}
