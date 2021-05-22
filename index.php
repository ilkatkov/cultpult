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
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">
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
            <img src="img/logo.svg" class="logo_img">
            <p class="logo_word">КультПульт</p>
        </div>
        <div class="date_lunch">
            Запись на мероприятия
        </div>
    </div>
    <div class="main_div">
        <div class="auth">Авторизация на сервисе</div>
        <form action="register.php" method="POST" name="id_form">
            <p class="participant_label">Код участника</p>
            <?php
            if (!isMobile()) {
            ?>
                <script src="js/keyboard_login.js"></script>
                <div class="input_div">
                    <input type="text" class="participant_input" name="participant_id" id="participant_id" inputmode="numeric" autocomplete="off" maxlength=8 pattern="[0-9]{7}" title="Введите 8-код подтверждения." readonly>
                    <img src="img/backspace-fill.svg" class="backspace" id="backspace">
                </div>
            <?php
            } else {
            ?>
                <script src="js/keyboard_login_mobile.js"></script>
                <div class="input_div">
                    <input type="text" class="participant_input" name="participant_id" id="participant_id_mobile" inputmode="numeric" autocomplete="off" maxlength=8 pattern="[0-9]{7}" title="Введите 8-код подтверждения.">
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
                <input type="submit" id="accept" value="Я участвую">
                <img src="img/bxs-chevron-right.svg " class="chevron_go">
            </div>
        </form>
        <div class="adv">
            <div class="slider">
                <div class="adv_control">
                    <div class="adv_label">Акции от партнёров</div>
                    <a class="slider__control slider__control_prev" href="#" role="button"></a>
                    <a class="slider__control slider__control_next" href="#" role="button"></a>
                </div>
                <div class="slider__wrapper">
                    <div class="slider__items">
                        <?php
                        $slider = getAdv();
                        for ($img = 0; $img < count($slider); $img++) {
                            if (!empty($slider[$img])) {
                                echo "<div class='slider__item'>";
                                echo "<img src='" . $slider[$img] . "' class='adv_img'>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script src="js/slider.js "></script>
        </div>
        <button data-fancybox data-src="#modal_info" href="javascript:;" class="info_button"><img src="img/info.svg" class="info_img"></button>
    </div>

    <div class="modal_info" id="modal_info">
        <div class="info_label">Информация</div>
        <?php
        $info = getInfo(); // получение информации
        ?>
        <div class="info_body">
            <p><?= $info['text'] ?></p>
            <div class="contact">
                <img src="img/vk.svg">&nbsp;<?= $info['vk'] ?>
            </div>
            <div class="contact">
                <img src="img/email.svg">&nbsp;<?= $info['email'] ?>
            </div>
        </div>
    </div>

</body>

</html>