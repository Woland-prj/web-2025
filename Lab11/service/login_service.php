<?php

include_once '../db/users/crud.php';
include_once '../db/connection.php';

const lifetime = 86400;
const session_params = [
    'lifetime' => lifetime,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Strict'
];

function login(array $login_request) {
    $salt = getenv('APP_SALT');
    $pdo = connectToDatabase();
    $profile = getProfileByEmail($pdo, $login_request['email']);

    if (!$profile) {
        http_response_code(401);
        echo json_encode(['message' => 'invalid credentials']);
        exit();
    }

    $pwd_peppered = hash_hmac("sha256", $login_request['password'], $salt);

    if (!password_verify($pwd_peppered, $profile['password'])) {
        http_response_code(401);
        echo json_encode(['message' => 'invalid']);
        exit();
    }

    session_set_cookie_params(session_params);
    session_name('auth');
    session_start();
    $_SESSION['user_id'] = $profile['id'];

    return $profile;
}

function authByCookie(): array {
    session_set_cookie_params(session_params);
    session_name('auth');
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;

    if(!$user_id) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'unauthorized']);
        exit();
    }

    $pdo = connectToDatabase();
    $profile = getProfileById($pdo,$user_id );

    if(!$profile) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'unauthorized']);
        exit();
    }

    return $profile;
}

function logout() {
    session_set_cookie_params(session_params);
    session_name('auth');
    session_start();
    
    session_unset();

    session_destroy();
    setcookie(session_name(), '', time() - lifetime, '/');
}

function rehashPasswords() {
    $pdo = connectToDatabase();
    $passwords = getUnhashedPasswords($pdo);

    $salt = getenv('APP_SALT');

    foreach ($passwords as $pass) {
        $user_id = $pass['id'];
        $plain_password = $pass['password'];

        $pass_peppered = hash_hmac("sha256", $plain_password, $salt);
        $hashed_password = password_hash($pass_peppered, PASSWORD_BCRYPT);

        updatePassword($pdo, $user_id, $hashed_password);
    }
}