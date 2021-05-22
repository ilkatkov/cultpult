<?php
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";

session_start();

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    $date_sql = $_POST['date'];
    $event_code = $_POST['select_events'];
    // $date_sql = "2021-04-06";
    // $event_code = "1";
    $time = getTimeOnCode($event_code)[0]['time'];
    $participants = getparticipants($event_code);
    $number = 0;
    $data = array();
    for ($row = 0; $row <= count($participants) - 1; $row++) {
        $temp_code = $participants[$row]['id'];
        $temp_participant = $participants[$row]['surname'] . " " . $participants[$row]['name'] . " " . $participants[$row]['patronymic'];
        $participant = explode(" ", $temp_participant);
        $fio = $participant[0] . " " . substr($participant[1], 0, 2) . "." . substr($participant[2], 0, 2) . ".";
        $temp_reg_time = getRegTime($temp_code, $date_sql)[0]['reg_time'];
        $result = getRegisteredOnDate($temp_code, $date_sql);
        if ((count($result) == 1) && ($time != "00:00")) {
            $number++;
            array_push($data, ["id" => $number, "name" => $fio, "reg_time" => $temp_reg_time]);
        }
    }
    if (count($data) > 0) {
        echo json_encode($data);
    }
}
