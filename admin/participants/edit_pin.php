<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$participant_id =  $_GET['participant'];
$new_pin = "";
if (!empty($_POST['pin'])) {
    $new_pin = $_POST['pin'];
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/participants.js"></script>
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
                $event_name = getNameOnCode(getparticipantInfo($_GET['participant'])[0]["events"]);
            ?>
                <form id="participant_form" method="POST">
                    <!-- Заголовок -->
                    <?php
                    if (!empty($_POST['pin'])) {
                        editPin($_POST['participant_id'], $new_pin);
                    ?>
                        <form>
                            <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                            <p style='font-size:20px; margin-top:-20px;'>PIN успешно изменен!</p>
                            <div>
                                <div class="ring">
                                    <span></span>
                                </div>
                            </div>
                            <?php

                            echo "<meta http-equiv='refresh' content='2;participants.php?select_events=" . $event_name . "'>";
                            ?>
                        </form>
                    <?php
                    } else {
                    ?>
                        <div class="div title_div">
                            <p style='font-size:20px;'>Участники КультПульт</p>
                        </div>
                        <hr>
                        <!-- Пароль -->
                        <div>
                            <label for="new_password" style="font-size:30px;">Новый PIN</label><br><input class="in_terminal" name="pin" type="text" inputmode="numeric" style="-webkit-text-security: disc;" autocomplete="off" maxlength=4 pattern="[0-9]{4}" title="Введите 4-PIN-код." autofocus>
                            <input type="text" value='<?= $participant_id ?>' name='participant_id' hidden>
                            <input type="text" value='<?= $event_name ?>' name='participant_event' hidden>
                        </div>
                        <hr>
                        <!-- Применить -->
                        <input class="btn btn_ok" type="submit" id="accept" value="Применить">
                        <input class="btn btn_back" type="button" id="btn_back_edit" value="Назад">
                </form>
            <?php
                    }
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