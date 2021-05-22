<?php
include_once "../functions/mysql.php";

session_start();

// в календарь ставим дату на день позже
$date_for_calendar = (string)date("Y-m-d");

// выбор страницы
$page = $_GET['page'];

$dates = getDateArray();
$date_lunch = $dates[0];
$current_date = $dates[1];

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js"></script>
    <script src="../js/Chart.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            // пользователь уже авторизован
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
                // меню
                if ($page == "change_password") {
                    require_once "change_password.php";
                } else {
                    $state = getUser($_SESSION['Username'])[0]['state'];
                    if ($state == "5") {
                        $user_is = "Организатор";
                    } else if ($state == "4") {
                        $user_is = "Админ";
                    } else if ($state == "3") {
                        $user_is = "Столовая";
                    } else if ($state == "2") {
                        $user_is = "Расписание";
                    } else if ($state == "1") {
                        $user_is = "Куратор";
                    } else
            ?>
                    <!-- Основная форма -->
                    <form id="setup">
                        <!-- Заголовок -->
                        <div class="div title_div">
                            <?php
                        echo "<p style='font-size:20px;'>Панель управления КультПульт (" . $user_is . ")</p>"
                            ?>
                        </div>
                        <hr>
                        <?php
                        // уровни - 5 (суперадмин - все), 4 (админ - возможность менять пин-коды), 3 (столовая - общие ведомости), 2 (расписание - Мероприятия), 1 (куратор - ведомости по группе)
                        if ($state == "5") {
                        ?>
                            <input class="btn btn_menu" type="button" id="statements" value="Ведомости">
                            <input class="btn btn_menu" type="button" id="orders" value="Записи">
                            <input class="btn btn_menu" type="button" id="events" value="Мероприятия">
                            <input class="btn btn_menu" type="button" id="participants" value="Участники">
                            <input class="btn btn_menu" type="button" id="users" value="Администрирование">
                            <input class="btn btn_menu" type="button" id="change_password" value="Сменить пароль">
                        <?php
                        }
                        ?>
                        <?php if ($state == "1") {
                        ?>
                            <input class="btn btn_menu" type="button" id="statements" value="Ведомости">
                            <input class="btn btn_menu" type="button" id="orders" value="Записи">
                            <input class="btn btn_menu" type="button" id="change_password" value="Сменить пароль">
                        <?php
                        }
                        ?>
                    </form>
                    <!-- Форма для выхода -->
                    <form action="logout.php">
                        <input class="btn btn_exit" type="submit" id="btn_exit" value="<?= 'Выход (' . $_SESSION['Username'] . ')' ?>">

                    </form>
                    <?php if ($state == "4" || $state == "5") {
                    ?>
                        <p>Мероприятий сегодня: ---</p>
                    <?php
                    }
                    ?>

                <?php
                }
                ?>
                <?php
            }
            // пользователь авторизовался только что
            elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
                $link = connectDB();
                $check_login = userAuth($_POST['username'], $_POST['password']);
                
                // логин и пароль верны, обновляем страницу для отображения панели управления 
                if ($check_login) {
                    $_SESSION['Username'] = $_POST['username'];
                    $_SESSION['LoggedIn'] = 1;
                ?>
                    <form>
                        <div>
                            <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                            <p style='font-size:20px;'>Здравствуйте, <?= $_SESSION['Username'] ?></b>!</p>
                            <div class="ring">
                                <span></span>
                            </div>
                            <meta http-equiv='refresh' content='2;index.php'>
                        </div>
                    </form>
                <?php
                }
                // логин и пароль не верны
                else {
                ?>
                    <form>
                        <div>
                            <p style='color:#E74C3C;' class="login_mes">Ошибка!</p>
                            <p style='font-size:20px;'>Логин или пароль введены неверно.</p>
                            <div class="ring">
                                <span></span>
                            </div>
                            <meta http-equiv='refresh' content='2;index.php'>
                        </div>
                    </form>
                <?php
                }
            }
            // пользователь не авторизован
            else {
                ?>
                <form method="post" action="index.php" name="login_form" id="login_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Панель управления КультПульт</p>
                    </div>
                    <hr>
                    <div class = 'statements_div'>
                        <div>
                            <label for="username" style="font-size:20px;">Логин</label><br><input type="text" name="username" id="username" autofocus>
                        </div>

                        <!-- Пароль -->
                        <div>
                            <label for="password" style="font-size:20px;">Пароль</label><br><input type="password" name="password" id="password" autocomplete="on">
                        </div>

                        <!-- Кнопка входа -->
                        <input class="btn btn_ok" type="submit" name="Login" id="Login" value="Войти">
                    </div>
                    <!-- Логин -->

                </form>
            <?php
            } ?>
        </content>
        <!-- Подвал -->
        <footer>

        </footer>
    </div>
</body>

</html>