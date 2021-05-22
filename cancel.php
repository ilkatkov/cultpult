<?php
include_once "functions/mysql.php";

session_start();

$event = $_POST['event'];
$participant_id = $_POST['participant_id'];
//$event = "Краеведческая игротека «Дорога к письменности»";
//$participant_id = "17092001";
deleteArchive($participant_id, $event);

