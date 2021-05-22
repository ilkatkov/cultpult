<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$event_id = (string)$_GET['event_id'];

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/jquery-1.4.3.min.js"></script>
    <script src="../../js/events.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
    <title>Мероприятия КультПульт</title>
</head>

<body>
<div class="page">
    <!-- Шапка -->
    <header>
        <div class="logo_div"><a href="/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href="/admin"
                                                                                                     class="admin_link">
                <p class="logo_word">КультПульт</p></a></div>
    </header>
    <!-- Контент -->
    <content>
        <?php
        // пользователь уже авторизован
        $state = getState($_SESSION['Username']);
        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "1") {
            $events = getevents(); // получаем весь список групп
            if (!empty($event_id) && geteventInfo($event_id) == false) {
                echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
            } else if (empty($event_id)) {
                ?>
                <!-- Основная форма -->
                <form id="main_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Мероприятия КультПульт</p>
                    </div>
                    <hr>
<!--                    <table class='table_style' id='tab'>-->
<!--                        <tr class='main_tr_events'>-->
<!--                            <td><b>№ п/п</b></td>-->
<!--                            <td><b>Мероприятие</b></td>-->
<!--                            <td><img class="edit_img" src='../../img/students.svg'></td>-->
<!--                            <td><b>Опции</b></td>-->
<!--                            --><?php
//                            for ($row = 0; $row < count($events); $row++) {
//                                $temp_event = $events[$row]['name'];
//                                $temp_curator = $events[$row]['curator'];
//                                $temp_code = $events[$row]['name'];
//                                $temp_count = count(getRegisterParticipants($temp_code));
//                                echo "<tr class = 'events'>";
//                                echo "<td>" . (string)($row + 1) . "</td>";
//                                echo "<td>" . $temp_event . "</td>";
//                                echo "<td>" . $temp_count . "</td>";
//                                echo "<td><img class = 'edit_img' src='../../img/edit.svg' width=15% onclick=" . "editevent('" . $temp_code . "')></td>";
//                                echo "</tr>";
//                            }
//                            ?>
<!--                    </table>-->
                    <input class="btn btn_back" type="button" id="btn_back_tab" value="Назад">
                </form>
                <?php
            } else { // редактируем выбранную группу
                $choosen_event = geteventInfo($event_id);
                $choosen_time = $times[array_search($event_id, array_column($times, 'id'))]['time'];
                $participants_count = count(getparticipants($event_id));
                $teacher = getTeacher($event_id);
                $form = getForm($event_id);
                if (empty($teacher)) {
                    $teacher = "Выберите преподавателя";
                }
                $teachers = getTeachers();
                ?>
                <form action="edit.php" method="post" id="event_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Мероприятия КультПульт</p>
                    </div>
                    <hr>
                    <table class='table_participants_style' id='tab'>
                        <tr>
                            <td class='main_td_participants'>ID:</td>
                            <td><input type='text' class='input input_event' name='event_id' id="event_id"
                                       value='<?= $event_id ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Группа:</td>
                            <td><input type='text' class='input input_event' name='event_name'
                                       value='<?= $choosen_event["name"] ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Студентов:</td>
                            <td><input type='text' class='input input_event' name='event_count'
                                       value='<?= $participants_count ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Обучение:</td>
                            <td>
                                <select class='input input_event' name="event_form">
                                    <?php
                                    if ($form == "1") {
                                        $old_form = "СПО";
                                        echo "<option value='1'>СПО</option>";
                                        echo "<option value='2'>НПО</option>";
                                    } else if ($form == "2") {
                                        echo "<option value='2'>НПО</option>";
                                        echo "<option value='1'>СПО</option>";
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Время:</td>
                            <td>
                                <input type='time' class='input input_event' name='old_time'
                                       value='<?= $choosen_time ?>' hidden>
                                <input type='time' class='input input_event' name='event_time'
                                       value='<?= $choosen_time ?>' autofocus required>
                            </td>
                        </tr>
                        <!--                            <tr>-->
                        <!--                                <td class = 'main_td_participants'>Преподаватель:</td>-->
                        <!--                                <td>-->
                        <!--                                    <select class='input input_event' name="event_teacher">-->
                        <!--                                        <option disabled selected>-->
                        <?//= $teacher ?><!--</option>-->
                        <!--                                        --><?php
                        //                                        for ($i = 1; $i < count($teachers); $i++) {
                        //                                            echo "<option value = '" . $teachers[$i] . "'>" . $teachers[$i] . "</option>";
                        //                                        }
                        //                                        ?>
                        <!--                                    </select>-->
                        <!--                                </td>-->
                        <!--                            </tr>-->
                        <tr>
                            <td class='main_td_participants'>Куратор:</td>
                            <td><input type='text' class='input input_event' name='event_curator'
                                       value='<?= $choosen_event["curator"] ?>' readonly></td>
                        </tr>
                    </table>
                    <p style="font-size:14px; line-height: 16px;">Если группа не учится,<br>то необходимо поставить
                        время питания 00:00.</p>

                    <!-- Кнопки -->
                    <input class="btn btn_ok" type="submit" value="Применить">
                    <?php if ($state == "5") {
                        ?>
                        <input class="btn btn_menu" type="button" name="btn_create_pin" id="btn_create_pin"
                               value="Сгенерировать PIN-коды">
                        <?php
                    }
                    ?>
                    <input class="btn btn_back" type="button" id="btn_back_edit" value="Назад">
                </form>
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
    </content>
    <!-- Подвал -->
    <footer>

    </footer>
</div>
</body>

</html>