<?php

// READ
function getProfile($pdo, $id) {
    $stmt = $pdo->prepare("SELECT id, name, bio, avatar FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}