<?php
include_once "functions/mysql.php";
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">
    <title>КультПульт - БПК</title>
    <meta name="description" content='Запись на бесплатный горячий обед в ОГАПОУ "Белгородский педагогический колледж"'>
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
            Технический перерыв&nbsp;
        </div>
    </div>
    <div class="main_div">
        <div class="auth">Сервис недоступен</div>
        <p class="participant_label">Проводится обновление сайта. Приносим извинения за предоставленные неудобства.</p>
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
                        for ($img = 1; $img < count($slider); $img++) {
                            if (!empty($slider[("adv" . (string)($img))])) {
                                echo "<div class='slider__item'>";
                                echo "<img src='" . $slider[("adv" . (string)($img))] . "' class='adv_img'>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script src="js/slider.js "></script>
        </div>
    </div>

</body>

</html>