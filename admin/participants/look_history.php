<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    $participant = (string)$_POST['participant_id'];
    $history = getHistory10($participant);
    $number = 0;
    $data = array();
    for ($row = 0; $row <= count($history) - 1; $row++) {
        $temp_name = (string)getparticipantInfo($temp_code)['name'];
        array_push($data, ["date" => $history[$row]['date'], "reg_time" => $history[$row]['reg_time']]);
        $number++;
    }
    if (count($data) > 0) {
        echo json_encode($data);
    }
}
?>