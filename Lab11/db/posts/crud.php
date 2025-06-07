<?php

// CREATE
function savePost($pdo, $author_id, $text, $images): int|null {
    $created_at = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO posts (author_id, text, created_at) VALUES (:author_id, :text, :created_at)");
    $result = $stmt->execute([
        ':author_id' => $author_id,
        ':text' => $text,
        ':created_at' => $created_at
    ]);
    if ($result) {
        $post_id = $pdo->lastInsertId();
        $stmt_img = $pdo->prepare("INSERT INTO post_images (post_id, post_index, image_path) VALUES (:post_id, :post_index, :image_path)");
        foreach ($images as $index => $imagePath) {
            $stmt_img->execute([
                ':post_id' => $post_id,
                ':post_index' => $index,
                ':image_path' => $imagePath
            ]);
        }
        return $post_id;
    }
    return null;
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
        ORDER BY posts.created_at DESC, post_images.post_index ASC
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

function getPostById($pdo, $authorId) {
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
        WHERE posts.id = ?
    ");

    $stmt->execute([$authorId]);

    $result = $stmt->fetch();
    
    $post = [
        'id' => $result['post_id'],
        'author' => [
            'name' => $result['author_name'],
            'avatar' => $result['author_avatar']
        ],
        'text' => $result['text'],
        'likes' => $result['likes'],
        'created_at' => $result['created_at'],
        'images' => []
    ];
    if ($result['image_path']) {
        $post['images'][] = $result['image_path'];
    }

    return $post;
}


function getPosts($pdo): array {
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

function getLikes($pdo, $postId) {
    $stmt = $pdo->prepare("SELECT likes FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['likes'];
}

// UPDATE
function updatePost($pdo, $postId, $newText) {
    $stmt = $pdo->prepare("UPDATE posts SET text = ? WHERE id = ?");
    return $stmt->execute([$newText, $postId]);
}

function saveLikes($pdo, $postId, $count) {
    $stmt = $pdo->prepare("UPDATE posts SET likes = ? WHERE id = ?");
    return $stmt->execute([$count, $postId]);
}

function getLikeRecordsByUserId($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT user_id, post_id FROM post_likes WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLikeRecord($pdo, $userId, $postId) {
    $stmt = $pdo->prepare("SELECT user_id, post_id FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteLikeRecord($pdo, $userId, $postId) {
    $stmt = $pdo->prepare("DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
    if ($stmt->execute([$userId, $postId])) {
        return $stmt->rowCount() > 0;
    }
    return false;
}

function saveLikeRecord($pdo, $userId, $postId ) {
    $stmt = $pdo->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (:user_id, :post_id)");
    return $stmt->execute([
        ':user_id' => $userId,
        ':post_id' => $postId,
    ]);
}

// DELETE
function deletePost($pdo, $postId) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$postId]); 
}
