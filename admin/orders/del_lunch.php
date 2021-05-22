<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    $participant_id = $_POST['participant_id'];
    $participant = getparticipantInfo($participant_id);
    $date = $_POST['date'];

    deleteArchive($participant_id, $participant[0]['pin'], $date);
}
?>