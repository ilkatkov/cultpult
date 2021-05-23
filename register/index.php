<?php
include_once "../functions/mysql.php";

session_start();


$events = getEvents(); // получаем весь список мероприятий
// в календарь ставим сегодняшнюю дату
$link = connectDB();

$event = $_GET['select_events'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/jquery-1.4.3.min.js"></script>
    <script src="../js/register.js"></script>
    <script src="../js/Chart.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../img/logo_mini.svg" class="logo_img"></a></div>
        </header>
        <!-- Контент -->
        <content>
            <form>
                <div class="div title_div">
                    <p style="font-size:40px; font-family: 'Akrobat';">Участник</p>
                </div>
                <?php
                    if (empty($event)) {
                ?>
                <div class="statement_div">
                    <p style='font-size:30px;margin-bottom:42px;'>Выберите мероприятие,<br> чтобы начать регистрацию"
                    </p>
                    <div class="statement_inputs">
                            <?php
                            echo "<select class='admin_select' id='select_events' name='select_events'>";

                            for ($row = 0; $row < count($events); $row++) {
                                $temp_event = $events[$row]['name'];
                                $temp_id = $events[$row]['id'];
                                echo "<option value = '" . $temp_event . "'> " . $temp_event . " </option>";
                            }
                            echo "</select>";
//                    echo "<input type='hidden' value = '" . $events[0]['date'] . "'>";
                            echo "<input type='text' class='admin_input' value=" . $events[0]['date'] . " name = 'date' id = 'date' autofocus readonly='readonly'>";
                        ?>
                    </div>
                    <input class="btn btn_register" type="submit" value="Начать регистрацию">
                </div>
            </form>
                <?php
                    }
                    else {
                ?>
                        <div class = "register_form" action = "members.php">
<!--                            <div class = "mt8px register_div">Регистрация</div>-->
                            <div class = "register_div2">
                                <div class = "register_div">Выберите ваш район или округ<br><select class='admin_select' id='select_district' name='select_district'><option>Выбрать</option></select></div>
                                <div class = "register_div">Выберите возрастную категорию<br><select class='admin_select' id='select_district' name='select_district'><option>Выбрать</option></select></div>
                                <div class = "register_div">Выберите данные руководителя<br><input type="text" class='admin_input' id='fullname' name='fullname' placeholder="ФИО руководителя коллектива"></div>
                                <div class = "register_div"><input type="text" class='admin_input' id='passport' name='passport' placeholder="Номер паспорта руководителя"></div>
                                <div class = "register_row_div">У вас будут костюмы?<br><input type="checkbox"  id='fullname' name='fullname'></div>
                                <div class = "register_row_div">Вы везете с собой инструменты?<br><input type="checkbox"  id='fullname' name='fullname'></div>
                            </div>
                            <div class = "register_div2">
                                <div class = "register_div">Как называется ваш коллектив?<br><input type="text" class='admin_input' id='fullname' name='fullname' placeholder="Название"></div>
                                <div class = "register_div">Какое учреждение вы представляете?<br><input type="text" class='admin_input' id='fullname' name='fullname' placeholder="Название"></div>
                                <div class = "register_div">Введите контактные данные<br><input type="text" class='admin_input' id='fullname' name='fullname' placeholder="Номер телефона"></div>
                                <div class = "register_div"><input type="text" class='admin_input' id='passport' name='passport' placeholder = "Факс или e-mail"></div>
                                <div class = "register_row_div">Сколько участников в составе вашего коллектива?<br><input class='admin_input' type="number" value = '1' id='fullname'  name='fullname'></div>
                                <input class="btn btn_menu1 reg" type="submit" id="statements" value="Далее">
                            </div>
                        </div>
                        <form action="/">
                            <input class="btn mt8px btn_menu3" type="submit" id="btn_exit" value="Назад">
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