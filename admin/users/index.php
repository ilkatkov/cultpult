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
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo_mini.svg" class="logo_img"></a></div>
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
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>
                    <table class = 'table_style' id='tab'>
                        <tr class='main_tr_events'>
                            <td>
                                <b>№</b>
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
    <input class="btn btn_menu1" type="button" value="Добавить пользователя" id="btn_add_user">
    <input class="btn btn_menu2" type="button" value="Добавить куратора" id="btn_add_curator">
<!--</div>-->

                </form>
                <!-- Форма для выхода -->
                <form action="../">
                    <input class="btn mt8px btn_menu3" type="submit" value="Назад">
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