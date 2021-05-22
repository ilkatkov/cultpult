<?php
include_once "../../functions/mysql.php";

$id = $_GET['id'];
$event_name = $_GET['event_name'];
$surname = $_GET['surname'];
$name = $_GET['name'];
$patronymic = $_GET['patronymic'];
$form = $_GET['form'];

if (!empty($id) && !empty($event_name) && !empty($surname) && !empty($name) && !empty($form) && !empty($patronymic)) {
    $link = connectDB();
    $curator = $surname . " " . $name . " " . $patronymic;
    $query_insert = "INSERT INTO events (id, name, form, time, curator) VALUES ('" . mysqli_real_escape_string($link, $id) . "', '" . mysqli_real_escape_string($link, $event_name) . "', '" . mysqli_real_escape_string($link, $form) . "' , '00:00' , '" . mysqli_real_escape_string($link, $curator) . "')";
    mysqli_query(connectDB(), $query_insert);
    echo "<p style='color:green'><b>Группа добавлена!</b></p>";
}
else {
    echo "<p style='color:red'><b>Проверьте все строки при записи!</b></p>";
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить группу КультПульт</title>
    <style>
        input[type=submit] {
            width: 177px;
        }

        a {
            color: black;
        }
    </style>
</head>

<body>
    <h3>Добавить группу КультПульт</h3>
    <form action="add_event.php" method="get">
        <table border="1">
            <tr>
                <td>ID группы:</td>
                <td>
                    <input type="number" name="id" id="id">
                </td>
            </tr>
            <tr>
                <td>Имя группы:</td>
                <td>
                    <input type="text" name="event_name" id="event_name">
                </td>
            </tr>
            <tr>
                <td>Форма обучения:</td>
                <td>
                    <select name ="form">
                        <option value="1">СПО</option>
                        <option value="2">НПО</option>
                    </select>
                </td>
            </tr>
            <tr align = "center">
                <td colspan="2">
                    <b>ФИО Куратора</b>
                </td>
            </tr>
            <tr>
                <td>Фамилия:</td>
                <td>
                    <input type="text" name="surname" id="surname">
                </td>
            </tr>
            <tr>
                <td>Имя:</td>
                <td>
                    <input type="text" name="name" id="name">
                </td>
            </tr>
            <tr>
                <td>Отчество:</td>
                <td>
                    <input type="text" name="patronymic" id="patronymic">
                </td>
            </tr>
            <tr align="center">
                <td>
                    <b><a href="index.php">Назад</a></b>
                </td>
                <td>
                    <input type="submit" value="ОК" width=20>
                </td>
            </tr>
    </form>

    </table>
</body>

</html>