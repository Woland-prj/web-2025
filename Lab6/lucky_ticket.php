<?php
function sumDigits(int $num)
{
  $sum = 0;
  while ($num > 0) {
    $digit = $num % 10;
    $sum += $digit;
    $num = floor($num / 10);
  }
  return $sum;
}

function getLucky(int $start_num, int $end_num)
{
  $lucky = [];
  for ($i = $start_num; $i <= $end_num; $i++) {
    $first_triade = intdiv($i, 1000);
    $last_triade = ($i % 1000);
    if (sumDigits($first_triade) == sumDigits($last_triade)) {
      $lucky[] = $i;
    }
  }
  return $lucky;
}

function printLucky(array $lucky)
{
  foreach ($lucky as $num) {
    echo '<p>' . $num . '</p>';
  }
}

$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $start_num = isset($_POST['num-start']) ? intval($_POST['num-start']) : null;
  $end_num = isset($_POST['num-end']) ? intval($_POST['num-end']) : null;
  if ($start_num && $end_num) {
    if ($start_num <= $end_num) {
      $result = getLucky($start_num, $end_num);
    } else {
      $result = "Начальное значение должно быть меньше конечного";
    }
  } else {
    $result = "Неверный диапазон";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Счастливые билеты</title>
</head>

<body>
  <form method="post">
    <label for="num-start">Введите начало диапазон:</label>
    <input type="number" name="num-start" id="num-start" required min="100000" max="999999">
    <label for="num-end">Введите конец диапазон:</label>
    <input type="number" name="num-end" id="num-end" required min="100000" max="999999">
    <button type="submit">Проверить</button>
  </form>

  <?php if (!empty($result)) : ?>
    <?php if (is_array($result)) : ?>
      <p>Результат:</p>
      <?php printLucky($result); ?>
    <?php else: ?>
      <p>Результат: <?= $result ?></p>
    <?php endif; ?>
  <?php endif; ?>
</body>

</html>
