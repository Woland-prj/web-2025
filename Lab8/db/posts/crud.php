<?php

// CREATE
function createPost($pdo, $authorId, $text) {
    $stmt = $pdo->prepare("INSERT INTO posts (author_id, text, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$authorId, $text]);
    return $pdo->lastInsertId();
}

// READ
function getPostsByAuthorId($pdo, $authorId) {
    $stmt = $pdo->prepare("
        SELECT 
            posts.id AS post_id,
            users.name AS author_name,
            users.avatar AS author_avatar,
            posts.text,
            posts.likes,
            posts.created_at,
            post_images.image_path
        FROM posts 
        JOIN users ON posts.author_id = users.id
        LEFT JOIN post_images ON posts.id = post_images.post_id
        WHERE posts.author_id = ?
        ORDER BY posts.created_at DESC
    ");

    $stmt->execute([$authorId]);

    $posts = [];
    while ($row = $stmt->fetch()) {
        $postId = $row['post_id'];
        if (!isset($posts[$postId])) {
            $posts[$postId] = [
                'id' => $postId,
                'author' => [
                    'name' => $row['author_name'],
                    'avatar' => $row['author_avatar']
                ],
                'text' => $row['text'],
                'likes' => $row['likes'],
                'created_at' => $row['created_at'],
                'images' => []
            ];
        }

        if ($row['image_path']) {
            $posts[$postId]['images'][] = $row['image_path'];
        }
    }

    return array_values($posts);
}

function getPosts($pdo) {
    $stmt = $pdo->query("
        SELECT 
            posts.id AS post_id,
            users.name AS author_name,
            users.avatar AS author_avatar,
            users.id AS author_id,
            posts.text,
            posts.likes,
            posts.created_at,
            post_images.image_path
        FROM posts 
        JOIN users ON posts.author_id = users.id
        LEFT JOIN post_images ON posts.id = post_images.post_id
        ORDER BY posts.created_at DESC
    ");

    $posts = [];
    while ($row = $stmt->fetch()) {
        $postId = $row['post_id'];
        if (!isset($posts[$postId])) {
            $posts[$postId] = [
                'id' => $postId,
                'author' => [
                    'id' => $row['author_id'],
                    'name' => $row['author_name'],
                    'avatar' => $row['author_avatar']
                ],
                'text' => $row['text'],
                'likes' => $row['likes'],
                'created_at' => strtotime($row['created_at']),
                'images' => []
            ];
        }

        if ($row['image_path']) {
            $posts[$postId]['images'][] = $row['image_path'];
        }
    }

    return array_values($posts);
}

// UPDATE
function updatePost($pdo, $postId, $newText) {
    $stmt = $pdo->prepare("UPDATE posts SET text = ? WHERE id = ?");
    return $stmt->execute([$newText, $postId]);
}

// DELETE
function deletePost($pdo, $postId) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$postId]); // каскадное удаление сработает и удалит изображения
}
