<?php
include_once "../../functions/mysql.php";

session_start();

$old_time = $_POST['old_time'];
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <title>Мероприятия КультПульт</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <form>
                <?php
                $state = getState($_SESSION['Username']);
                if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "1") {
                    $exist_time = existTime($event_time);
                    if (!$exist_time || $event_time == $old_time) {
                        $link = connectDB();
                        $event_id = mysqli_real_escape_string($link, $_POST['event_id']);
                        $event_time = mysqli_real_escape_string($link, $_POST['event_time']);
                        $event_form = mysqli_real_escape_string($link, $_POST['event_form']);
                        $event_teacher = mysqli_real_escape_string($link, $_POST['event_teacher']);
                        $update_query = "UPDATE events SET time = '" . $event_time . "', form = '" . $event_form . "', teacher = '" . $event_teacher . "' WHERE id = '" . $event_id . "'";
                        var_dump($update_query);
                        mysqli_query($link, $update_query);
                ?>
                        <div>
                            <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                            <p style='font-size:20px;'>Группа изменена!</p>
                            <meta http-equiv='refresh' content='1;index.php'>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div>
                            <p style='color:#E74C3C;' class="login_mes">Ошибка!</p>
                            <p style='font-size:20px;'>Каждая группа должна принимать обед в свое время!</p>
                            <meta http-equiv='refresh' content='0;index.php'>
                        </div>
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
            </form>
        </content>
        <!-- Подвал -->
        <footer>

        </footer>
    </div>
</body>

</html>