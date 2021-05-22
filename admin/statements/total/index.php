<?php
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
    <script src="../../../js/jquery-3.5.1.min.js"></script>
    <script src="../../../js/total.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            // пользователь уже авторизован
            $state = getState($_SESSION['Username']);
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "1") {
                // в календарь ставим сегодняшнюю дату
                $link = connectDB();
                $date_for_calendar = mysqli_real_escape_string($link, (string)date("Y-m-d"));
            ?>
                <div class="div title_div">
                    <p style='font-size:20px;'>Ведомости КультПульт</p>
                </div>
                <br>
                <hr>
                <!-- Word форма -->
                    <p style='font-size:20px;'>Выберите дату и нажмите<br>"Получить"</p>

                    <!-- Выбор даты -->
                <div class = 'statements_div'>
                    <?php
                    echo "<input type='date' value=" . $date_for_calendar . " name = 'date' id = 'date' autofocus>"
                    ?>
                    <?php
                    echo "<a id = 'btn_word' class = 'btn_download' href = 'download_word.php?date=" . $date_for_calendar . "'><input class='btn btn_ok' type='submit' value='Получить Word'></a>"
                    ?>
                    <?php
                    echo "<a id = 'btn_excel' class = 'btn_download' href = 'download_excel.php?date=" . $date_for_calendar . "'><input class='btn btn_ok' type='submit' value='Получить Excel'></a>"
                    ?>
                </div>



                <!-- Форма для выхода -->
                <form action="../">
                    <input class="btn btn_back" type="submit" value="Назад">
                </form>
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