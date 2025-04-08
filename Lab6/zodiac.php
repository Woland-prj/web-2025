<?php
function getZodiac(int $timestamp)
{
  $zodiacSigns = [
    ['start' => '01-20', 'end' => '02-18', 'sign' => 'Водолей'],
    ['start' => '02-19', 'end' => '03-20', 'sign' => 'Рыбы'],
    ['start' => '03-21', 'end' => '04-19', 'sign' => 'Овен'],
    ['start' => '04-20', 'end' => '05-20', 'sign' => 'Телец'],
    ['start' => '05-21', 'end' => '06-20', 'sign' => 'Близнецы'],
    ['start' => '06-21', 'end' => '07-22', 'sign' => 'Рак'],
    ['start' => '07-23', 'end' => '08-22', 'sign' => 'Лев'],
    ['start' => '08-23', 'end' => '09-22', 'sign' => 'Дева'],
    ['start' => '09-23', 'end' => '10-22', 'sign' => 'Весы'],
    ['start' => '10-23', 'end' => '11-21', 'sign' => 'Скорпион'],
    ['start' => '11-22', 'end' => '12-21', 'sign' => 'Стрелец'],
    ['start' => '12-22', 'end' => '01-19', 'sign' => 'Козерог']
  ];

  $date = date('m-d', $timestamp);

  foreach ($zodiacSigns as $zodiac) {
    if (($date >= $zodiac['start'] && $date <= $zodiac['end']) ||
      ($zodiac['start'] === '12-22' && $date >= '12-22') ||
      ($zodiac['end'] === '01-19' && $date <= '01-19')
    ) {
      return $zodiac['sign'];
    }
  }

  return null;
}

$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $date = isset($_POST['date']) ? strtotime($_POST['date']) : null;
  if ($date) {
    $result = getZodiac($date);
  } else {
    $result = "Неправильная дата";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Знак зодиака</title>
</head>

<body>
  <form method="post">
    <label for="date">Введите дату:</label>
    <input type="text" name="date" id="date">
    <button type="submit">Проверить</button>
  </form>

  <?php if (!empty($result)) : ?>
    <p>Результат: <?= $result ?></p>
  <?php endif; ?>
</body>

</html>
