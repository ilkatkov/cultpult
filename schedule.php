<?php
include_once "mobile.php";
include_once "functions/mysql.php";

$debug = getDebug();

if (!$debug){
    $work = getStatus();
    if (!$work){
        header('Location: break.php');
    }
}

$events = getevents(); // получаем весь список групп
$times = geteventsTime();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">
    <title>КультПульт - ПК № 8 им. И.Ф. Павлова</title>
    <meta name="description" content='Запись на бесплатный горячий обед в ГАПОУ ПК № 8 им. И.Ф. Павлова'>
    <link rel="stylesheet" href="styles/schedule.css?v2.0">
    <link rel="stylesheet" type="text/css" href="styles/jquery.fancybox.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
</head>

<body>
    <div class="header_div">
        <div class="logo_div">
            <img src="img/logo.svg" class="logo_img">
            <p class="logo_word">КультПульт</p>
        </div>
        <div class="schedule_label">
            Расписание обедов
        </div>
    </div>

    <div class="schedule_div">
        <table class="schedule_table">
            <thead>
                <tr>
                    <td class="header_td">
                        № п/п
                    </td>
                    <td class="header_td">
                        Время
                    </td>
                    <td class="header_td">
                        Группа
                    </td>
                </tr>
            </thead>
            <?php
            $number = 0;
            for ($row = 0; $row < count($events); $row++) {
                if ($times[$row]['time'] != "00:00") {
                    $temp_event = $events[array_search($times[$row]['id'], array_column($events, 'id'))]['name'];
                    echo "<tr>";
                    $number++;
                    echo "<td>" . (string)($number) . "</td>";
                    echo "<td>" . $times[$row]['time'] . "</td>";
                    echo "<td>" . $temp_event . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
    <form action=".">
    <div class="input_div ">
        <button class="back_button " id="back"><img src="img/bxs-chevron-right.svg " class="chevron_sch">Назад</button>
    </div>
    </form>
</body>

</html>