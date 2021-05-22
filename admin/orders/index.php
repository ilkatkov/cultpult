<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();

$event_id = (string)$_GET['event_id'];

$ready_for_redirect = true;
if (!empty($event_id)){
$ready_for_redirect = false;
}

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
    <script src="../../js/orders.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <title>Записи КультПульт</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <section>
            <?php
            // пользователь уже авторизован
            $state = getState($_SESSION['Username']);
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "2") {

                // redirect if curator
                if ($state == "1" && $ready_for_redirect){
                    $event_id = geteventOnCurator($_SESSION['Username']);
                    header('Location: index.php?event_id=' . $event_id);
                }

                $events = getevents(); // получаем весь список групп
                $times = geteventsTime();
                if (!empty($event_id) && geteventInfo($event_id) == false) {
                    echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
                } else if (empty($event_id)) {
            ?>
                    <!-- Основная форма -->
                    <form id="main_form">
                        <!-- Заголовок -->
                        <div class="div title_div">
                            <p style='font-size:20px;'>Записи КультПульт</p>
                        </div>
                        <hr>
                        <table class = 'table_style' id='tab'>
                            <tr class='main_tr_events'>
                                <td><b>№ п/п</b></td>
                                <td><b>Группа</b></td>
                                <td><b>ФИО куратора</b></td>
                                <td><img class="edit_img" src='../../img/participants.svg'></td>
                                <td><b>Опции</b></td>
                                <?php
                                for ($row = 0; $row < count($events); $row++) {
                                    $temp_event = $events[array_search($times[$row]['id'], array_column($events, 'id'))]['name'];
                                    $temp_curator = $events[array_search($times[$row]['id'], array_column($events, 'id'))]['curator'];
                                    $temp_code = $events[array_search($times[$row]['id'], array_column($events, 'id'))]['id'];
                                    $temp_count = count(getparticipants($temp_code));
                                    $temp_teacher = getTeacher($temp_code);
                                    echo "<tr class = 'events'>";
                                    echo "<td>" . (string)($row + 1) . "</td>";
                                    echo "<td>" . $temp_event . "</td>";
                                    echo "<td>" . $temp_curator . "</td>";
                                    echo "<td>" . $temp_count . "</td>";
                                    echo "<td><img class = 'edit_img' src='../../img/edit.svg' width=15% onclick=" . "editevent('" . $temp_code . "')></td>";
                                    echo "</tr>";
                                }
                                ?>
                        </table>

                        <input class="btn btn_back" type="button" id="btn_back_tab" value="Назад">
                    </form>

                <?php
                } else { // редактируем выбранную группу
                    $choosen_event = geteventInfo($event_id);
                    $choosen_time = $times[array_search($event_id, array_column($times, 'id'))]['time'];
                    $participants_count = count(getparticipants($event_id));
                    $teacher = getTeacher($event_id);
                    if (empty($teacher)) {
                        $teacher = "Выберите преподавателя";
                    }
                    $teachers = getTeachers();
                ?>
                    <form action="edit.php" method="post" id="orders_form">
                        <!-- Заголовок -->
                        <div class="div title_div">
                            <p style='font-size:20px;'>Записи <?= $choosen_event["name"] ?> КультПульт</p>
                        </div>
                        <?php
                        $participants = getparticipants($event_id);
                        $last_date = getDates5()['full'][4];
                        $dates = array('full'=>array(), 'short'=>array());
                        $count = 0; // кол-во дней
                        $n_date = 0; // вычитаем дни
                        while ($count < 14){
                            $date = date_create($last_date);
                            date_sub($date, date_interval_create_from_date_string($n_date. ' days'));
                            if (!(date_format($date, 'w') == '0' || date_format($date, 'w') == '6')){
                                array_push($dates['full'], date_format($date, 'Y-m-d'));
                                array_push($dates['short'], date_format($date, 'd-m'));
                                $count++;
                            }
                            $n_date++;
                        }
                        $dates_short = array_reverse($dates['short']);
                        $dates_full = array_reverse($dates['full']);
                        ?>

                        <table class = 'table_style' id='tab'>
                            <tr class='main_tr_events'>
                                <td>№ п/п</td>
                                <td>Ф.И.О. Студента</td>
                                <?php
                                foreach ($dates_short as $date){
                                    echo "<td>$date</td>";
                                }
                                ?>
                            </tr>
                            <?php
                                $count = 1;
                                foreach ($participants as $participant){
                                    echo "<tr class = 'events'>";
                                    echo "<td>" . $count . "</td>";
                                    echo "<td>" . $participant['surname'] . " " . substr( $participant['name'], 0, 2) . "." . substr( $participant['patronymic'], 0, 2) . "." . "</td>";
                                    for ($i = 0; $i < 14; $i++){
                                        $temp_id = $participant['id'] . "_" . $dates_full[$i];
                                        $temp_checked = checkLunch($participant['id'], $dates_full[$i]);
                                        if ($temp_checked){
                                            echo "<td class = 'td_orders'><input type='checkbox' id = '". $temp_id . "' class = 'checkbox_admin' checked></td>";
                                        }
                                        else{
                                            echo "<td class = 'td_orders'><input type='checkbox' id = '". $temp_id . "' class = 'checkbox_admin'></td>";
                                        }

                                    }
                                    echo "</tr>";
                                    $count++;
                                }
                              ?>
                        </table>
                    </form>
                    <?php
                    if ($state == "1"){
                        echo "<form action='/admin'><input class='btn btn_back' type='submit' value='Назад'></form>";
                    }
                    else {
                        echo "<form action='.'><input class='btn btn_back' type='submit' value='Назад'></form>";
                    }
                    ?>
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
        </section>
        <!-- Подвал -->
        <footer>

        </footer>
    </div>
</body>

</html>