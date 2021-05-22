<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$select_event = $_GET['select_events'];
$select_participant = $_GET['participant_id'];
$event_code = geteventCodeOnName($select_event);
$events = getevents();

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/jquery-1.4.3.min.js"></script>
    <script src="../../js/participants.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <title>Участники КультПульт</title>
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
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && ($state == "4" || $state == "5")) {
                $check_in = in_array($select_event, array_column($events, "name"));
                if (!empty($select_event) && $check_in == false) {
                    echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
                } else if (!empty($select_event)) {
                    $participants = getparticipants($event_code);
            ?>
                    <!-- Основная форма -->
                    <form id="main_form">
                        <!-- Заголовок -->
                        <div class="div title_div">
                            <p style='font-size:20px;'><?= $select_event ?> КультПульт</p>
                        </div>
                        <hr>
                        <table class = 'table_settings_style' id='tab'>
                            <tr class='main_tr_events'>
                                <td><b>№ п/п</b></td>
                                <td><b>ФИО студента</b></td>
                                <td width='50px'><b>Опции</b></td>
                                <?php
                                for ($row = 0; $row < count($participants); $row++) {
                                    echo "<tr class = 'events'>";
                                    echo "<td>" . (string)($row + 1) . "</td>";
                                    echo "<td>" . $participants[$row]['surname'] . " " . substr( $participants[$row]['name'], 0, 2) . "." . substr( $participants[$row]['patronymic'], 0, 2) . "." . "</td>";
                                    echo "<td><img class = 'edit_img' src='../../img/edit.svg' onclick=" . "editparticipant('" . $participants[$row]['id'] . "')></td>";
                                    echo "</tr>";
                                }
                                ?>
                        </table>

                        <input class="btn btn_back" type="button" id="btn_back_tab" value="Назад">

                    </form>
                <?php
                } else if (!empty($select_participant)) { // редактируем выбранного студента
                    $participant_info = getparticipantInfo($select_participant)[0];
                    $full_name = $participant_info['surname'] . " " . substr($participant_info['name'], 0, 2) . "." . substr($participant_info['patronymic'], 0, 2) . ".";
                ?>
                    <form id="participant_form">
                        <!-- Заголовок -->
                        <div class="div title_div">
                            <p style='font-size:20px;'>Участники КультПульт</p>
                        </div>
                        <hr>
                        <table class = 'table_participants_style' id='tab'>
                            <tr>
                                <td class='main_td_participants'>ID:</td>
                                <td><input type='text' class='input input_event' name='participant_id' id="participant_id" value='<?= $select_participant ?>' readonly></td>
                            </tr>
                            <tr>
                                <td class='main_td_participants'>ФИО:</td>
                                <td><input type='text' class='input input_event' name='participant_name' id='participant_name' value='<?= $full_name ?>' readonly></td>
                            </tr>
                            <tr>
                                <td class='main_td_participants'>Группа:</td>
                                <td><input type='text' class='input input_event' name='participant_event' value='<?= getNameOnCode($participant_info["events"]) ?>' readonly></td>
                            </tr>
                        </table>

                        <!-- Кнопки -->
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#btn_story").fancybox({
                                    'titlePosition': 'inside',
                                    'transitionIn': 'none',
                                    'transitionOut': 'none'
                                });
                            }); 
                        </script>

                        <input class="btn btn_ok" type="button" id="btn_story" href="#story" value="История записи">
                        <div style="display: none;">
                            <div id="story" style="width:400px;height:768px;overflow:auto;">
                                <p id="history_data">Загрузка...</p>
                                <table border=1 class="table_module" id="story_table">
                                </table>
                            </div>
                        </div>
                        <input class="btn btn_menu" type="button" id="btn_edit_pin" value="Поменять PIN-код">
                        <input class="btn btn_back" type="button" id="btn_back_edit" value="Назад">
                    </form>
                <?php
                } else {
                ?>
                    <form>
                        <p class="login_mes">Возврат на главную...</p>
                        <!-- <meta http-equiv='refresh' content='1;../index.php'> -->
                    </form>
                <?php
                }
            } else {
                ?>
                <form>
                    <p class="login_mes">Возврат на главную...</p>
                    <!-- <meta http-equiv='refresh' content='1;../index.php'> -->
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