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
    <script src="../../js/jquery-1.4.3.min.js"></script>
    <script src="../../js/settings_user.js"></script>
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

            ?>

                <!-- Основная форма -->
                <form action="update.php" method="POST">
                    <div class="div title_div">
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>
                    <?php
                    $user = getUser($_GET['login'])[0];
                    if ($user['state'] != "1") {
                    ?>
                        <label  for="fio">ФИО</label>
                        <input class = "admin_input" type="text" id="fio" name="fio" value="<?= $user['name'] ?>" required><br>
                        <label for="login">Логин</label>
                        <input type="text" id="login_update" name="login_update" value="<?= $user['login'] ?>" hidden>
                        <input class = "admin_input" type="text" id="login" name="login" value="<?= $_GET['login'] ?>" disabled><br>
                        <label for="password">Пароль</label>
                        <input class = "admin_input" type="password" id="password" name="password">
                        <p style="font-size:14px; line-height: 16px;">Если пароль не меняется,<br>то необходимо оставить его пустым.</p>
                        <label for="state">Статус</label>
                        <select class = "admin_select" id="state" name="state" required>
                            <?php if ($user['state'] == "2") {
                                echo "<option id='state' value='2' selected hidden>Расписание</option>";
                            } else if ($user['state'] == "5") {
                                echo "<option id='state' value='5' selected hidden>Суперадмин</option>";
                            }
                            ?>
                            <option id="state" value="5">Суперадмин</option>
                        </select>
                    <?php } else {
                    ?>
                        <label for="fio">ФИО</label>
                        <input class = "admin_input" type="text" id="fio" name="fio" value="<?= $user['name'] ?>" required disabled><br>
                        <label for="select_events">Группа</label>
                        <input class = "admin_input" type='text' id='select_events' name='select_events' value='<?= getEventOnCurator($user['login']) ?>' style='text-align:center;' readonly><br>
                        <label for="login">Логин</label>
                        <input  type="text" id="login_update" name="login_update" value="<?= $_GET['login'] ?>" hidden>
                        <input class = "admin_input" type="text" id="login" name="login" value="<?= $_GET['login'] ?>" disabled><br>
                        <label for="password">Пароль</label>
                        <input class = "admin_input" type="password" id="password" name="password" required>
                    <?php } ?>

                    <div class='statements_div'>
                    <input class="btn mt8px btn_menu1" type="submit" value="Подтвердить">
                </form>
                <button class="btn btn_menu2" id="btn_delete_user" name="btn_delete_user">Удалить пользователя</button>

                    </div><!-- Форма для выхода -->
                <form action="./">
                    <input class="btn btn_menu3" type="submit" value="Назад">
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