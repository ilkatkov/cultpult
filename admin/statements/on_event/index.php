<?php
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";

session_start();

// в календарь ставим дату на день позже
$date_for_calendar = (string)date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../../styles/style.css">
    <script src="../../../js/jquery-1.4.3.min.js"></script>
    <script src="../../../js/on_event.js"></script>
    <script type="text/javascript" src="../../../js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../../../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../js/fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
    <title>Панель управления</title>
</head>

<body>
<div class="page">
    <!-- Шапка -->
    <header>
        <div class="logo_div"><a href="/admin"><img src="../../../img/logo.svg" class="logo_img"></a><a href="/admin"
                                                                                                        class="admin_link">
                <p class="logo_word">КультПульт</p></a></div>
    </header>
    <!-- Контент -->
    <content>
        <?php
        // пользователь уже авторизован
        $state = getState($_SESSION['Username']);
        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
        $events = getevents(); // получаем весь список групп
        // в календарь ставим сегодняшнюю дату
        $link = connectDB();
        $date_for_calendar = mysqli_real_escape_string($link, (string)date("Y-m-d"));
        ?>
        <!-- Основная форма -->
        <form action="download.php" method="post" id="statements_form">
            <!-- Заголовок -->
            <div class="div title_div">
                <p style='font-size:20px;'>Ведомости КультПульт</p>
            </div>
            <hr>
            <!-- Выбор даты -->
            <div class="statement_div">
                <p style='font-size:20px;margin-bottom:10px;'>Выберите группу, дату и нажмите<br>"Получить ведомость"
                </p>
                <?php
                if ($state == "1") {
                    echo "<input type = 'text' id='select_events' name='select_events' value = '" . geteventOnCurator($_SESSION['Username']) . "' style='text-align:center;' readonly hidden>";
                    echo "<input type = 'text' id='show_event' name='show_event' value = '" . getNameOnCode(geteventOnCurator($_SESSION['Username'])) . "' style='text-align:center;' readonly>";
                } else {
                    echo "<select id='select_events' name='select_events'>";
                    for ($row = 0; $row < count($events); $row++) {
                        $temp_event = $events[$row]['name'];
                        $temp_id = $events[$row]['id'];
                        echo "<option value = '" . $temp_id . "'> " . $temp_event . " </option>";
                    }
                }
                ?>
                </select>
            </div>
                <div class='statements_div'>
                    <?php
                    echo "<input type='date' value=" . $date_for_calendar . " name = 'date' id = 'date' autofocus>";
                    ?>

                    <script type="text/javascript">
                        $(document).ready(function () {
                            $("#look_participants").fancybox({
                                'titlePosition': 'inside',
                                'transitionIn': 'none',
                                'transitionOut': 'none'
                            });
                        });
                    </script>
                    <button id="look_participants" class="btn btn_ok" href="#statement" title="Список студентов"
                            value="Ведомость питания">Получить ведомость
                    </button>
                    <input class="btn btn_menu" type="submit" value="Скачать ведомость">

        </form>
        <!-- Форма для выхода -->
        <form action="../">
            <input class="btn btn_back" type="submit" value="Назад">
        </form>
</div>

<div style="display: none;">
    <div id="statement" style="width:400px;height:768px;overflow:auto;">
        <p id="event_date">Загрузка...</p>
        <table border=1 class="table_module" id="participants">
        </table>
    </div>
</div>

<?php
} else {
    ?>
    <form>
        <p class="login_mes">Возврат на главную...</p>
        <meta http-equiv='refresh' content='1;../../index.php'>
    </form>
    <?php
}
?>
</content>
<!-- Подвал -->
<footer>

</footer>
</div>
</body>

</html>