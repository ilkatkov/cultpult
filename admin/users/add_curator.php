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
    <script src="../../js/jquery-3.5.1.min.js"></script>
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
            // пользователь уже авторизован
            $state = getState($_SESSION['Username']);
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state == "5") {
                $events = getEvents();
            ?>
                <!-- Основная форма -->
                <form action="add.php" method="POST">
                    <div class="div title_div">
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>
                    <label for="login">ФИО</label>
                    <input class = "admin_input" type="text" id="fio" name="fio" required><br>
                    <label for="login">Логин</label>
                    <input class = "admin_input" type="text" id="login" name="login" required><br>
                    <label for="password">Пароль</label>
                    <input class = "admin_input" type="password" id="password" name="password" required><br>
                    <label for="events">Мероприятие</label>
                    <select class = "admin_select" id="events" name="events" required>
                        <?php
                        for ($event = 0; $event < count($events); $event++) {
                            echo "<option value = '" . $events[$event]['name'] . "'>" . $events[$event]['name'] . "</option>";
                        }
                        ?>
                    </select>

                    <input class="btn mt8px btn_menu1" type="submit" value="Отправить">
                </form>
                <!-- Форма для выхода -->
                <form action="./">
                    <input class="btn mt8px btn_menu3" type="submit" value="Назад">
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