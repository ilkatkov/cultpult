<?php
include_once "../../functions/mysql.php";

$id = $_GET['id'];
$event = $_GET['event'];
$surname = $_GET['surname'];
$name = $_GET['name'];
$patronymic = $_GET['patronymic'];

if (!empty($id) && !empty($event) && !empty($surname) && !empty($name) && !empty($patronymic)) {
    $link = connectDB();
    $pin = (string)rand(0, 9) . (string)rand(0, 9) . (string)rand(0, 9) . (string)rand(0, 9);
    $query_insert = "INSERT INTO participants (id, name, surname, patronymic, events, typefinancing, pin) VALUES ('" . mysqli_real_escape_string($link, $id) . "', '" . mysqli_real_escape_string($link, $name) . "' , '" . mysqli_real_escape_string($link, $surname) . "', '" . mysqli_real_escape_string($link, $patronymic) . "', '" . mysqli_real_escape_string($link, $event) . "',  1 , '" .  md5(mysqli_real_escape_string($link, $pin)) . "')";
    mysqli_query(connectDB(), $query_insert);
    echo "<p style='color:green'><b>Студент добавлен!</b></p>";
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
    <title>Добавить студента КультПульт</title>
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
    <h3>Добавить студента КультПульт</h3>
    <form action="add_participant.php" method="get">
        <table border="1">
            <tr>
                <td>ID студента:</td>
                <td>
                    <input type="number" name="id" id="id">
                </td>
            </tr>
            <tr>
                <td>ID группы:</td>
                <td>
                    <input type="number" name="event" id="event">
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