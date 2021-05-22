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
    <script src="../../js/jquery-1.4.3.min.js"></script>
    <script src="../../js/users.js"></script>
    <link rel="stylesheet" href="../../styles/style.css">
    <title>Панель управления</title>
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
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state == "5") {
                $users = getUsers();
            ?>
                <!-- Основная форма -->
                <form action="add.php" method="POST" id="users_form">
                    <div class="div title_div">
                        <p style='font-size:20px;'>Администрирование КультПульт</p>
                    </div>
                    <hr>
                    <table class = 'table_style' id='tab'>
                        <tr class='main_tr_events'>
                            <td>
                                <b>№ п/п</b>
                            </td>
                            <td>
                                <b>Логин</b>
                            </td>
                            <td>
                                <b>Статус</b>
                            </td>
                            <td>
                                <b>ФИО</b>
                            </td>
                            <td>
                                <b>Опции</b>
                            </td>
                        </tr>
                        <?php
                        for ($row = 0; $row < count($users); $row++) {
                            $temp_login = $users[$row]['login'];
                            $temp_state = $users[$row]['state'];
                            $temp_name = $users[$row]['name'];
                            if ($temp_state == "1") {
                                $temp_status = "Куратор";
                            } else if ($temp_state == "2") {
                                $temp_status = "Расписание";
                            } else if ($temp_state == "3") {
                                $temp_status = "Столовая";
                            } else if ($temp_state == "4") {
                                $temp_status = "Админ";
                            } else if ($temp_state == "5") {
                                $temp_status = "Суперадмин";
                            }

                            echo "<tr class = 'events'>";
                            echo "<td>" . (string)($row + 1) . "</td>";
                            echo "<td>" . $temp_login . "</td>";
                            echo "<td>" . $temp_status . "</td>";
                            echo "<td>" . $temp_name . "</td>";
                            echo "<td><img class = 'edit_img' src='../../img/edit.svg' width=15% onclick=" . "editUser('" . $temp_login . "')></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
<!--<div class = 'statements_div'>-->
    <input class="btn btn_menu" type="button" value="Добавить пользователя" id="btn_add_user">
    <input class="btn btn_menu" type="button" value="Добавить куратора" id="btn_add_curator">
<!--</div>-->

                </form>
                <!-- Форма для выхода -->
                <form action="../">
                    <input class="btn btn_back" type="submit" value="Назад">
                </form>

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
        </content>
        <!-- Подвал -->
        <footer>
            
        </footer>
    </div>
</body>

</html>