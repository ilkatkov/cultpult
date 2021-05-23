<?php
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
    <script src="../../js/Chart.js"></script>
    <script src="../../js/statements.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo_mini.svg" class="logo_img"></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            $state = getState($_SESSION['Username']);
            // пользователь уже авторизован
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
            ?>
                <!-- Основная форма -->
                <form action="../" id="statements_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>
                    <?php if ($state == "1") { // если зашел куратор
                    ?>
                        <input class="btn btn_menu1" type="button" id="on_event" value="Ведомость по группе">
                    <?php } else if ($state != "1") {
                    ?>
                        <input class="btn btn_menu1" type="button" id="on_register" value="Зарегистрировавшиеся">
                        <input class="btn btn_menu2" type="button" id="on_arrive" value="Пришедшие">
<!--                    <input class="btn btn_menu" type="button" id="akt_unused" value="Акт выдачи невостр. пит.">-->
                        <input class="btn btn_menu3" type="submit" value="Назад">

                    <?php
                    } else {
                        echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
                    }
                    ?>
                </form>
                <!-- Форма для выхода -->

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