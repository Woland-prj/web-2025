<?php
function factorial($n) {
    if ($n < 0) {
        return "Ошибка: введите неотрицательное число.";
    }
    if ($n === 0 || $n === 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}

$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["number"]) && is_numeric($_POST["number"])) {
        $number = intval($_POST["number"]);
        if ($number >= 0) {
            $result = "Факториал $number равен " . factorial($number);
        } else {
            $result = "Ошибка: введите неотрицательное число.";
        }
    } else {
        $result = "Ошибка: введите корректное число.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Факториал</title>
</head>
<body>
    <h2>Вычисление факториала</h2>
    <form method="post">
        <label for="number">Введите число:</label>
        <input type="text" name="number" id="number" required>
        <button type="submit">Рассчитать</button>
    </form>
    <p><?php echo $result; ?></p>
</body>
</html>
