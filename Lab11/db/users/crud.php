<?php

// READ
function getProfileById($pdo, int $id) {
    $stmt = $pdo->prepare("SELECT id, name, bio, avatar, email, password FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getProfileByEmail($pdo, string $email) {
    $stmt = $pdo->prepare("SELECT id, name, bio, avatar, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUnhashedPasswords($pdo) {
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE password NOT LIKE '%$%'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// UPDATE
function updatePassword($pdo, int $id, string  $pass) {
    $sql = "UPDATE users SET password = :password WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':password' => $pass,
        ':id' => $id
    ]);
}