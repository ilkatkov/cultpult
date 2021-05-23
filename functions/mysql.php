<?php
include_once "xml.php";

function getDebug()
{
    $debug = false; // менять при дебаге на true

    if ($debug) {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }

    return $debug;
}

function connectDB()
{
    // установка часового пояса
    date_default_timezone_set('Europe/Moscow');

    // настройки БД
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $db_name = 'cultpult';

    // подключение к БД и установка кодировки UTF-8
    $link = mysqli_connect($host, $user, $password, $db_name);
    mysqli_query($link, "SET NAMES 'utf8'");
    mysqli_query($link, "SET CHARACTER SET 'utf8'");
    mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci'");
    return $link;
}

function getUsers()
{
    // получаем список групп
    $query_users = "SELECT * FROM users";
    $users_sql = mysqli_query(connectDB(), $query_users);
    for ($users_data = []; $row = mysqli_fetch_assoc($users_sql); $users_data[] = $row);
    return $users_data;
}

function getUser($login)
{
    // получаем список групп
    $query_users = "SELECT * FROM users WHERE login = '" . $login . "'";
    $users_sql = mysqli_query(connectDB(), $query_users);
    for ($users_data = []; $row = mysqli_fetch_assoc($users_sql); $users_data[] = $row);
    return $users_data;
}

function getRegisteredOnEvent($ticket, $name)
{
    $link = connectDB();
    $query_events = "SELECT id FROM archive WHERE ticket = '" . mysqli_real_escape_string($link, $ticket) . "' AND event = '" . mysqli_real_escape_string($link, $name) . "'";
    $participant_sql = mysqli_query(connectDB(), $query_events);
    for ($events_data = []; $row = mysqli_fetch_assoc($participant_sql); $events_data[] = $row);
    return $events_data;
}

function checkLunch($id, $date)
{
    $link = connectDB();
    $query_lunch = "SELECT id FROM archive WHERE ticket = '" . mysqli_real_escape_string($link, $id) . "' AND date = '" . mysqli_real_escape_string($link, $date) . "'";
    $sql_lunch = mysqli_query(connectDB(), $query_lunch);
    for ($participant_data = []; $row = mysqli_fetch_assoc($sql_lunch); $participant_data[] = $row);
    return $participant_data;
}

function getRegTime($id, $date)
{
    $link = connectDB();
    $query_lunch = "SELECT reg_time FROM archive WHERE ticket = '" . mysqli_real_escape_string($link, $id) . "' AND date = '" . mysqli_real_escape_string($link, $date) . "'";
    $sql_lunch = mysqli_query(connectDB(), $query_lunch);
    for ($participant_data = []; $row = mysqli_fetch_assoc($sql_lunch); $participant_data[] = $row);
    return $participant_data;
}

function getPin($id)
{
    $link = connectDB();
    $query_pin = "SELECT pin FROM participants WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";
    $sql_pin = mysqli_query(connectDB(), $query_pin);
    for ($participant_data = []; $row = mysqli_fetch_assoc($sql_pin); $participant_data[] = $row);
    return $participant_data;
}

function getId($pin)
{
    $link = connectDB();
    $query_pin = "SELECT id FROM participants WHERE pin = '" . md5(mysqli_real_escape_string($link, $pin . "welcomebelgorod")) . "'";
    $sql_pin = mysqli_query(connectDB(), $query_pin);
    for ($participant_data = []; $row = mysqli_fetch_assoc($sql_pin); $participant_data[] = $row);
    return $participant_data;
}

function getEvent($id)
{
    $link = connectDB();
    $query_pin = "SELECT name FROM events WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";
    $sql_pin = mysqli_query(connectDB(), $query_pin);
    for ($participant_data = []; $row = mysqli_fetch_assoc($sql_pin); $participant_data[] = $row);
    return $participant_data;
}

function getparticipantTime($event)
{
    $link = connectDB();
    $query_events = "SELECT time FROM events WHERE id = '" . mysqli_real_escape_string($link, $event) . "'";
    $events_sql = mysqli_query(connectDB(), $query_events);
    for ($events_data = []; $row = mysqli_fetch_assoc($events_sql); $events_data[] = $row);
    return $events_data;
}

function insertArchive($pin, $event)
{
    $link = connectDB();
    $reg_time = (string)date("d-m-Y_H:i:s");
    $participant_id = getId($pin)[0]['id'];
    $query_insert = "INSERT INTO archive (ticket, participant_id, event, reg_time) VALUES ('" . mysqli_real_escape_string($link, $pin) . "', '" . mysqli_real_escape_string($link, $participant_id) . "', '" . mysqli_real_escape_string($link, $event) . "', '" . mysqli_real_escape_string($link, $reg_time) . "')";
    mysqli_query(connectDB(), $query_insert);
}

