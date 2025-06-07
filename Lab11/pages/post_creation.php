<?php

include_once '../service/login_service.php';

$auth_result = authByCookie();

if (isset($auth_result['code']) && ($auth_result['code'] == 401)) {
    header("Location: /login");
    exit();
}

$requester = $auth_result['user'];

?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Новый пост</title>
    <link rel="stylesheet" href="../styles/fonts.css" />
    <link rel="stylesheet" href="../styles/post_creation_styles.css" />
    <script src="../scripts/slider.js" defer></script>
    <script src="../scripts/post_creation.js" defer></script>
</head>

<body>
<div class="dock">
    <div class="dock__item-bar">
        <a class="dock__button" href="home">
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
        <a class="dock__button dock__button_active" href="post_creation">
            <object
                data="../images/icons/plus.svg"
                type="image/svg+xml"
                class="dock__button-icon"></object>
        </a>
    </div>
</div>
<div class="post-creation">
    <div class="post-creation__success-text">Пост успешно сохранен!</div>
    <form class="post-creation__form">
        <div class="post-creation__wrapper">
            <div class="post-creation__picture">
                <div class="post-creation__smile-wrapper">
                    <div class="post-creation__smile">🖼</div>
                    <label for="images-input" class="post-creation__label-button">Добавить фото</label>
                </div>
            </div>
            <div class="post-creation__notification"></div>
            <label for="images-input" class="post-creation__label">
                <img src="../images/icons/add_image_plus.svg" alt="plus_icon">
                <span>Добавить фото</span>
            </label>
            <input type="file" name="images[]" multiple class="post-creation__upload-input" id="images-input">
            <textarea name="text" class="post-creation__text-input" placeholder="Добавьте подпись..."></textarea>
        </div>
        <input type="submit" class="post-creation__submit-button" value="Поделиться">
    </form>
</div>
</body>

</html>
