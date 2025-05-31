<?php
include '../templates/profile.php';
include '../utils/encoder.php';
include '../utils/validator.php';
include '../utils/getter.php';
include '../db/connection.php';
include '../db/posts/crud.php';
include '../db/users/crud.php';
$id = validateQueryInt('id');
if (!$id) {
  header("Location: /home");
  exit;
}
// $profiles = loadFromFile("../data/users/users.json");
// $profile = findById($profiles, $id, fn($user) => validateUserJson($user));
$conn = connectToDatabase();
$profile = getProfileById($conn, $id);
$posts = getPostsByAuthorId($conn, $id);
$profile['galery'] = array();
foreach ($posts as $post) {
  $profile['galery'][] = $post['images'][0];
}

if (!$profile) {
  header("Location: /pages/home.php");
  exit;
}
?>
<!doctype html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Профиль - <?= $profile['name']; ?></title>
  <link rel="stylesheet" href="../styles/fonts.css" />
  <link rel="stylesheet" href="../styles/profile_styles.css" />
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
      <a class="dock__button dock__button_active" href="profile?id=1">
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

  <?php renderProfile($profile); ?>
</body>

</html>