function deleteArchive($id, $event)
{
    $link = connectDB();
    $query_delete = "DELETE FROM archive WHERE ticket = '" . mysqli_real_escape_string($link, $id) . "' AND event = '" . mysqli_real_escape_string($link, $event) . "'";
    var_dump($query_delete);
    mysqli_query(connectDB(), $query_delete);
}

function editPin($id, $pin)
{
    $link = connectDB();
    $query_update = "UPDATE participants SET pin = '" . md5(mysqli_real_escape_string($link, $pin . "welcomebelgorod")) . "' WHERE id='" . mysqli_real_escape_string($link, $id) . "'";
    mysqli_query($link, $query_update);
}

function existParticipant($pin)
{
    $link = connectDB();
    $query_select = "SELECT id FROM participants WHERE pin = '" . md5(mysqli_real_escape_string($link, $pin . "welcomebelgorod")) . "'";
    $participant_sql = mysqli_query(connectDB(), $query_select);
    for ($participant_data = []; $row = mysqli_fetch_assoc($participant_sql); $participant_data[] = $row);
    return $participant_data[0]['id'];
}

function existUser($login)
{
    $link = connectDB();
    $query_select = "SELECT state FROM users WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    $user_sql = mysqli_query(connectDB(), $query_select);
    for ($user_data = []; $row = mysqli_fetch_assoc($user_sql); $user_data[] = $row);
    if (count($user_data) > 0) {
        return True;
    } else {
        return False;
    }
}

function existTime($time)
{
    $link = connectDB();
    $query_select = "SELECT id FROM events WHERE time = '" . mysqli_real_escape_string($link, $time) . "'";
    $time_sql = mysqli_query(connectDB(), $query_select);
    for ($time_data = []; $row = mysqli_fetch_assoc($time_sql); $time_data[] = $row);
    if ($time != "00:00") {
        if (count($time_data) > 0) {
            return True;
        } else {
            return False;
        }
    } else {
        return False;
    }
}

function insertUser($login, $state, $name, $password)
{
    $link = connectDB();
    $query_update = "INSERT INTO users (login, state, name, password) VALUES ('" . mysqli_real_escape_string($link, $login) . "', '" . mysqli_real_escape_string($link, $state) . "', '" . mysqli_real_escape_string($link, $name) . "', '" . md5(mysqli_real_escape_string($link, $password)) . "') ON DUPLICATE KEY UPDATE login='" . mysqli_real_escape_string($link, $login) . "', state = '" . mysqli_real_escape_string($link, $state) . "', name = '" . mysqli_real_escape_string($link, $name) . "', password='" . md5(mysqli_real_escape_string($link, $password)) .  "'";
    mysqli_query($link, $query_update) or trigger_error(mysqli_error($link) . $query_update);
}

function insertCurator($name, $login, $event, $password)
{
    $link = connectDB();
    $query_update = "INSERT INTO users (login, name, state, event, password) VALUES ('" . mysqli_real_escape_string($link, $login) . "', '" . mysqli_real_escape_string($link, $name) . "', '1', '" . mysqli_real_escape_string($link, $event) . "', '" . md5(mysqli_real_escape_string($link, $password)) . "') ON DUPLICATE KEY UPDATE login='" . mysqli_real_escape_string($link, $login) . "', name='" . mysqli_real_escape_string($link, $name) . "', state = '1', event = '" . mysqli_real_escape_string($link, $event) . "', password='" . md5(mysqli_real_escape_string($link, $password)) .  "'";
//    var_dump($query_update);
    mysqli_query(connectDB(), $query_update);
}

