<?php

include '../db/users/crud.php';
include '../db/connection.php';

function login(array $login_request) {
    $salt = getenv('APP_SALT');
    $pdo = connectToDatabase();
    $profile = getProfileByEmail($pdo, $login_request['email']);

    if (!$profile) {
        http_response_code(401);
        echo json_encode(['message' => 'invalid credentials']);
        exit();
    }

    $pwd_peppered = hash_hmac('sha256', $login_request['password'], $salt);

    if (!password_verify($pwd_peppered, $profile['password'])) {
        //echo print_r($profile);
        http_response_code(401);
        echo json_encode(['message' => 'invalid credentials']);
        exit();
    }

    session_set_cookie_params([
        'lifetime' => 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_name('auth');
    session_start();
    $_SESSION['user_id'] = $profile['id'];
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