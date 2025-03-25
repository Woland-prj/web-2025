<?php
function selectNum(int $num)
{
  $num_arr = ["Ноль", "Один", "Два", "Три", "Четыре", "Пять", "Шесть", "Семь", "Восемь", "Девять"];
  if ($num >= 0 && $num <= 9) {
    return $num_arr[$num];
  }
  return "Не цифра (от 0 до 9)";
}

$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $num = isset($_POST['num']) ? intval($_POST['num']) : 0;
  $result = selectNum($num);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Цифры</title>
</head>

<body>
  <form method="post">
    <label for="num">Введите цифру:</label>
    <input type="number" name="num" id="num" required min="0" max="9">
    <button type="submit">Проверить</button>
  </form>

  <?php if (!empty($result)) : ?>
    <p>Результат: <?= $result ?></p>
  <?php endif; ?>
</body>

</html>
