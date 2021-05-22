<?php
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";

session_start();

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    $event_name = $_POST['select_events'];
    $participants = getRegisterParticipants($event_name);
    $number = 0;
    $data = array();
    for ($row = 0; $row <= count($participants) - 1; $row++) {
        $temp_id = $participants[$row]['id'];
        $temp_participant = $participants[$row]['surname'] . " " . $participants[$row]['name'] . " " . $participants[$row]['patronymic'];
        $participant = explode(" ", $temp_participant);
        $fio = $participant[0] . " " . substr($participant[1], 0, 2) . "." . substr($participant[2], 0, 2) . ".";
        //$temp_reg_time = getRegTime($temp_code, $date_sql)[0]['reg_time'];
        $result = getRegisteredOnEvent($temp_id, $event_name);
        $number++;
        array_push($data, ["id" => $number, "name" => $fio]);
        }

    if (count($data) > 0) {
        echo json_encode($data);
    }
}
