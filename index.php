<?php
include_once "mobile.php";
include_once "functions/mysql.php";

session_start();

session_destroy();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.svg" type=" image/svg+xml">
    <title>КультПульт</title>
    <meta name="description" content='Запись на мероприятия КультПульт'>
    <link rel="stylesheet" href="styles/new_design.css?v3.0">
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
    <div class="main_div">
        <div class="auth"><b>Авторизация</b></div>
        <form action="register.php" method="POST" name="id_form">
            <p class="participant_label">Введите код участника (8 символов)</p>
            <?php
            if (!isMobile()) {
            ?>
                <script src="js/keyboard_login.js"></script>
                <div class="input_div">
                    <input type="text" class="participant_input" name="participant_id" id="participant_id" inputmode="numeric" autocomplete="off" maxlength=8 pattern="[0-9]{8}" title="Введите 8-код подтверждения." readonly>
                    <img src="img/backspace-fill.svg" class="backspace" id="backspace">
                </div>
            <?php
            } else {
            ?>
                <script src="js/keyboard_login_mobile.js"></script>
                <div class="input_div">
                    <input type="text" class="participant_input" name="participant_id" id="participant_id_mobile" inputmode="numeric" autocomplete="off" maxlength=8 pattern="[0-9]{8}" title="Введите 8-код подтверждения.">
                    <img src="img/backspace-fill.svg" class="backspace" id="backspace">
                </div>
            <?php
            }
            ?>
            <div class="keyboard">
                <div class="kb_row">
                    <button class="kb_button" id="k0" type="button">0</button>
                    <button class="kb_button" id="k1" type="button">1</button>
                    <button class="kb_button" id="k2" type="button">2</button>
                    <button class="kb_button" id="k3" type="button">3</button>
                    <button class="kb_button" id="k4" type="button">4</button>
                </div>
                <div class="kb_row">
                    <button class="kb_button" id="k5" type="button">5</button>
                    <button class="kb_button" id="k6" type="button">6</button>
                    <button class="kb_button" id="k7" type="button">7</button>
                    <button class="kb_button" id="k8" type="button">8</button>
                    <button class="kb_button" id="k9" type="button">9</button>
                </div>
            </div>
            <div class="input_div">
                <input class = "go_main1" type="submit" id="accept" value="Я участвую">
                <img src="img/bxs-chevron-right.svg " class="chevron_go">
            </div>


        </form>

    </div>
    <form action = "schedule.php">
        <input class = "schedule_button" type="submit" id="accept" value="Посмотреть расписание">
    </form>

</body>

</html>