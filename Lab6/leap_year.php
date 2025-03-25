<?php
function isLeapYear($year)
{
  return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
}

$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $year = isset($_POST['year']) ? intval($_POST['year']) : 0;
  if ($year > 0 && $year <= 30000) {
    $result = isLeapYear($year) ? "YES" : "NO";
  } else {
    $result = "Введите корректный год (1-30000)";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Високосный года</title>
</head>

<body>
  <form method="post">
    <label for="year">Введите год:</label>
    <input type="number" name="year" id="year" required min="1" max="30000">
    <button type="submit">Проверить</button>
  </form>

  <?php if (!empty($result)) : ?>
    <p>Результат: <?= $result ?></p>
  <?php endif; ?>
</body>

</html>
