<?php
include '../templates/post.php';
include '../utils/encoder.php';
include '../db/connection.php';
include '../db/posts/crud.php';
include_once '../service/login_service.php';

$auth_result = authByCookie();

if (isset($auth_result['code']) && ($auth_result['code'] == 401)) {
    header("Location: /login");
    exit();
}

$requester = $auth_result['user'];
$conn = connectToDatabase();
$posts = getPosts($conn);
$likeRecords = getLikeRecordsByUserId($conn, $requester['id']);
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Лента</title>
    <link rel="stylesheet" href="../styles/fonts.css" />
    <link rel="stylesheet" href="../styles/home_styles.css" />
    <script src="../scripts/modal.js" defer></script>
    <script src="../scripts/slider.js" defer></script>
    <script src="../scripts/more.js" defer></script>
    <script src="../scripts/like.js" defer></script>
    <script src="../scripts/logout.js" defer></script>
    <script src="../scripts/home_common.js" defer></script>
</head>

<body>
<div class="dock">
    <div class="dock__item-bar">
        <a class="dock__button dock__button_active" href="home">
            <object
                data="../images/icons/home.svg"
                type="image/svg+xml"
                class="dock__button-icon"></object>
        </a>
        <a class="dock__button" href="profile?id=<?= $requester['id']; ?>">
            <object
                data="../images/icons/profile.svg"
                type="image/svg+xml"
                class="dock__button-icon"></object>
        </a>
        <a class="dock__button" href="post_creation">
            <object
                data="../images/icons/plus.svg"
                type="image/svg+xml"
                class="dock__button-icon"></object>
        </a>
    </div>
    <div class="dock__logout">
        <img class="dock__button" src="../images/icons/logout.svg" alt="logout button">
    </div>
</div>
<div class="feed" id="feed">
    <?php if ($posts): ?>
        <?php foreach ($posts as $post): ?>
            <?php renderPost($post, $likeRecords); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Постов не найдено</p>
    <?php endif; ?>
</div>
<div class="modal" id="modal"></div>
</body>
</html>