function updateUser($login, $state, $name, $password)
{
    $link = connectDB();
    if ($password != "") {
        $query_update = "UPDATE users SET state = '" . mysqli_real_escape_string($link, $state) . "', name = '" . mysqli_real_escape_string($link, $name) . "', password='" . md5(mysqli_real_escape_string($link, $password)) .  "' WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    } else {
        $query_update = "UPDATE users SET state = '" . mysqli_real_escape_string($link, $state) . "', name = '" . mysqli_real_escape_string($link, $name) . "' WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    }

    mysqli_query($link, $query_update) or trigger_error(mysqli_error($link) . $query_update);
}

function updateCurator($login, $password)
{
    $link = connectDB();
    $query_update = "UPDATE users SET password='" . md5(mysqli_real_escape_string($link, $password)) .  "', state='1' WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    mysqli_query(connectDB(), $query_update);
}

function deleteUser($login)
{
    $link = connectDB();
    $query_delete = "DELETE FROM users WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    mysqli_query(connectDB(), $query_delete);
}

function deleteEvent($id)
{
    $link = connectDB();
    $query_delete = "DELETE FROM events WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";
    mysqli_query(connectDB(), $query_delete);
}

function getState($login)
{
    $link = connectDB();
    $query_select = "SELECT state FROM users WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    $login_sql = mysqli_query(connectDB(), $query_select);
    for ($login_data = []; $row = mysqli_fetch_assoc($login_sql); $login_data[] = $row);
    return $login_data[0]['state'];
}

function geteventOnCurator($login)
{
    $link = connectDB();
    $query_select = "SELECT event FROM users WHERE login = '" . mysqli_real_escape_string($link, $login) . "'";
    $login_sql = mysqli_query(connectDB(), $query_select);
    for ($login_data = []; $row = mysqli_fetch_assoc($login_sql); $login_data[] = $row);
    return $login_data[0]['event'];
}

function getTeacher($event)
{
    $link = connectDB();
    $query_events = "SELECT teacher FROM events WHERE id = '" . mysqli_real_escape_string($link, $event) . "'";
    $events_sql = mysqli_query(connectDB(), $query_events);
    for ($events_data = []; $row = mysqli_fetch_assoc($events_sql); $events_data[] = $row);
    return $events_data[0]['teacher'];
}

function getAllLunchOnday($date_sql)
{
    $link = connectDB();
    $summa = 0;
    $events = getevents(); // получаем весь список групп
    for ($row = 0; $row <= count($events) - 1; $row++) {
        $temp_code = $events[$row]['id'];
        $time = getTimeOnCode($temp_code)[0]["time"];
        if ($time != "00:00") {
            $query_count = "SELECT COUNT(id) FROM archive WHERE date = '" . $date_sql . "' AND events = '" . $temp_code . "'";
            $count_sql = mysqli_query($link, $query_count);
            for ($count_data = []; $i = mysqli_fetch_assoc($count_sql); $count_data[] = $i);
            $summa = $summa + (int)$count_data[0]["COUNT(id)"];
        }
    }
    return $summa;
}
function getSPOLunchOnday($date_sql)
{
    $link = connectDB();
    $summa = 0;
    $events = getevents(); // получаем весь список групп
    for ($row = 0; $row <= count($events) - 1; $row++) {
        $temp_code = $events[$row]['id'];
        $time = getTimeOnCode($temp_code)[0]["time"];
        $form = getForm($temp_code);
        if ($time != "00:00" && $form == "1") {
            $query_count = "SELECT COUNT(id) FROM archive WHERE date = '" . $date_sql . "' AND events = '" . $temp_code . "'";
            $count_sql = mysqli_query($link, $query_count);
            for ($count_data = []; $i = mysqli_fetch_assoc($count_sql); $count_data[] = $i);
            $summa = $summa + (int)$count_data[0]["COUNT(id)"];
        }
    }
    return $summa;
}


function getHistory10($id)
{
    $link = connectDB();
    $query_history = "SELECT date, reg_time FROM archive WHERE ticket = '" . $id . "' ORDER BY date DESC LIMIT 10";
    $history_sql = mysqli_query($link, $query_history);
    for ($history_data = []; $i = mysqli_fetch_assoc($history_sql); $history_data[] = $i);
    return $history_data;
}

function changeparticipantYear($choise)
{
    $link = connectDB();
    $query_update = "UPDATE adv SET participant_year = '" . mysqli_real_escape_string($link, $choise) . "' WHERE id = 1";
    mysqli_query(connectDB(), $query_update);
}

function checkparticipantYear()
{
    $link = connectDB();
    $query_select = "SELECT participant_year FROM adv";
    $choise_sql = mysqli_query(connectDB(), $query_select);
    for ($choise_data = []; $i = mysqli_fetch_assoc($choise_sql); $choise_data[] = $i);
    return $choise_data;
}



function getRegTime_app()
{
    return (string)date("d-m-Y_H:i:s");
}


function userAuth($username, $password)
{
    $link = connectDB();
    $check_login = mysqli_query($link, "SELECT * FROM users WHERE login = '" . mysqli_real_escape_string($link, $username) . "' AND password = '" . md5(mysqli_real_escape_string($link, $password)) . "'");
    if (mysqli_num_rows($check_login) == 1){
        return true;
    }
}


