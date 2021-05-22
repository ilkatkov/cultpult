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
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "2" && $state != "1") {
                $link = connectDB();
                // получаем настройки
                $query_settings = "SELECT * FROM settings";
                $settings_sql = mysqli_query($link, $query_settings);
                for ($settings_data = []; $row = mysqli_fetch_assoc($settings_sql); $settings_data[] = $row);

                $company_name = $settings_data[0]['company_name'];
                $company_fullname = $settings_data[0]['company_fullname'];
                $company_address = $settings_data[0]['company_address'];
                $company_department = $settings_data[0]['company_department'];
                $company_manager = $settings_data[0]['company_manager'];
                $company_director = $settings_data[0]['company_director'];
                $company_resource = $settings_data[0]['company_resource'];
                $company_responsible = $settings_data[0]['company_responsible'];
                $company_contract = $settings_data[0]['company_contract'];
                $company_price = $settings_data[0]['company_price'];
                $dr_number = (string)$settings_data[0]['dr_number'];
            ?>
                <!-- Основная форма -->
                <form action="edit.php" method="post" id="settings_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Ведомости КультПульт</p>
                    </div>
                    <hr>
                    <table class = 'table_settings_style' id='tab'>
                        <tr>
                            <td class='main_td_participants'>Полное название:</td>
                            <td><textarea class='input input_event' name='company_fullname' rows  = "5" style = "resize: none;" required><?=$company_fullname?></textarea></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Краткое название:</td>
                            <td><input type='text' class='input input_event' name='company_name' value='<?= $company_name ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Адрес:</td>
                            <td><input type='text' class='input input_event' name='company_address' value='<?= $company_address ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Отделение:</td>
                            <td><input type='text' class='input input_event' name='company_department' value='<?= $company_department ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Директор:</td>
                            <td><input type='text' class='input input_event' name='company_director' value='<?= $company_director ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Зав. отделением:</td>
                            <td><input type='text' class='input input_event' name='company_manager' value='<?= $company_manager ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Зам. по управл. ресурсами:</td>
                            <td><input type='text' class='input input_event' name='company_resource' value='<?= $company_resource?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Ответственный по питанию:</td>
                            <td><input type='text' class='input input_event' name='company_responsible' value='<?= $company_responsible ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Номер контракта:</td>
                            <td><input type='text' class='input input_event' name='company_contract' value='<?= $company_contract ?>' required></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Цена обеда:</td>
                            <td><input type='text' class='input input_event' name='company_price' value='<?= $company_price ?>' required></td>
                        </tr>
<!--                        <tr>-->
<!--                            <td class='main_td_participants'>Номер столовой:</td>-->
<!--                            <td><input type='number' min=1 class='input input_event' name='dr_number' value='--><?//= $dr_number ?><!--' required></td>-->
<!--                        </tr>-->
                    </table>

                    <input class="btn btn_ok" type="submit" value="Применить">
                </form>
                <!-- Форма для выхода -->
                <form action="./">
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