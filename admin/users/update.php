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
    <title>Пользователи КультПульт</title>
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
                if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state == "5") {
                    $user = getUser($_POST['login_update'])[0];
                    if ($user['state'] != "1") {
                        updateUser($_POST['login_update'], $_POST['state'], $_POST['fio'], $_POST['password']);
                    } else {
                        updateCurator($_POST['login_update'], $_POST['password']);
                    }
                ?>
                    <div>
                        <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                        <p style='font-size:20px;'>Пользователь <?= $_POST['login_update'] ?> обновлен!</p>
                        <meta http-equiv='refresh' content='2;index.php'>
                    </div>
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

            </form>
        </content>
        <!-- Подвал -->
        <footer>
            
        </footer>
    </div>
</body>

</html>