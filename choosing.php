<?php

include_once "mobile.php";
include_once "functions/mysql.php";

session_start();

session_start();
$debug = getDebug();

if (!$debug) {
    $work = getStatus();
    if (!$work) {
        header('Location: break.php');
    }
}

$dates_label = getDates5Label();

global $participant_id;
$participant_id = $_SESSION['participant_id'];
$_SESSION['participant_pin'] = md5($_POST['participant_pin'] . "welcomebelgorod");
global $participant_pin;
$participant_pin = $_SESSION['participant_pin'];
$participant_pin_db = getPin($participant_id)[0]['pin'];
$participant = getparticipantInfo($participant_id)[0];
$_SESSION['token'] = md5($participant_id . $participant_pin . "welcomebelgorod");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">
    <title>КультПульт - ПК № 8 им. И.Ф. Павлова</title>
    <meta name="description" content='Запись на бесплатный горячий обед в ГАПОУ ПК № 8 им. И.Ф. Павлова'>
    <link rel="stylesheet" href="styles/new_design.css">
    <link rel="stylesheet" type="text/css" href="styles/jquery.fancybox.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/choosing_moscow.js"></script>

    <!-- СКРИПТ ОТМЕНЫ ЗАЯВКИ -->
    <script>
        window.onload = function() {
            try {
                var btn_cancel = document.getElementById('cancel_button');
                btn_cancel.onclick = function() {
                    $.ajax({
                        type: "POST",
                        url: "cancel.php",
                        data: {
                            participant: "<? echo $participant_id; ?>",
                            pin: "<? echo $participant_pin ?>"
                        },
                        error: function(xhr, textStatus) {
                            alert([xhr.status, textStatus]);
                        }
                    });
                    btn_cancel.disabled = true;
                    btn_cancel.innerHTML = 'Заявка отменена!';
                }
            } catch (error) {}
        }
    </script>

</head>

<body>
    <div class="header_div">
        <div class="logo_div">
            <img src="img/logo.svg" class="logo_img">
            <p class="logo_word">КультПульт</p>
        </div>
        <div class="date_lunch">
            Запись на питание&nbsp;<font color="#F1813B"><?= $dates_label ?></font>
        </div>
    </div>


    <?php if ($participant['pin'] != $participant_pin) { ?>
        <div class="message_div">
            <div class="dear_failed">
                Неверный PIN!
            </div>
            <div class="message">Повторите ввод.</div>
            <meta http-equiv='refresh' content='3;index.php'>
        </div>
    <?php } else {
        $dates = getDates5();
    ?>
        <script type="text/javascript">
            function checker() {
                if ($('input:checkbox').filter(':checked').length == 0) {
                    alert('Выберите дни недели для питания!');
                    return false;
                } else {
                    document.getElementById("accept").value = "Отправляю поварам";
                    document.getElementById("accept").style.background = "#2ECC71";
                    document.getElementById("accept").style.opacity = 0.5;
                }
            }
        </script>


        <div class="choosing_div">
            <form action="result.php" method="POST" name="choosing_form">
                <div class="auth">Выберите дни недели</div>
                <div class="dates">
                    <div class="checkbox_date">
                        <div class="date_name">пн</div>
                        <input id="monday" type="checkbox" name="dates[]" value=<?= $dates["full"][0] ?>>
                        <label for="monday"></label>
                        <div class="date_number"><?= $dates["short"][0] ?></div>
                    </div>
                    <div class="checkbox_date">
                        <div class="date_name">вт</div>
                        <input id="tuesday" type="checkbox" name="dates[]" value=<?= $dates["full"][1] ?>>
                        <label for="tuesday"></label>
                        <div class="date_number"><?= $dates["short"][1] ?></div>
                    </div>
                    <div class="checkbox_date">
                        <div class="date_name">ср</div>
                        <input id="wednesday" type="checkbox" name="dates[]" value=<?= $dates["full"][2] ?>>
                        <label for="wednesday"></label>
                        <div class="date_number"><?= $dates["short"][2] ?></div>
                    </div>
                    <div class="checkbox_date">
                        <div class="date_name">чт</div>
                        <input id="thursday" type="checkbox" name="dates[]" value=<?= $dates["full"][3] ?>>
                        <label for="thursday"></label>
                        <div class="date_number"><?= $dates["short"][3] ?></div>
                    </div>
                    <div class="checkbox_date">
                        <div class="date_name">пт</div>
                        <input id="friday" type="checkbox" name="dates[]" value=<?= $dates["full"][4] ?>>
                        <label for="friday"></label>
                        <div class="date_number"><?= $dates["short"][4] ?></div>
                    </div>
                </div>
                <div class="input_div ">
                    <input onClick="return checker()" type="submit" id="accept" value="Подтвердить">
                    <img src="img/bxs-chevron-right.svg " class="chevron_go ">
                </div>
            </form>
            <form action="index.php">
                <div class="input_div ">
                    <button class="back_button " id="back">Назад</button>
                    <img src="img/bxs-chevron-right.svg " class="chevron_pin ">
                </div>
            </form>
        <?php } ?>
</body>

</html>