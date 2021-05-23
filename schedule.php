<?php
include_once "mobile.php";
include_once "functions/mysql.php";


$events = getevents(); // получаем весь список мероприятий
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.svg" type=" image/svg+xml">
    <title>КультПульт</title>
    <meta name="description" content='Запись на мероприятия КультПульт'>
    <link rel="stylesheet" href="styles/schedule.css?v3.0">
    <link rel="stylesheet" type="text/css" href="styles/jquery.fancybox.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/index.js"></script>
</head>

<body>
    <div class="header_div">
        <div class="logo_div">
            <img src="img/logo_mini.svg" class="logo_img">
        </div>
    </div>

    <div class="schedule_div">
        <table class="schedule_table">
            <thead>
                <tr>
                    <td class="header_td">
                        №
                    </td>
                    <td class="header_td">
                        Мероприятие
                    </td>
                </tr>
            </thead>
            <?php
            $number = 0;
            for ($row = 0; $row < count($events); $row++) {

                    $temp_event = $events[$row]['name'];
                    echo "<tr>";
                    $number++;
                    echo "<td>" . (string)($number) . "</td>";
                    echo "<td>" . $events[$row]['date'] . "<br>" . $temp_event . "</td>";
                    echo "</tr>";

            }
            ?>
        </table>
    </div>
    <form action=".">
    <div class="input_div ">
        <button class="btn btn_menu3 " id="back"><img src="img/bxs-chevron-right.svg " class="chevron_sch">Назад</button>
    </div>
    </form>
</body>

</html>