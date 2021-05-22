<?php

include_once "mobile.php";
include_once "functions/mysql.php";

session_start();

global $participant_id;
$participant_id = $_POST['participant_id'];
$_SESSION = $_POST['participant_id'];

$existParticipant = existParticipant($participant_id);

if (!empty($existParticipant))
{
    $participant = getParticipantInfo($participant_id);
    $event = $participant['event'];
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.svg" type=" image/svg+xml">
    <title>КультПульт</title>
    <meta name="description" content='Запись на мероприятия'>
    <link rel="stylesheet" href="styles/new_design.css?v2.0">
    <link rel="stylesheet" type="text/css" href="styles/jquery.fancybox.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script>
        window.onload = function() {
            // СКРИПТ ОТМЕНЫ ЗАЯВКИ
            try {
                var btn_cancel = document.getElementById('cancel_button');
                btn_cancel.onclick = function() {
                    $.ajax({
                        type: "POST",
                        url: "cancel.php",
                        data: {
                            participant_id: "<? echo $participant_id; ?>",
                            event: "<? echo $event; ?>",
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
            <img src="img/logo_mini.svg" class="logo_img">
        </div>
        <div class="date_lunch">
            Запись на мероприятия
        </div>
    </div>

    <div class="message_div">
        <?php
        if (empty($existParticipant)) {
        ?>
            <div class="dear_failed">
                Неверный код!
            </div>
            <div class="message">Повторите ввод.</div>
            <meta http-equiv='refresh' content='3;index.php'>
    </div>
<?php
        } else {
?>
    <div class="dear_success">
        <?php
        $participant = getParticipantInfo($participant_id);
            $temp_participant = explode(" ", $participant["surname"] . " " . $participant["name"] . " " . $participant["patronymic"]);
            $full_name = $temp_participant[0] . " " . substr($temp_participant[1], 0, 2) . "." . substr($temp_participant[2], 0, 2) . ".";
            $event = $participant['event'];
            insertArchive($participant_id, $event);
            echo $full_name . ",";
        ?>
    </div>
    <div class="message">Вы подтвердили участие на мероприятии<br>
        <?= $event?>.<br>Приятного отдыха!</div>
    <meta http-equiv='refresh' content='3;index.php'>
    <div class="input_div ">
        <button class="go_main " id="cancel_button" name="cancel_button">Отменить заявку</button>
    </div>
    </div>


<?php
        }

?>

</body>

</html>