<?php
include '../templates/post.php';
include '../utils/encoder.php';
include '../db/connection.php';
include '../db/posts/crud.php';
// $posts = loadFromFile("../data/posts/posts.json");
$conn = connectToDatabase();
$posts = getPosts($conn);
?>
<!doctype html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Лента</title>
  <link rel="stylesheet" href="../styles/fonts.css" />
  <link rel="stylesheet" href="../styles/home_styles.css" />
</head>

<body>
  <div class="dock">
    <div class="dock__item-bar">
      <a class="dock__button dock__button_active" href="home.php">
        <object
          data="../images/icons/home.svg"
          type="image/svg+xml"
          class="dock__button-icon"></object>
      </a>
      <a class="dock__button" href="profile.php?id=1">
        <object
          data="../images/icons/profile.svg"
          type="image/svg+xml"
          class="dock__button-icon"></object>
      </a>
      <a class="dock__button">
        <object
          data="../images/icons/plus.svg"
          type="image/svg+xml"
          class="dock__button-icon"></object>
      </a>
    </div>
  </div>
  <div class="feed">
    <?php if ($posts): ?>
      <?php foreach ($posts as $post): ?>
        <?php renderPost($post); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Постов не найдено</p>
    <?php endif; ?>
  </div>
</body>

</html>
