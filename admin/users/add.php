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
                    $exist_user = existUser($_POST['login']);
                    if (!$exist_user) {
                        if (empty($_POST['events'])) {
                            insertUser($_POST['login'], $_POST['state'], $_POST['fio'], $_POST['password']);
                        } else {
                            insertCurator($_POST['fio'], $_POST['login'], $_POST['events'], $_POST['password']);
                        }
                ?>
                        <div>
                            <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                            <p style='font-size:20px;'>Пользователь <?= $_POST['login'] ?> добавлен!</p>
                            <div class="ring">
                                <span></span>
                            </div>
                            <meta http-equiv='refresh' content='2;index.php'>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div>
                            <p style='color:#E74C3C;' class="login_mes">Ошибка!</p>
                            <p style='font-size:20px;'>Имя <?= $_POST['login'] ?> уже существует!</p>
                            <div class="ring">
                                <span></span>
                            </div>
                            <meta http-equiv='refresh' content='2;index.php'>
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