<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/events.js"></script>
    <title>Участники КультПульт</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            // пользователь уже авторизован
            $state = getState($_SESSION['Username']);
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && ($state == "4" || $state == "5")) {
                $events = getevents(); // получаем весь список групп
            ?>
                <!-- Основная форма -->
                <form id="main_form" action="participants.php" method = "GET">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Участники КультПульт</p>
                    </div>
                    <hr>
                    <div>
                    <p style='font-size:20px;margin-bottom:10px;'> Выберите группу</p>
                    <select id="select_events" name = "select_events">
                        <?php
                        for ($row = 0; $row < count($events); $row++) {
                            $temp_event = $events[$row]['name'];
                            echo "<option value = '" . $temp_event . "'> " . $temp_event . " </option>";
                        }
                        ?>
                    </select>
                    </div>

                    <input class="btn btn_ok" type="submit" id="btn_select_event" value="Принять">
                    <input class="btn btn_back" type="button" id="btn_back_tab" value="Назад">
                </form>
            <?php
            } else {
                ?>
                    <form>
                        <p class="login_mes">Возврат на главную...</p>
                        <meta http-equiv='refresh' content='1;../index.php'>
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